<nav class="navbar navbar-expand-lg navbar-light">
    <div class="container px-4 px-lg-5">
        <button class="navbar-toggler btn btn-sm" type="button" data-bs-toggle="collapse"
            data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
            aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <a class="navbar-brand" href="<?php echo base_url ?>">
            <img src="<?php echo validate_image($_settings->info('logo')) ?>" width="30" height="30"
                class="d-inline-white align-top" alt="" loading="lazy">
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
                            <span class="user-name ms-2">Hi, <?php echo htmlspecialchars($_SESSION['user_fullname']); ?>!</span>
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
                        <img id="qrCode" src="uploads/462553492_1073843374233841_8974980054253416195_n.jpg" alt="QR Code" style="display: none; width: 250px; height: 250px;">
                    </div>
                    <div class="mb-3">
                        <label for="gcashReceipt" class="form-label">Upload GCASH Receipt</label>
                        <input type="file" class="form-control" id="gcashReceipt" accept="image/*">
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

<script src="https://cdnjs.cloudflare.com/ajax/libs/tesseract.js/2.1.1/tesseract.min.js"></script>

<script>
   $(function () {
    // Show donation modal on button click
    $('#donation').click(function () {
        $('#donationModal').modal('show');
    });

    // Toggle QR code visibility when "SCAN ME" is clicked
    $('#scanText').click(function () {
        $('#qrCode').toggle();
    });

    // Function to scan GCASH receipt image for reference number and amount
    $('#gcashReceipt').change(function (e) {
        const file = e.target.files[0];
        if (file) {
            Tesseract.recognize(file, 'eng', {
                logger: (m) => console.log(m) // log progress
            }).then(({ data: { text } }) => {
                // Extract the reference number from the OCR text with new format
                const refNumberPattern = /Ref\.?\s*No\.?\s*(\d{4})\s*(\d{3})\s*(\d{6})/i;
                const refNumberMatch = text.match(refNumberPattern);
                if (refNumberMatch) {
                    // Format the reference number with spaces
                    const refNumber = `${refNumberMatch[1]} ${refNumberMatch[2]} ${refNumberMatch[3]}`;
                    $('#refNo').val(refNumber);
                } else {
                    alert('Please Provide Actual GCASH Reciept');
                }

                // Extract the amount paid from the OCR text
                const amountPaidPattern = /(?:Amount|Total Amount Sent)\s*(?:Paid)?\s*(?:PHP|\₱)?\s*(\d+(?:\.\d{2})?)/i;
                const amountPaidMatch = text.match(amountPaidPattern);
                if (amountPaidMatch) {
                    const amountPaid = parseFloat(amountPaidMatch[1]);
                    $('#donationAmount').val(amountPaid);
                } else {
                    alert('Could not detect the amount paid. Please enter manually.');
                }
            }).catch((err) => {
                console.error(err);
                alert('Error processing the image. Please try again.');
            });
        }
    });

    // AJAX form submission for donation
    $('#donate-btn').click(function () {
        if ($('#donation-form')[0].checkValidity()) {
            var donationData = {
                name: $('#donorName').val(),
                email: $('#donorEmail').val(),
                message: $('#donorMessage').val(),
                amount: parseFloat($('#donationAmount').val()),
                ref_no: $('#refNo').val()
            };

            $.ajax({
                url: 'donate.php',
                type: 'POST',
                data: donationData,
                dataType: 'json',
                success: function (response) {
                    alert('Thank you for your donation!');
                    $('#donationModal').modal('hide');
                    $('#donation-form')[0].reset();
                },
                error: function () {
                    alert('Error processing your donation. Please try again.');
                }
            });
        } else {
            $('#donation-form')[0].reportValidity();
        }
    });
});
</script>
