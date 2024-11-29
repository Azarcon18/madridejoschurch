<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Responsive Navbar with Donation Form</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
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

        /* Ensures the QR code is centered within the modal */
        #qrCode {
            display: none;
            width: 250px;
            height: 250px;
            margin: 0 auto;
            text-align: center;
        }

        /* Modal Customizations */
        .modal-content {
            border-radius: 10px;
        }
    </style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container px-4 px-lg-5">
        <button class="navbar-toggler btn btn-sm" type="button" data-bs-toggle="collapse"
            data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
            aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <a class="navbar-brand" href="/">
            <img src="logo.png" width="30" height="30" class="d-inline-block align-top" alt="Logo">
            Church Name
        </a>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-4">
                <li class="nav-item"><a class="nav-link" href="/">Home</a></li>
                <li class="nav-item"><a class="nav-link" href="<?php echo base_url ?>?p=events">Events</a></li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" aria-expanded="false">
                        Topics
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="/articles/t/1">Topic 1</a></li>
                        <li><a class="dropdown-item" href="/articles/t/2">Topic 2</a></li>
                    </ul>
                </li>
                <li class="nav-item"><a class="nav-link" href="<?php echo base_url ?>?p=schedule">Schedule</a></li>
                <li class="nav-item"><a class="nav-link" href="/about">About Us</a></li>
            </ul>
            <div class="d-flex align-items-center">
                <a href="/login" class="btn btn-primary btn-sm ms-3">Login</a>
                <button id="donation" class="btn btn-success btn-sm ms-3">Donate</button>
            </div>
        </div>
    </div>
</nav>

<!-- Donation Modal -->
<div class="modal fade" id="donationModal" tabindex="-1" aria-labelledby="donationModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="donationModalLabel">Donation</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="donation-form">
                    <div class="mb-3 text-center">
                        <p id="scanText" class="text-primary" style="cursor: pointer;">SCAN ME</p>
                        <img id="qrCode" src="qr_code.jpg" alt="QR Code">
                    </div>
                    <div class="mb-3">
                        <label for="gcashReceipt" class="form-label">Upload GCASH Receipt</label>
                        <input type="file" class="form-control" id="gcashReceipt" accept="image/*">
                        <div id="scanningIndicator" class="d-none"></div>
                    </div>
                    <div class="mb-3">
                        <label for="donorName" class="form-label">Donor Name</label>
                        <input type="text" class="form-control" id="donorName" placeholder="Enter your name" required>
                    </div>
                    <div class="mb-3">
                        <label for="donorEmail" class="form-label">Donor Email</label>
                        <input type="email" class="form-control" id="donorEmail" placeholder="Enter your email" required>
                    </div>
                    <div class="mb-3">
                        <label for="donationAmount" class="form-label">Donation Amount</label>
                        <input type="number" class="form-control" id="donationAmount" placeholder="Enter your donation amount" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="refNo" class="form-label">Ref No.</label>
                        <input type="text" class="form-control" id="refNo" placeholder="Enter your donation reference number" readonly>
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

<!-- Scripts -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
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
                        <div class="progress mt-2">
                            <div class="progress-bar progress-bar-striped progress-bar-animated" 
                                 role="progressbar" style="width: 0;" aria-valuenow="0" 
                                 aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                `);

                // OCR Scanning (Tesseract)
                Tesseract.recognize(file, 'eng', {
                    logger: function (m) {
                        if (isScanning) {
                            $('.progress-bar').css('width', `${m.progress * 100}%`);
                        }
                    }
                }).then(function (result) {
                    $('#scanningIndicator').addClass('d-none');
                    // Assuming extracted text contains the ref number and donation amount
                    const extractedText = result.data.text;
                    const amountRegex = /(?:\b|\$)(\d+(?:,\d{3})*(?:\.\d{2})?)/;
                    const refRegex = /\b(?:Ref|Reference)[^\d]*(\d+)/;

                    const amountMatch = extractedText.match(amountRegex);
                    const refMatch = extractedText.match(refRegex);

                    if (amountMatch) {
                        $('#donationAmount').val(amountMatch[1]);
                    }

                    if (refMatch) {
                        $('#refNo').val(refMatch[1]);
                    }
                });
            }
        });

        // Donation button click event
        $('#donate-btn').click(function () {
            alert('Donation process initiated!');
        });
    });
</script>

</body>
</html>
