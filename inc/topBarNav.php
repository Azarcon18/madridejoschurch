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

<!-- Include session management -->
<?php 
include 'session.php'; 
?>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container px-4 px-lg-5">
        <button class="navbar-toggler btn btn-sm" type="button" id="navbarToggler" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <a class="navbar-brand" href="<?php echo base_url ?>">
            <img src="uploads/mary.jpg" width="30" height="30" class="d-inline-block align-top" alt="Logo" style="margin-left: 25px;">
            IMMACULATE CONCEPTION
        </a>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-4">
                <li class="nav-item"><a class="nav-link" href="<?php echo base_url ?>">Home</a></li>
                <li class="nav-item"><a class="nav-link" href="<?php echo base_url ?>?p=events">Events</a></li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" aria-expanded="false">Topics</a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="/articles/t/1">Topic 1</a></li>
                        <li><a class="dropdown-item" href="/articles/t/2">Topic 2</a></li>
                    </ul>
                </li>
                <li class="nav-item"><a class="nav-link" href="<?php echo base_url ?>?p=schedule">Schedule</a></li>
                <li class="nav-item"><a class="nav-link" href="<?php echo base_url ?>?p=about">About Us</a></li>
            </ul>
            <div class="d-flex align-items-center">
                <?php if (isset($_SESSION['user_id']) && isset($_SESSION['name'])): ?>
                    <div class="dropdown">
                        <a class="d-flex align-items-center text-decoration-none dropdown-toggle" href="#" id="userDropdown" role="button" aria-expanded="false">
                            
                            <span class="user-name ms-2">Hi, <?php echo htmlspecialchars($_SESSION['name']); ?>!</span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                            <li><a class="dropdown-item" href="<?php echo base_url ?>?p=profile">Profile</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="logout.php">Logout</a></li>
                        </ul>
                    </div>
                <?php else: ?>
                    <a href="login.php" class="btn btn-primary btn-sm">Login</a>
                    <a href="./admin/" class="btn btn-primary btn-sm ms-3">Admin Login</a>
                <?php endif; ?>
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/tesseract.js/2.1.1/tesseract.min.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const navbarToggler = document.getElementById('navbarToggler');
        const navbarCollapse = document.getElementById('navbarSupportedContent');
        const donationButton = document.getElementById('donation');
        const donationModal = new bootstrap.Modal(document.getElementById('donationModal'));
        const scanText = document.getElementById('scanText');
        const qrCode = document.getElementById('qrCode');
        const gcashReceipt = document.getElementById('gcashReceipt');
        const scanningIndicator = document.getElementById('scanningIndicator');
        const donateBtn = document.getElementById('donate-btn');
        let isScanning = false;

        // Toggle navbar on mobile
        navbarToggler.addEventListener('click', function() {
            navbarCollapse.classList.toggle('collapse');
        });

        // Show donation modal
        donationButton.addEventListener('click', function() {
            donationModal.show();
        });

        // Toggle QR code visibility
        scanText.addEventListener('click', function() {
            qrCode.classList.toggle('d-none');
        });

        // Reset form when modal is closed
        document.getElementById('donationModal').addEventListener('hidden.bs.modal', function() {
            document.getElementById('donation-form').reset();
            scanningIndicator.classList.add('d-none');
            isScanning = false;
        });

        // Handle file upload and OCR scanning
        gcashReceipt.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                scanningIndicator.classList.remove('d-none');
                scanningIndicator.innerHTML = 'Scanning receipt...';
                Tesseract.recognize(file, 'eng', { logger: m => scanningIndicator.innerHTML = `Scanning: ${Math.round(m.progress * 100)}%` })
                    .then(({ data: { text } }) => {
                        scanningIndicator.innerHTML = 'Scan complete!';
                        processReceiptText(text);
                    })
                    .catch(err => {
                        scanningIndicator.innerHTML = 'Error during scanning.';
                        console.error(err);
                    });
            }
        });

        // Process OCR result and extract information
        function processReceiptText(text) {
            const amountRegex = /\b(?:Amount|Total)[^\d]*(\d+\.\d{2})/;
            const refRegex = /\b(?:Ref|Reference)[^\d]*(\d+)/;
            const amountMatch = text.match(amountRegex);
            const refMatch = text.match(refRegex);

            if (amountMatch) {
                document.getElementById('donationAmount').value = amountMatch[1];
            }

            if (refMatch) {
                document.getElementById('refNo').value = refMatch[1];
            }
        }

        // Handle donation button click
        donateBtn.addEventListener('click', function() {
            alert('Donation process initiated!');
            donationModal.hide();
        });

        // Toggle user dropdown menu
        const userDropdown = document.getElementById('userDropdown');
        const dropdownMenu = userDropdown.nextElementSibling;

        userDropdown.addEventListener('click', function(e) {
            e.preventDefault(); // Prevent default link behavior
            dropdownMenu.classList.toggle('show');
        });

        // Close dropdown when clicking outside
        document.addEventListener('click', function(e) {
            if (!userDropdown.contains(e.target) && !dropdownMenu.contains(e.target)) {
                dropdownMenu.classList.remove('show');
            }
        });
    });
</script>


</body>
</html>
