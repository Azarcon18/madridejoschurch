

<div class="container fluid py-5">
    <h1 class="mb-4">Profile</h1>
    <div class="profile-card">
        <div class="row">
            <div class="col-md-3 text-center text-md-start">
                <!--<img src="uploads/<?php echo htmlspecialchars($_SESSION['user_photo']); ?>" alt="User Photo" class="img-thumb">-->
            </div>
            <div class="col-md-9">
                <form>
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="user_name" class="form-label">Name</label>
                            <input type="text" class="form-control-plaintext" id="user_name" value="<?php echo htmlspecialchars($_SESSION['name']); ?>" readonly>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="user_email" class="form-label">Email</label>
                            <input type="email" class="form-control-plaintext" id="user_email" value="<?php echo htmlspecialchars($_SESSION['email']); ?>" readonly>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="user_username" class="form-label">Username</label>
                            <input type="text" class="form-control-plaintext" id="user_username" value="Not Available" readonly>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="user_address" class="form-label">Address</label>
                            <input type="text" class="form-control-plaintext" id="user_address" value="Not Available" readonly>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="user_phone_no" class="form-label">Phone</label>
                            <input type="text" class="form-control-plaintext" id="user_phone_no" value="Not Available" readonly>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>