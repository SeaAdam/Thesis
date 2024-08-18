<!-- EDIT EVENT  -->
<div class="modal fade" id="edit">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Events: <span class="title"></span></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="close">
                </button>
            </div>
            <form action="event_edit_save.php" method="POST">
                <div class="modal-body">
                    <input type="text" class="ID" name="ID" hidden>
                    <div class="mb-3">
                        <label for="eventTitle" class="form-label">Event Title</label>
                        <input type="text" class="form-control" id="edit_title" name="Title"
                            placeholder="Enter event title" required>
                    </div>
                    <div class="mb-3">
                        <label for="eventDescription" class="form-label">Description</label>
                        <textarea class="form-control" id="edit_description" name="Descriptions" rows="3"
                            placeholder="Enter event description" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="startDate" class="form-label">Start Date</label>
                        <input type="date" class="form-control" id="edit_startDate" name="Start_dates" required>
                    </div>
                    <div class="mb-3">
                        <label for="endDate" class="form-label">End Date</label>
                        <input type="date" class="form-control" id="edit_EndDate" name="End_date" required>
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" name="submit">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>


<!-- FOR EDIT SCHEDULE  -->
<div class="modal fade" id="editSchedule">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Schedule: <span class="title"></span></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="close">&times;
                </button>
            </div>
            <form action="edit_schedule.php" method="POST">
                <div class="modal-body">
                    <input type="text" class="ID" name="ID" hidden>
                    <div class="mb-3">
                        <label for="Slots" class="form-label">Slots:</label>
                        <input type="text" class="form-control" id="editSlots" name="Slots"
                        required>
                    </div>
                    <div class="mb-3">
                        <label for="Slots_Date" class="form-label">Slots Date:</label>
                        <input type="date" class="form-control" id="Slots_Date" name="Slots_Date"
                        required>
                    </div>
                    <div class="mb-3">
                        <label for="Start_Time" class="form-label">Start Time:</label>
                        <input type="time" class="form-control" id="Start_Time" name="Start_Time" required>
                    </div>
                    <div class="mb-3">
                        <label for="End_Time" class="form-label">End Time:</label>
                        <input type="time" class="form-control" id="End_Time" name="End_Time" required>
                    </div>
                    <div class="mb-3">
                        <label for="Durations" class="form-label">Duration:</label>
                        <input type="text" class="form-control" id="editDurations" name="Durations" required>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" name="submit">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>


<!-- FOR DELETE SCHEDULE -->
<div class="modal fade" id="delete">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fa fa-info-circle" aria-hidden="true"></i> Please Confirm!</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <form action="delete_schedule.php" method="POST">
                    <input type="hidden" class="ID" name="ID">
                    <center>
                        <p> Are you sure to delete this record?</p><br>
                        Slots : <span class="Slots"></span><br>
                        Slots Date: <span class="Slots_Date"></span>
                    </center>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-warning" data-dismiss="modal"><i class="fa fa-window-close"></i>
                    No</button>
                <button type="submit" name="submit" class="btn btn-danger"><i class="fa fa-thrash"></i> Yes</button>
            </div>
            </form>
        </div>
    </div>
</div>

<!-- FOR EDIT HOLIDAYS -->
<div class="modal fade" id="editSchedule">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Schedule: <span class="title"></span></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="close">&times;
                </button>
            </div>
            <form action="edit_schedule.php" method="POST">
                <div class="modal-body">
                    <input type="text" class="ID" name="ID" hidden>
                    <div class="mb-3">
                        <label for="Slots" class="form-label">Slots:</label>
                        <input type="text" class="form-control" id="editSlots" name="Slots"
                        required>
                    </div>
                    <div class="mb-3">
                        <label for="Slots_Date" class="form-label">Slots Date:</label>
                        <input type="date" class="form-control" id="Slots_Date" name="Slots_Date"
                        required>
                    </div>
                    <div class="mb-3">
                        <label for="Start_Time" class="form-label">Start Time:</label>
                        <input type="time" class="form-control" id="Start_Time" name="Start_Time" required>
                    </div>
                    <div class="mb-3">
                        <label for="End_Time" class="form-label">End Time:</label>
                        <input type="time" class="form-control" id="End_Time" name="End_Time" required>
                    </div>
                    <div class="mb-3">
                        <label for="Durations" class="form-label">Duration:</label>
                        <input type="text" class="form-control" id="editDurations" name="Durations" required>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" name="submit">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>
