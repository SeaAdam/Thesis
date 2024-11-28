<?php

if (isset($_SESSION['unlocked_pages']['adminAccount.php'])) {
    unset($_SESSION['unlocked_pages']['adminAccount.php']);
}
?>
<!-- sidebar menu -->
<div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
    <div class="menu_section">
        <h3>General</h3>
        <ul class="nav side-menu">
            <li><a href="adminDashboard.php"><i class="fa fa-home"></i> Dashboard </a>
            </li>
            <li><a href="adminBookPatient.php"><i class="fa fa-book"></i> Book Appoinment - Patient
                </a>
            </li>
            <li><a href="adminBookClient.php"><i class="fa fa-book"></i> Book Appoinment - Client
                </a>
            </li>
            <li><a href="adminEvents.php"><i class="fa fa-edit"></i> Events </a>
            </li>
            <li><a href="adminClients.php"><i class="fa fa-desktop"></i> Clients </a>
            </li>
            <li><a><i class="fa fa-table"></i> Client Appointment <span class="fa fa-chevron-down"></span>
                </a>
                <ul class="nav child_menu">
                    <li><a href="apPendingClient.php">Pending</a></li>
                    <li><a href="apApprovedClient.php">Approved</a></li>
                    <li><a href="apCompletedClient.php">Completed</a></li>
                    <li><a href="apRejectedClient.php">Rejected</a></li>
                </ul>
            </li>
            <li><a href="adminPatients.php"><i class="fa fa-desktop"></i> Patients </a>
            </li>
            <li><a><i class="fa fa-table"></i> Patients Appointment <span class="fa fa-chevron-down"></span>
                </a>
                <ul class="nav child_menu">
                    <li><a href="apPending.php">Pending</a></li>
                    <li><a href="apApproved.php">Approved</a></li>
                    <li><a href="apCompleted.php">Completed</a></li>
                    <li><a href="apRejected.php">Rejected</a></li>
                </ul>
            </li>
            <li><a><i class="fa fa-wrench"></i> Maintenance<span class="fa fa-chevron-down"></span>
                </a>
                <ul class="nav child_menu">
                    <li><a href="clientSchedule.php">Client Schedule</a></li>
                    <li><a href="adminSchedule.php">Patient Schedule</a></li>
                    <li><a href="adminHolidays.php">Holidays</a></li>
                    <li><a href="adminServices.php">Services</a></li>
                </ul>
            </li>
            <li><a href="adminContacts.php"><i class="fa fa-phone"></i> Contacts </a>
            </li>
            <li><a href="adminAccount.php"><i class="fa fa-user"></i> Admin Accounts </a>
            </li>
        </ul>
    </div>

</div>
<!-- /sidebar menu -->