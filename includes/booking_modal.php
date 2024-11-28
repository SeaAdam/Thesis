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


<!-- FOR EDIT CLIENT SCHEDULE  -->
<div class="modal fade" id="editClientSchedule">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Client Schedule: <span class="title"></span></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="close">&times;
                </button>
            </div>
            <form action="edit_ClientSchedule.php" method="POST">
                <div class="modal-body">
                    <input type="text" class="ID" name="ID" hidden>
                    <div class="mb-3">
                        <label for="schedule_date" class="form-label">Schedule Date:</label>
                        <input type="date" class="form-control" id="Eschedule_date" name="schedule_date" required>
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

<!-- FOR DELETE CLIENT SCHEDULE -->
<div class="modal fade" id="deleteClientSchedule">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fa fa-info-circle" aria-hidden="true"></i> Please Confirm!</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <form action="delete_client_schedule.php" method="POST">
                    <input type="hidden" class="ID" name="ID">
                    <center>
                        <p> Are you sure to delete this record?</p><br>
                        Schedule Date: <span class="Dschedule_date"></span>
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
                        <input type="text" class="form-control" id="editSlots" name="Slots" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="Slots_Date" class="form-label">Slots Date:</label>
                        <input type="date" class="form-control" id="Slots_Date" name="Slots_Date" required>
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
<div class="modal fade" id="editHoliday">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Holidays:</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="close">&times;
                </button>
            </div>
            <form action="edit_holidays.php" method="POST">
                <div class="modal-body">
                    <input type="text" class="id" name="id" hidden>
                    <div class="mb-3">
                        <label for="holiday" class="form-label">Name of Holiday :</label>
                        <input type="text" class="form-control" id="editHolidays" name="holiday" required>
                    </div>
                    <div class="mb-3">
                        <label for="dateHolidays" class="form-label">Date of Holiday:</label>
                        <input type="date" class="form-control" id="editdateHolidays" name="dateHolidays" required>
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


<!-- FOR DELETE HOLIDAYS -->
<div class="modal fade" id="deleteHolidays">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fa fa-info-circle" aria-hidden="true"></i> Please Confirm!</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <form action="delete_holidays.php" method="POST">
                    <input type="hidden" class="id" name="id">
                    <center>
                        <p> Are you sure to delete this record?</p><br>
                        Name of Holiday : <span class="holiday"></span><br>
                        Date of Holiday : <span class="dateHolidays"></span>
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

<!-- FOR EDIT SERVICES -->
<div class="modal fade" id="editServices">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Services:</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="close">&times;
                </button>
            </div>
            <form action="edit_services.php" method="POST">
                <div class="modal-body">
                    <input type="text" class="ID" name="ID" hidden>
                    <div class="mb-3">
                        <label for="Services" class="form-label">Service :</label>
                        <input type="text" class="form-control" id="editService" name="Services" required>
                    </div>
                    <div class="mb-3">
                        <label for="Cost" class="form-label">Cost :</label>
                        <input type="number" class="form-control" id="editCost" name="Cost" step="0.01" required>
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


<!-- FOR DELETE SERVICES -->
<div class="modal fade" id="deleteServices">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fa fa-info-circle" aria-hidden="true"></i> Please Confirm!</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <form action="delete_services.php" method="POST">
                    <input type="hidden" class="ID" name="ID">
                    <center>
                        <p> Are you sure to delete this record?</p><br>
                        Service : <span class="Service"></span><br>
                        Cost : <span class="Cost"></span>
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

<!-- FOR EDIT CONTACTS -->
<div class="modal fade" id="editContacts">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Contacts:</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="close">&times;
                </button>
            </div>
            <form action="edit_contacts.php" method="POST">
                <div class="modal-body">
                    <input type="hidden" class="ID" name="ID">
                    <div class="mb-3">
                        <label for="ServiceProvider" class="form-label">Service Provider :</label>
                        <input type="text" class="form-control" id="editServiceProvider" name="ServiceProvider"
                            required>
                    </div>
                    <div class="mb-3">
                        <label for="MobileNo" class="form-label">Mobile Number :</label>
                        <input type="text" class="form-control" id="editMobileNo" name="MobileNo" required>
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


<!-- FOR DELETE CONTACTS -->
<div class="modal fade" id="deleteContacts">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fa fa-info-circle" aria-hidden="true"></i> Please Confirm!</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <form action="delete_contacts.php" method="POST">
                    <input type="hidden" class="ID" name="ID">
                    <center>
                        <p> Are you sure to delete this record?</p><br>
                        Service Provider : <span class="ServiceProvider"></span><br>
                        Mobile Number : <span class="MobileNo"></span>
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


<!-- VIEW CLIENTS INFO -->
<div class="modal fade" id="viewClients">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Clients View Record:</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="close">&times;
                </button>
            </div>
            <form>
                <div class="modal-body">
                    <div>
                        <div class="row">
                            <!-- Profile Display Form (Left) -->
                            <div class="col-md-4">
                                <div class="card">
                                    <div class="card-body text-center">
                                        <img src="profile.jpg" class="rounded-circle mb-3" alt="Profile Picture"
                                            width="150" height="150">
                                        <h4 class="client_name"></h4>
                                        <!-- <input type="" class="ID" name="ID"> -->
                                    </div>
                                </div>
                            </div>

                            <!-- Information Display and Update Form (Right) -->
                            <div class="col-md-8">
                                <div class="card">
                                    <div class="card-body">
                                        <table class="table">
                                            <tbody>
                                                <tr>
                                                    <th scope="row">Company Name</th>
                                                    <td>
                                                        <p type="text" class="company_name"></p>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">Position</th>
                                                    <td>
                                                        <p type="text" class="position"></p>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">Contact</th>
                                                    <td>
                                                        <p type="text" class="contact_number"></p>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">Address</th>
                                                    <td>
                                                        <p type="text" class="address"></p>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">Email</th>
                                                    <td>
                                                        <p type="text" class="email_address"></p>
                                                    </td>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- EDIT CLIENTS INFO  -->
<div class="modal fade" id="editClients">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Clients Record:</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="close">&times;
                </button>
            </div>
            <form action="edit_client.php" method="POST">
                <div class="modal-body">
                    <input type="hidden" class="ID" name="ID">
                    <div class="row" style="margin-bottom: 10px;">
                        <div class="col-md-4">
                            <label for="client_name" class="form-label">Client Name:</label>
                            <input type="text" class="form-control" id="Eclient_name" name="client_name" required>
                        </div>
                        <div class="col-md-4">
                            <label for="company_name" class="form-label">Company Name :</label>
                            <input type="text" class="form-control" id="Ecompany_name" name="company_name" required>
                        </div>
                        <div class="col-md-4">
                            <label for="position" class="form-label">Position :</label>
                            <input type="text" class="form-control" id="Eposition" name="position" required>
                        </div>
                    </div>

                    <div class="row " style="margin-bottom: 10px;">
                        <div class="col-md-6">
                            <label for="contact_number" class="form-label">Contact :</label>
                            <input type="text" class="form-control" id="Econtact_number" name="contact_number" required>
                        </div>
                        <div class="col-md-6">
                            <label for="address" class="form-label">Address :</label>
                            <input type="text" class="form-control" id="Eaddress" name="address" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="email_address" class="form-label">Email Address :</label>
                        <input type="text" class="form-control" id="Eemail_address" name="email_address" required>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <label for="Username" class="form-label">Username :</label>
                            <input type="text" class="form-control" id="EUUsername" name="Username" required>
                        </div>
                        <div class="col-md-6">
                            <label for="Password" class="form-label">Password :</label>
                            <input type="password" class="form-control" id="EUPassword" name="Password" required>
                        </div>
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

<!-- DELETE CLIENT INFO  -->
<div class="modal fade" id="deleteClients">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fa fa-info-circle" aria-hidden="true"></i> Please Confirm!</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <form action="delete_clients.php" method="POST">
                    <input type="hidden" class="ID" name="ID">
                    <center>
                        <p> Are you sure to delete this record?</p><br>
                        Client Name : <span class="client_name"></span><br>
                        Username : <span class="Username"></span>
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

<!-- VIEW PATIENTS -->
<div class="modal fade" id="viewPatients">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Patients View Record:</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="close">&times;
                </button>
            </div>
            <form>
                <div class="modal-body">
                    <div>
                        <div class="row">
                            <!-- Profile Display Form (Left) -->
                            <div class="col-md-4">
                                <div class="card">
                                    <div class="card-body text-center">
                                        <img src="profile.jpg" class="rounded-circle mb-3" alt="Profile Picture"
                                            width="150" height="150">
                                        <h4 class="FullName"></h4>
                                        <p class="Email"></p>
                                    </div>
                                </div>
                            </div>

                            <!-- Information Display and Update Form (Right) -->
                            <div class="col-md-8">
                                <div class="card">
                                    <div class="card-body">
                                        <table class="table">
                                            <tbody>
                                                <tr>
                                                    <th scope="row">Gender</th>
                                                    <td>
                                                        <p type="text" class="Gender"></p>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">Age</th>
                                                    <td>
                                                        <p type="text" class="Age"></p>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">Date of Birth</th>
                                                    <td>
                                                        <p type="text" class="DOB"></p>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">Contact</th>
                                                    <td>
                                                        <p type="text" class="Contact"></p>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">PresentAddress</th>
                                                    <td>
                                                        <p type="text" class="PresentAddress"></p>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">Username</th>
                                                    <td>
                                                        <p type="text" class="Username"></p>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- EDIT PATIENTS  -->
<div class="modal fade" id="editPatients">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Patients Record:</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="close">&times;
                </button>
            </div>
            <form action="edit_patients.php" method="POST">
                <div class="modal-body">
                    <input type="hidden" class="ID" name="ID">
                    <div class="row" style="margin-bottom: 10px;">
                        <div class="col-md-4">
                            <label for="FirstName" class="form-label">First Name :</label>
                            <input type="text" class="form-control" id="EFirstName" name="FirstName" required>
                        </div>
                        <div class="col-md-4">
                            <label for="MI" class="form-label">M.I :</label>
                            <input type="text" class="form-control" id="EMI" name="MI" required>
                        </div>
                        <div class="col-md-4">
                            <label for="LastName" class="form-label">Last Name :</label>
                            <input type="text" class="form-control" id="ELastName" name="LastName" required>
                        </div>
                    </div>

                    <div class="row " style="margin-bottom: 10px;">
                        <div class="col-md-4">
                            <label for="Gender">Gender</label>
                            <select id="EGender" class="form-control" name="Gender" required>
                                <option value="" disabled selected>Choose...</option>
                                <option>Male</option>
                                <option>Female</option>
                                <option>Other</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="DOB" class="form-label">Date of Birth :</label>
                            <input type="date" class="form-control" id="EDOB" name="DOB" required>
                        </div>
                        <div class="col-md-4">
                            <label for="Age" class="form-label">Age :</label>
                            <input type="number" class="form-control" id="EAge" name="Age" required>
                        </div>

                    </div>

                    <div class="row" style="margin-bottom: 10px;">
                        <div class="col-md-6">
                            <label for="Contact" class="form-label">Contact :</label>
                            <input type="text" class="form-control" id="EContact" name="Contact" required>
                        </div>
                        <div class="col-md-6">
                            <label for="PresentAddress" class="form-label">Address :</label>
                            <input type="text" class="form-control" id="EPresentAddress" name="PresentAddress" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="Username" class="form-label">Username :</label>
                        <input type="text" class="form-control" id="EUsername" name="Username" required>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <label for="Password" class="form-label">Password :</label>
                            <input type="password" class="form-control" id="EPassword" name="Password" required>
                        </div>
                        <div class="col-md-6">
                            <label for="ConfirmPassword" class="form-label">Confirm Password :</label>
                            <input type="password" class="form-control" id="EConfirmPassword" name="ConfirmPassword"
                                required>
                        </div>

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


<!-- DELETE PATIENTS  -->
<div class="modal fade" id="deletePatients">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fa fa-info-circle" aria-hidden="true"></i> Please Confirm!</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <form action="delete_patients.php" method="POST">
                    <input type="hidden" class="ID" name="ID">
                    <center>
                        <p> Are you sure to delete this record?</p><br>
                        Patient Name : <span class="FullName"></span><br>
                        Username : <span class="Username"></span>
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


<!-- EDIT USER PROFILE PATIENTS -->
<div class="modal fade" id="editUserProfile">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit User Profile:</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="close">&times;</button>
            </div>
            <form action="edit_patients.php" method="POST">
                <div class="modal-body">
                    <input type="text" class="ID" name="ID" hidden>
                    <!-- Form fields for editing user data -->
                    <div class="row" style="margin-bottom: 10px;">
                        <div class="col-md-4">
                            <label for="FirstName" class="form-label">First Name :</label>
                            <input type="text" class="form-control" id="EUFirstName" name="FirstName" required>
                        </div>
                        <div class="col-md-4">
                            <label for="MI" class="form-label">M.I :</label>
                            <input type="text" class="form-control" id="EUMI" name="MI" required>
                        </div>
                        <div class="col-md-4">
                            <label for="LastName" class="form-label">Last Name :</label>
                            <input type="text" class="form-control" id="EULastName" name="LastName" required>
                        </div>
                    </div>
                    <div class="row " style="margin-bottom: 10px;">
                        <div class="col-md-4">
                            <label for="Gender">Gender</label>
                            <select id="EUGender" class="form-control" name="Gender" required>
                                <option value="" disabled selected>Choose...</option>
                                <option>Male</option>
                                <option>Female</option>
                                <option>Other</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="DOB" class="form-label">Date of Birth :</label>
                            <input type="date" class="form-control" id="EUDOB" name="DOB" required>
                        </div>
                        <div class="col-md-4">
                            <label for="Age" class="form-label">Age :</label>
                            <input type="number" class="form-control" id="EUAge" name="Age" required>
                        </div>
                    </div>
                    <div class="row" style="margin-bottom: 10px;">
                        <div class="col-md-6">
                            <label for="Contact" class="form-label">Contact :</label>
                            <input type="text" class="form-control" id="EUContact" name="Contact" required>
                        </div>
                        <div class="col-md-6">
                            <label for="PresentAddress" class="form-label">Address :</label>
                            <input type="text" class="form-control" id="EUPresentAddress" name="PresentAddress"
                                required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="Username" class="form-label">Username :</label>
                        <input type="text" class="form-control" id="EPUsername" name="Username" required>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label for="Password" class="form-label">Password :</label>
                            <input type="password" class="form-control" id="EPPassword" name="Password" required>
                        </div>
                        <div class="col-md-6">
                            <label for="ConfirmPassword" class="form-label">Confirm Password :</label>
                            <input type="password" class="form-control" id="EPConfirmPassword" name="ConfirmPassword"
                                required>
                        </div>
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

<!-- EDIT CLIENT PROFILE -->
<div class="modal fade" id="editClientProfile">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Client Profile:</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="close">&times;</button>
            </div>
            <form action="edit_client.php" method="POST">
                <div class="modal-body">
                    <input type="text" class="ID" name="ID" hidden>
                    <!-- Form fields for editing user data -->
                    <div class="row" style="margin-bottom: 10px;">
                        <div class="col-md-4">
                            <label for="client_name" class="form-label">Client Name:</label>
                            <input type="text" class="form-control" id="ECclient_name" name="client_name" required>
                        </div>
                        <div class="col-md-4">
                            <label for="company_name" class="form-label">Company Name:</label>
                            <input type="text" class="form-control" id="ECcompany_name" name="company_name" required>
                        </div>
                        <div class="col-md-4">
                            <label for="position" class="form-label">Position :</label>
                            <input type="text" class="form-control" id="ECposition" name="position" required>
                        </div>
                    </div>
                    <div class="row " style="margin-bottom: 10px;">
                        <div class="col-md-6">
                            <label for="address" class="form-label">Address :</label>
                            <input type="text" class="form-control" id="ECaddress" name="address" required>
                        </div>
                        <div class="col-md-6">
                            <label for="contact_number" class="form-label">Contact Number:</label>
                            <input type="number" class="form-control" id="ECcontact_number" name="contact_number"
                                required>
                        </div>
                    </div>
                    <div>
                        <label for="email_address" class="form-label">Email :</label>
                        <input type="text" class="form-control" id="ECemail_address" name="email_address" required>
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