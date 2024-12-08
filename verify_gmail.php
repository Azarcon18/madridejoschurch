<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify Your Account</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        .swal2-popup {
            border-radius: 8px !important; /* Make the alert rectangular */
            width: auto !important; /* Adjust width for compact view */
            padding: 10px 20px !important; /* Reduce padding */
        }
        .swal2-icon {
            font-size: 7px !important; /* Adjust icon size */
        }
        .swal2-title {
            font-size: 16px !important; /* Smaller font size */
            margin: 0 !important; /* Remove margin */
            display: inline-block;
            vertical-align: middle;
            margin-left: 10px;
        }
    </style>
</head>
<body class="bg-gradient-to-br from-blue-50 to-blue-100 flex justify-center items-center min-h-screen p-4">
    <div class="w-full max-w-md bg-white rounded-2xl shadow-2xl p-8 transform transition-all duration-300 hover:scale-105">
    <div class="flex flex-col items-center mb-8">
            <div class="relative w-full flex justify-end">
                <span id="removeInfoBox" class="text-red-500 cursor-pointer hover:text-red-700">
                    <i class="fas fa-times"></i>
                </span>
            </div>
            <img src="uploads/mary.jpg" alt="Verification" class="w-48 h-48 object-cover mb-6 rounded-xl">
            
            <div id="infoBox" class="text-center bg-yellow-100 border border-yellow-300 p-3 rounded-lg mt-4">
                <p class="text-yellow-800 text-sm">We've sent you an email code, check your spam or inbox to verify your account</p>
            </div>
            
            <h2 class="text-3xl font-bold text-gray-800 text-center mt-4">Verify Your Account</h2>
            <p class="text-gray-500 mt-2 text-center">Enter the 5-digit code sent to your email</p>
        </div>


        <form id="verificationForm" class="space-y-6">
            <div class="flex justify-between space-x-2">
                <input name="code[]" type="text" maxlength="1" required 
                    class="w-16 h-16 text-center text-3xl border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300">
                <input name="code[]" type="text" maxlength="1" required 
                    class="w-16 h-16 text-center text-3xl border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300">
                <input name="code[]" type="text" maxlength="1" required 
                    class="w-16 h-16 text-center text-3xl border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300">
                <input name="code[]" type="text" maxlength="1" required 
                    class="w-16 h-16 text-center text-3xl border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300">
                <input name="code[]" type="text" maxlength="1" required 
                    class="w-16 h-16 text-center text-3xl border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300">
            </div>
            <button type="submit" 
                class="w-full bg-blue-600 text-white py-3 rounded-lg hover:bg-blue-700 transition-colors duration-300 flex items-center justify-center space-x-2">
                <i class="fas fa-check-circle"></i>
                <span>Verify Code</span>
            </button>
        </form>

        <div id="response" class="mt-5 text-center"></div>

        <div class="mt-6 text-center">
            <p class="text-gray-600">Didn't receive the code? <a href="#" class="text-blue-600 hover:underline">Resend</a></p>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('#verificationForm').on('submit', function(e) {
                e.preventDefault(); // Prevent the default form submission

                $.ajax({
                    url: 'verify_code.php',
                    type: 'POST',
                    data: $(this).serialize(),
                    success: function(response) {
                        if (response.includes("successfully")) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Account verified successfully!',
                                position: 'top-end',
                                showConfirmButton: false,
                                timer: 1500,
                                customClass: {
                                    popup: 'swal2-popup'
                                }
                            }).then(() => {
                                window.location.href = 'http://localhost/immaculateconception/login.php';
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: response,
                                position: 'top-end',
                                showConfirmButton: false,
                                timer: 1500,
                                customClass: {
                                    popup: 'swal2-popup'
                                }
                            });
                        }
                    },
                    error: function() {
                        Swal.fire({
                            icon: 'error',
                            title: 'An error occurred while verifying the code.',
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 1500,
                            customClass: {
                                popup: 'swal2-popup'
                            }
                        });
                    }
                });
            });
        });
    </script>
</body>
</html>