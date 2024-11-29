<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Donation Modal</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Responsive Styles */
        @media (max-width: 768px) {
            .navbar-brand img {
                width: 25px;
                height: 25px;
            }

            .user-photo {
                width: 25px !important;
                height: 25px !important;
            }

            .modal-dialog {
                margin: 1.75rem auto;
                max-width: 95%;
            }

            #qrCode {
                width: 200px !important;
                height: 200px !important;
            }

            .btn-sm {
                padding: 0.25rem 0.5rem;
                font-size: 0.75rem;
            }
        }

        @media (max-width: 576px) {
            #qrCode {
                width: 150px !important;
                height: 150px !important;
            }

            .scanning-progress {
                font-size: 12px;
            }
        }

        .scanning-progress {
            margin-top: 10px;
            padding: 10px;
            background-color: #f8f9fa;
            border-radius: 4px;
            font-size: 14px;
        }

        .progress {
            height: 4px;
            margin-top: 5px;
        }

        .spinner-wrapper {
            display: inline-block;
            margin-right: 8px;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light">
        <div class="container-fluid px-3 px-lg-5">
            <button class="navbar-toggler btn btn-sm" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <a class="navbar-brand" href="<?php echo base_url ?>">
                <img src="<?php echo validate_image($_settings->info('logo')) ?>" width="30" height="30"
                    class="d-inline-block align-top" alt="" loading="lazy">
                <?php echo $_settings->info('short_name') ?>
            </a>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-4">
                    <li class="nav-item"><a class="nav-link" aria-current="page" href="<?php echo base_url ?>">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?php echo base_url ?>?p=events">Events</a></li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" aria-expanded="false">
                            Topics
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <?php
                            $cat_qry = $conn->query("SELECT * FROM topics WHERE status = 1");
                            while ($crow = $cat_qry->fetch_assoc()):
                            ?>
                                <li><a class="dropdown-item" href="<?php echo base_url ?>?p=articles&t=<?php echo md5($crow['id']) ?>"><?php echo $crow['name'] ?></a></li>
                            <?php endwhile; ?>
                        </ul>
                    </li>
                    <li class="nav-item"><a class="nav-link" href="<?php echo base_url ?>?p=schedule">Schedule</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?php echo base_url ?>?p=about">About Us</a></li>
                </ul>
                <div class="d-flex align-items-center">
                    <?php if (isset($_SESSION['user_logged_in']) && $_SESSION['user_logged_in']): ?>
                        <div class="dropdown">
                            <a class="d-flex align-items-center text-decoration-none dropdown-toggle" href="#" id="userDropdown"
                                role="button" aria-expanded="false">
                                <img src="uploads/<?php echo htmlspecialchars($_SESSION['user_photo']); ?>" alt="User Photo"
                                    class="user-photo rounded-circle" style="width: 30px; height: 30px;">
                                <span class="user-name ms-2 d-none d-md-inline">Hi, <?php echo htmlspecialchars($_SESSION['user_fullname']); ?>!</span>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                                <li><a class="dropdown-item" href="<?php echo base_url ?>?p=profile">Profile</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item" href="logout.php">Logout</a></li>
                            </ul>
                        </div>
                    <?php else: ?>
                        <div class="d-flex">
                            <a href="login.php" class="btn btn-primary btn-sm me-2">Login</a>
                            <a href="./admin/" class="btn btn-primary btn-sm">Admin</a>
                        </div>
                    <?php endif; ?>
                    <button id="donation" class="btn btn-success btn-sm ms-3">Donate</button>
                </div>
            </div>
        </div>
    </nav>

    <!-- Donation Modal -->
    <div class="modal fade" id="donationModal" tabindex="-1" aria-labelledby="donationModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="donationModalLabel">Donation</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="donation-form" novalidate>
                        <div class="mb-3 text-center">
                            <p id="scanText" class="text-primary" style="cursor: pointer;">SCAN ME</p>
                            <img id="qrCode" src="uploads/462553492_1073843374233841_8974980054253416195_n.jpg" alt="QR Code" class="img-fluid" style="display: none; max-width: 250px; max-height: 250px;">
                        </div>
                        <div class="mb-3">
                            <label for="gcashReceipt" class="form-label">Upload GCASH Receipt</label>
                            <input type="file" class="form-control" id="gcashReceipt" accept="image/*">
                            <div id="scanningIndicator" class="d-none"></div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="donorName" class="form-label">Donor Name</label>
                                <input type="text" class="form-control" id="donorName" placeholder="Enter your name" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="donorEmail" class="form-label">Donor Email</label>
                                <input type="email" class="form-control" id="donorEmail" placeholder="Enter your email" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="donationAmount" class="form-label">Donation Amount</label>
                                <input type="number" class="form-control" id="donationAmount" placeholder="Amount" readonly>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="refNo" class="form-label">Ref No.</label>
                                <input type="text" class="form-control" id="refNo" placeholder="Reference Number" readonly>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="donorMessage" class="form-label">Message (optional)</label>
                            <textarea class="form-control" id="donorMessage" rows="3" placeholder="Enter your message"></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="donate-btn">Donate</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Required Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tesseract.js/2.1.1/tesseract.min.js"></script>

    <script>
    $(function () {
        let isScanning = false;
        
        // Show donation modal on button click
        $('#donation').click(function () {
            $('#donationModal').modal('show');
        });

        // Toggle QR code visibility when "SCAN ME" is clicked
        $('#scanText').click(function () {
            $('#qrCode').toggle();
        });

        // Reset form when modal is closed
        $('#donationModal').on('hidden.bs.modal', function () {
            $('#donation-form')[0].reset();
            $('#scanningIndicator').addClass('d-none');
            isScanning = false;
        });

        // Function to scan GCASH receipt image for reference number and amount
        $('#gcashReceipt').change(function (e) {
            const file = e.target.files[0];
            if (file) {
                // Show loading indicator
                isScanning = true;
                $('#scanningIndicator').removeClass('d-none').html(`
                    <div class="scanning-progress">
                        <div class="d-flex align-items-center">
                            <div class="spinner-wrapper">
                                <div class="spinner-border spinner-border-sm text-primary" role="status">
                                    <span class="visually-hidden">Loading...</span>
                                </div>
                            </div>
                            <span class="scanning-text">Initializing scanner...</span>
                        </div>
                        <div class="progress">
                            <div class="progress-bar progress-bar-striped progress-bar-animated" 
                                 role="progressbar" 
                                 style="width: 0%" 
                                 aria-valuenow="0" 
                                 aria-valuemin="0" 
                                 aria-valuemax="100">
                            </div>
                        </div>
                    </div>
                `);

                // Disable form inputs while scanning
                $('#donation-form input, #donation-form textarea, #donate-btn').prop('disabled', true);

                Tesseract.recognize(file, 'eng', {
                    logger: (m) => {
                        console.log(m);
                        // Update progress based on status
                        if (m.status === 'recognizing text') {
                            const progress = Math.round(m.progress * 100);
                            $('.scanning-text').text(`Scanning receipt... ${progress}%`);
                            $('.progress-bar').css('width', `${progress}%`).attr('aria-valuenow', progress);
                        } else if (m.status === 'loading tesseract core') {
                            $('.scanning-text').text('Loading scanner...');
                        } else if (m.status === 'initializing api') {
                            $('.scanning-text').text('Preparing scanner...');
                        } else if (m.status === 'loading language traineddata') {
                            $('.scanning-text').text('Loading language data...');
                        }
                    }
                }).then(({ data: { text } }) => {
                    // Extract the reference number from the OCR text
                    const refNumberPattern = /Ref\.?\s*No\.?\s*(\d{4})\s*(\d{3})\s*(\d{6})/i;
                    const refNumberMatch = text.match(refNumberPattern);
                    if (refNumberMatch) {
                        const refNumber = `${refNumberMatch[1]} ${refNumberMatch[2]} ${refNumberMatch[3]}`;
                        $('#refNo').val(refNumber);
                    } else {
                        alert('Please provide an actual GCash receipt. Reference number not found.');
                    }

                    // Extract the amount paid from the OCR text
                    const amountPaidPattern = /(?:Amount|Total Amount Sent)\s*(?:Paid)?\s*(?:PHP|\₱)?\s*(\d+(?:\.\d{2})?)/i;
                    const amountPaidMatch = text.match(amountPaidPattern);
                    if (amountPaidMatch) {
                        const amountPaid = parseFloat(amountPaidMatch[1]);
                        $('#donationAmount').val(amountPaid);
                    } else {
                        alert('Could not detect the amount paid. Please ensure the receipt shows the amount clearly.');
                    }
                }).catch((err) => {
                    console.error(err);
                    alert('Error processing the image. Please try again with a clearer image.');
                }).finally(() => {
                    // Clean up and reset UI
                    isScanning = false;
                    $('#scanningIndicator').addClass('d-none');
                    // Re-enable form inputs
                    $('#donation-form input, #donation-form textarea, #donate-btn').prop('disabled', false);
                });
            }
        });

        // AJAX form submission for donation
        $('#donate-btn').click(function () {
            if (isScanning) {
                alert('Please wait for the receipt scanning to complete.');
                return;
            }
            
            if ($('#donation-form')[0].checkValidity()) {
                const donationData = {
                    name: $('#donorName').val(),
                    email: $('#donorEmail').val(),
                    message: $('#donorMessage').val(),
                    amount: parseFloat($('#donationAmount').val()),
                    ref_no: $('#refNo').val()
                };

                // Disable form during submission
                $('#donation-form input, #donation-form textarea, #donate-btn').prop('disabled', true);

                $.ajax({
                    url: 'donate.php',
                    type: 'POST',
                    data: donationData,
                    dataType: 'json',
                    success: function (response) {
                        alert('Thank you for your donation!');
                        $('#donation