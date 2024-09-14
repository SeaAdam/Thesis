<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Terms and Conditions Modal</title>
    <!-- Bootstrap 4 CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<!-- Button to trigger Terms and Conditions modal -->
<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#termsModal">
    Open Terms and Conditions
</button>

<!-- Terms and Conditions Modal -->
<div class="modal fade" id="termsModal" tabindex="-1" role="dialog" aria-labelledby="termsModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="termsModalLabel">Terms and Conditions</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Here are the terms and conditions...</p>
                <!-- Checkbox to agree to terms -->
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="agreeCheckbox">
                    <label class="form-check-label" for="agreeCheckbox">
                        I agree to the terms and conditions
                    </label>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Second Modal that opens when checkbox is checked -->
<div class="modal fade" id="nextModal" tabindex="-1" role="dialog" aria-labelledby="nextModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="nextModalLabel">New Modal</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Welcome! You have agreed to the terms and conditions.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap 4 and jQuery dependencies -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<script>
    // When the checkbox is checked, trigger the second modal
    document.getElementById('agreeCheckbox').addEventListener('change', function() {
        if (this.checked) {
            // Hide the Terms modal
            $('#termsModal').modal('hide');

            // Show the next modal
            $('#nextModal').modal('show');
        }
    });

    // Reset checkbox when the terms modal is opened
    $('#termsModal').on('shown.bs.modal', function () {
        // Uncheck the checkbox when the modal is shown
        document.getElementById('agreeCheckbox').checked = false;
    });
</script>

</body>
</html>
