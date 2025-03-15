<?php include("./config/database.php");

if (isset($_SESSION['loginid'])) {
    header('Location: index.php');
}

?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signup</title>
    <!-- <script src="https://unpkg.com/@tailwindcss/browser@4"></script> -->
    <script src="./assets/CSS/tailwindcss.js"></script>
    <link rel="stylesheet" type="text/css"
        href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
</head>

<body class="bg-gray-900 min-h-screen flex items-center justify-center">

    <!-- Form Container -->
    <div class="w-full max-w-md bg-[#111827] rounded-lg shadow-lg p-8">
        <h2 class="text-2xl font-bold text-center  text-gray-100 mb-6">SignUp</h2>

        <!-- Form Start -->
        <form action="./config/server.php" method="POST" id="signup_Form" class="space-y-6">
            <!-- First Name -->
            <input type="hidden" name="signup" value="1">
            <div>
                <label for="firstname" class="block text-gray-400 mb-1 text-sm">First Name</label>
                <input type="text" id="firstname" name="firstname"
                    class="w-full p-2 text-sm bg-gray-800 text-gray-100 rounded-lg border border-gray-700 focus:ring-blue-500 focus:border-blue-500"
                    placeholder="Enter your first name">
                <small id="firstnameerror" class="text-red-600 hidden"> </small>

            </div>

            <!-- Last Name -->
            <div>
                <label for="lastname" class="block text-gray-400 mb-1 text-sm">Last Name</label>
                <input type="text" id="lastname" name="lastname"
                    class="w-full p-2 text-sm bg-gray-800 text-gray-100 rounded-lg border border-gray-700 focus:ring-blue-500 focus:border-blue-500"
                    placeholder="Enter your last name">
                <small id="lastnameerror" class="text-red-600 hidden"> </small>
            </div>

            <!-- Email -->
            <div>
                <label for="email" class="block text-gray-400 mb-1 text-sm">Email</label>
                <input type="email" id="email" name="email"
                    class="w-full p-2 text-sm bg-gray-800 text-gray-100 rounded-lg border border-gray-700 focus:ring-blue-500 focus:border-blue-500"
                    placeholder="Enter your email address">
                <small id="emailerror" class="text-red-600 hidden"> </small>
            </div>

            <!-- Phone Number -->
            <div>
                <label for="phoneno" class="block text-gray-400 mb-1 text-sm">Phone Number</label>
                <input type="tel" id="phoneno" name="phoneno"
                    class="w-full p-2 text-sm bg-gray-800 text-gray-100 rounded-lg border border-gray-700 focus:ring-blue-500 focus:border-blue-500"
                    placeholder="Enter your phone number">
                <small id="phonenoerror" class="text-red-600 hidden"> </small>
            </div>

            <!-- Password -->
            <div>
                <label for="password" class="block text-gray-400 mb-1 text-sm">Password</label>
                <input type="password" id="password" name="password"
                    class="w-full p-2 text-sm bg-gray-800 text-gray-100 rounded-lg border border-gray-700 focus:ring-blue-500 focus:border-blue-500"
                    placeholder="Create a password">
                <small id="passworderror" class="text-red-600 hidden"> </small>
            </div>

            <!-- Confirm Password -->
            <div>
                <label for="confirmpassword" class="block text-gray-400 mb-1 text-sm">Confirm Password</label>
                <input type="password" id="confirmpassword" name="confirmpassword"
                    class="w-full p-2 text-sm bg-gray-800  text-gray-100 rounded-lg border border-gray-700 focus:ring-blue-500 focus:border-blue-500"
                    placeholder="Re-enter your password">
                <small id="confirmpassworderror" class="text-red-600 hidden"> </small>
            </div>

            <!-- Submit Button -->
            <div class="w-full flex gap-5">
                <button type="submit" name="submit"
                    class="w-96  bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 rounded-lg focus:ring-4 focus:ring-blue-300 focus:outline-none"
                    id="signup">
                    SignUp
                </button>
                <!-- <button class="w-1/2   bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 rounded-lg focus:ring">
                    <a href="index.php"> Go to home </a></button> -->
            </div>
        </form>

        <div class="text-center mt-2">
            <p class="text-gray-400 text-sm">
                Already have an account?
                <a href="login.php" class="text-blue-400 hover:underline"> Login</a>
            </p>
        </div>
        <!-- Form End -->

    </div>
    <!-- <script src="./assets/js/jquearymin.js"></script> -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
        integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script type="text/javascript"
        src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>

    <script>

        // toastr start 
        $(document).ready(function () {
            toastr.options = {
                'closeButton': true,
                'debug': false,
                'newestOnTop': false,
                'progressBar': false,
                'positionClass': 'toast-top-right',
                'preventDuplicates': false,
                'showDuration': '1000',
                'hideDuration': '1000',
                'timeOut': '5000',
                'extendedTimeOut': '1000',
                'showEasing': 'swing',
                'hideEasing': 'linear',
                'showMethod': 'fadeIn',
                'hideMethod': 'fadeOut',
            };
        });
        // toastr end

        $(document).on("click", "#signup", function (e) {
            e.preventDefault();

            let firstname = $("#firstname").val().trim();
            let lastname = $("#lastname").val().trim();
            let email = $("#email").val().trim();
            let phoneno = $("#phoneno").val().trim();
            let password = $("#password").val();
            let confirmpassword = $("#confirmpassword").val();

            let errorCount = 0;

            // First Name Validation
            if (firstname === "") {
                $("#firstnameerror").text("Required field").removeClass("hidden");
                $("#firstname").addClass("border border-red-500");
                errorCount++;
            } else {
                $("#firstnameerror").text("").addClass("hidden");
                $("#firstname").removeClass("border border-red-500");
            }

            // Last Name Validation
            if (lastname === "") {
                $("#lastnameerror").text("Required field").removeClass("hidden");
                $("#lastname").addClass("border border-red-500");
                errorCount++;
            } else {
                $("#lastnameerror").text("").addClass("hidden");
                $("#lastname").removeClass("border border-red-500");
            }

            // Email Validation
            let emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
            if (email === "") {
                $("#emailerror").text("Required field").removeClass("hidden");
                $("#email").addClass("border border-red-500");
                errorCount++;
            } else if (!emailPattern.test(email)) {
                $("#emailerror").text("Invalid email format").removeClass("hidden");
                $("#email").addClass("border border-red-500");
                errorCount++;
            } else {
                $("#emailerror").text("").addClass("hidden");
                $("#email").removeClass("border border-red-500");
            }

            // Phone Number Validation
            if (phoneno === "") {
                $("#phonenoerror").text("Required field").removeClass("hidden");
                $("#phoneno").addClass("border border-red-500");
                errorCount++;
            } else {
                $("#phonenoerror").text("").addClass("hidden");
                $("#phoneno").removeClass("border border-red-500");
            }

            // Password Validation
            let validated = true;
            let passwordMessage = "";

            if (password.length < 8) {
                validated = false;
                passwordMessage = "Password must be at least 8 characters.";
            } else if (!/\d/.test(password)) {
                validated = false;
                passwordMessage = "Password must contain at least one number.";
            } else if (!/[a-z]/.test(password)) {
                validated = false;
                passwordMessage = "Password must contain at least one lowercase letter.";
            } else if (!/[A-Z]/.test(password)) {
                validated = false;
                passwordMessage = "Password must contain at least one uppercase letter.";
            } else if (!/[^0-9a-zA-Z]/.test(password)) {
                validated = false;
                passwordMessage = "Password must contain at least one special character.";
            }

            if (!validated) {
                $("#passworderror").text(passwordMessage).removeClass("hidden");
                $("#password").addClass("border border-red-500");
                errorCount++;
            } else {
                $("#passworderror").text("").addClass("hidden");
                $("#password").removeClass("border border-red-500");
            }

            // Confirm Password Validation
            if (confirmpassword === "") {
                $("#confirmpassworderror").text("Required field").removeClass("hidden");
                $("#confirmpassword").addClass("border border-red-500");
                errorCount++;
            } else if (password !== confirmpassword) {
                $("#confirmpassworderror").text("Passwords do not match").removeClass("hidden");
                $("#confirmpassword").addClass("border border-red-500");
                errorCount++;
            } else {
                $("#confirmpassworderror").text("").addClass("hidden");
                $("#confirmpassword").removeClass("border border-red-500");
            }



            if (errorCount == 0) {
                let form = $("#signup_Form");
                let url = form.attr("action");
                $.ajax({
                    type: "POST",
                    url: url,
                    data: form.serialize(),
                    success: function (response) {
                        let arr = JSON.parse(response);
                        if (arr.success == true) {
                            toastr.success(arr.massage);
                            setTimeout(() => {
                                window.location.href = "login.php";
                            }, 500);
                        } else {
                            if (arr.email_error) {
                                $("#emailerror").text(arr.email_error).removeClass("hidden");
                                $("#email").addClass("border border-red-500");
                            } else {
                                $("#emailerror").text("").addClass("hidden");
                                $("#email").removeClass("border border-red-500");
                            }

                            if (arr.phoneno_error) {
                                $("#phonenoerror").text(arr.phoneno_error).removeClass("hidden");
                                $("#phoneno").addClass("border border-red-500");
                            } else {
                                $("#phonenoerror").text("").addClass("hidden");
                                $("#phoneno").removeClass("border border-red-500");
                            }
                        }
                    }

                })
            }
        });



        $(document).on("keyup", "#firstname", function () {
            $firstname = $(this).val();
            if (firstname = "") {
                $("#firstnameerror").text("field is required").removeClass("hidden");
                $("#firstname").addClass("border border-red-500");
            } else {
                $("#firstnameerror").text("field is required").addClass("hidden");
                $("#firstname").removeClass("border border-red-500");
            }
        })
        $(document).on("keyup", "#lastname", function () {
            $firstname = $(this).val();
            if (firstname = "") {
                $("#lastnameerror").text("field is required").removeClass("hidden");
                $("#lastname").addClass("border border-red-500");
            } else {
                $("#lastnameerror").text("field is required").addClass("hidden");
                $("#lastname").removeClass("border border-red-500");
            }
        })
        $(document).on("keyup", "#email", function () {
            $firstname = $(this).val();
            if (firstname = "") {
                $("#emailerror").text("field is required").removeClass("hidden");
                $("#email").addClass("border border-red-500");
            } else {
                $("#emailerror").text("field is required").addClass("hidden");
                $("#email").removeClass("border border-red-500");
            }
        })
        $(document).on("keyup", "#phoneno", function () {
            $firstname = $(this).val();
            if (firstname = "") {
                $("#phonenoerror").text("field is required").removeClass("hidden");
                $("#phoneno").addClass("border border-red-500");
            } else {
                $("#phonenoerror").text("field is required").addClass("hidden");
                $("#phoneno").removeClass("border border-red-500");
            }
        })
        $(document).on("keyup", "#password", function () {
            $firstname = $(this).val();
            if (firstname = "") {
                $("#passworderror").text("field is required").removeClass("hidden");
                $("#password").addClass("border border-red-500");
            } else {
                $("#passworderror").text("field is required").addClass("hidden");
                $("#password").removeClass("border border-red-500");
            }
        })
        $(document).on("keyup", "#confirmpassword", function () {
            $firstname = $(this).val();
            if (firstname = "") {
                $("#confirmpassworderror").text("field is required").removeClass("hidden");
                $("#confirmpassword").addClass("border border-red-500");
            } else {
                $("#confirmpassworderror").text("field is required").addClass("hidden");
                $("#confirmpassword").removeClass("border border-red-500");
            }
        })

    </script>
</body>

</html>