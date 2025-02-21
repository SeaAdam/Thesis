<?php
include 'includes/dbconn.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $transactionId = $_POST['transaction_id'];
    $newDate = $_POST['newDate'];

    // Get the user's ID for this transaction
    $sql = "SELECT user_id FROM appointment_system.transactions WHERE ID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $transactionId);
    $stmt->execute();
    $result = $stmt->get_result();
    $transaction = $result->fetch_assoc();
    $stmt->close();

    if ($transaction) {
        $userId = $transaction['user_id'];

        // Count how many transactions the user has rescheduled
        $sql = "SELECT COUNT(*) AS total_reschedules 
                FROM appointment_system.transactions 
                WHERE user_id = ? AND reschedule_count > 0";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $stmt->bind_result($totalReschedules);
        $stmt->fetch();
        $stmt->close();

        // Get the last reschedule date
        $sql = "SELECT MAX(schedule_id) AS last_reschedule_date 
                FROM appointment_system.transactions 
                WHERE user_id = ? AND reschedule_count > 0";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $result = $stmt->get_result();
        $rescheduleData = $result->fetch_assoc();
        $stmt->close();

        $lastRescheduleDate = $rescheduleData['last_reschedule_date'];
        $oneMonthAgo = date('Y-m-d', strtotime('-1 month'));

        // Restrict rescheduling if user has 2 or more reschedules and last reschedule was within 1 month
        if ($totalReschedules >= 2 && $lastRescheduleDate > $oneMonthAgo) {
            echo "You cannot reschedule again until one month has passed from your last reschedule.";
            exit; // Stop execution
        }

        // Start a transaction to ensure data consistency
        $conn->begin_transaction();

        // Fetch the current time slot value and service_id for the transaction
        $sql = "SELECT t.time_slot_id, s.time_slot, t.service_id 
                FROM appointment_system.transactions t
                JOIN appointment_system.time_slots s ON t.time_slot_id = s.id
                WHERE t.ID = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $transactionId);
        $stmt->execute();
        $result = $stmt->get_result();
        $transaction = $result->fetch_assoc();

        if ($transaction) {
            $oldTimeSlotId = $transaction['time_slot_id'];
            $timeValue = $transaction['time_slot']; // Get the exact time range (e.g., "08:00 - 08:30")
            $serviceType = $transaction['service_id'];

            if ($oldTimeSlotId != 0) {
                // Reset the previous time slot's availability (set isBooked = 0)
                $sql = "UPDATE appointment_system.time_slots SET isBooked = 0 WHERE id = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("i", $oldTimeSlotId);
                $stmt->execute();
            }

            // Increment the slots count for the corresponding service
            $sql = "UPDATE appointment_system.services_table
                    SET slots_count = slots_count + 1 
                    WHERE ID = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $serviceType);
            $stmt->execute();

            // Find a new time slot on the new date with the same time_value
            $newTimeSlotId = null;
            $sql = "SELECT id FROM appointment_system.time_slots 
                    WHERE schedule_id = ? AND time_slot = ? AND isBooked = 0 LIMIT 1";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("is", $newDate, $timeValue);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($row = $result->fetch_assoc()) {
                $newTimeSlotId = $row['id'];

                // Mark the new time slot as booked (isBooked = 1)
                $sql = "UPDATE appointment_system.time_slots SET isBooked = 1 WHERE id = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("i", $newTimeSlotId);
                $stmt->execute();

                // Get the service_id for the new schedule
                $sql = "SELECT service_id FROM appointment_system.time_slots WHERE id = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("i", $newTimeSlotId);
                $stmt->execute();
                $result = $stmt->get_result();
                $row = $result->fetch_assoc();

                if ($row) {
                    $newServiceType = $row['service_id'];

                    // Decrement the slots count for the new service schedule
                    $sql = "UPDATE appointment_system.services_table
                            SET slots_count = slots_count - 1 
                            WHERE ID = ?";
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param("i", $newServiceType);
                    $stmt->execute();
                }
            } else {
                // If no matching time slot is found, set to 0 (so user selects a new one)
                $newTimeSlotId = 0;
            }

            // Update the transaction with the new schedule, same time slot (if available), and new status
            $sql = "UPDATE appointment_system.transactions 
                    SET schedule_id = ?, time_slot_id = ?, status = 'Pending'
                    WHERE ID = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("iii", $newDate, $newTimeSlotId, $transactionId);
            $stmt->execute();

            // Increment the reschedule count for the transaction
            $sql = "UPDATE appointment_system.transactions 
                    SET reschedule_count = reschedule_count + 1 
                    WHERE ID = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $transactionId);
            $stmt->execute();

            $conn->commit();
            echo "Appointment rescheduled successfully!";
        } else {
            echo "Error: Transaction not found.";
        }
    } else {
        echo "Error: Transaction ID not found.";
    }

    $stmt->close();
    $conn->close();
}
?>
