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
  <title>Login</title>
  <script src="./assets/CSS/tailwindcss.js"></script>
  <link rel="stylesheet" type="text/css"
    href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
</head>

<body class="bg-gray-900 min-h-screen flex items-center justify-center">

  <!-- Form Container -->
  <div class="w-full max-w-md bg-[#111827] w- rounded-lg shadow-lg p-8">
    <h2 class="text-2xl font-bold text-center text-gray-100 mb-6">Login</h2>

    <!-- Form Start -->
    <form action="./config/server.php" method="POST" id="login_form" class="space-y-6">
      <!-- First Name -->
      <input type="hidden" name="login" value="1">

      <!-- Email -->
      <div>
        <label for="email" class="block text-gray-400 mb-1 text-sm">Email</label>
        <input type="email" id="email" name="email"
          class="w-full p-2 text-sm bg-gray-800 text-gray-100 rounded-lg border border-gray-700 focus:ring-blue-500 focus:border-blue-500"
          placeholder="Enter your email address">
        <small id="emailerror" class="text-red-600 hidden"> </small>
      </div>



      <!-- Password -->
      <div>
        <label for="password" class="block text-gray-400 mb-1 text-sm">Password</label>
        <input type="password" id="password" name="password"
          class="w-full p-2 text-sm bg-gray-800 text-gray-100 rounded-lg border border-gray-700 focus:ring-blue-500 focus:border-blue-500"
          placeholder="Create a password">
        <small id="passworderror" class="text-red-600 hidden"> </small>
      </div>



      <!-- Submit Button -->
      <div class="w-full flex gap-5">
        <button type="submit" id="login"
          class="w-96  bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 rounded-lg focus:ring-4 focus:ring-blue-300 focus:outline-none">
          Login
          <!-- </button>
        <button class="w-1/2   bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 rounded-lg focus:ring"> <a
            href="index.php"> Go to home </a></button> -->
      </div>
    </form>

    <div class="text-center mt-2">
      <p class="text-gray-400 text-sm">
        don't have an account?
        <a href="Signup.php" class="text-blue-400 hover:underline"> Signup </a>
      </p>
    </div>
    <!-- Form End -->

  </div>

  <!-- <script src="./assets/js/"></script> -->
  <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script> -->
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


    $(document).on("click", "#login", (e) => {
      e.preventDefault();

      let errorCount = 0;
      let email = $("#email").val();

      if (email == "") {
        $("#emailerror").text(" email required field");
        $("#emailerror").removeClass("hidden");
        $("#email").addClass("border border-red-600 ")
        errorCount++;
      }

      let password = $("#password").val();

      if (password == "") {
        $("#passworderror").text(" password required field");
        $("#passworderror").removeClass("hidden");
        $("#password").addClass("border border-red-600 ");
        errorCount++;
      }



      if (errorCount === 0) {
        let form = $("#login_form");
        let url = form.attr("action");
        $.ajax({
          type: "POST",
          url: url,
          data: form.serialize(),
          success: function (response) {
            // console.log(response);
            let arr = JSON.parse(response);
            // console.log(typeof arr);
            if (arr.success == true) {
              toastr.success(arr.massage);
              setTimeout(() => {
                window.location.href = "index.php";
              }, 1500);
            } else {
              if (arr.email_error) {
                $("#emailerror").text(arr.email_error).removeClass("hidden");
                $("#email").addClass("border border-red-500");
              } else {
                $("#emailerror").text("").addClass("hidden");
                $("#email").removeClass("border border-red-500");
              }
              if (arr.password_error) {
                $("#passworderror").text(arr.password_error).removeClass("hidden");
                $("#password").addClass("border border-red-500");
              } else {
                $("#passworderror").text("").addClass("hidden");
                $("#password").removeClass("border border-red-500");
              }
            }
          }
        });
      }
    });



    $(document).on("keyup", "#email", function () {
      let email = $(this).val();
      if (email == "") {
        $("#emailerror").text("required field");
        $("#emailerror").removeClass("hidden");
        $("#email").addClass("border border-red-600 ");
      } else {
        $("#emailerror").text("");
        $("#emailerror").addClass("hidden");
        $("#email").removeClass("border border-red-600 ");

      }
    })
    $(document).on("keyup", "#password", function () {

      let password = $(this).val();
      if (password == "") {
        $("#passworderror").text("required field");
        $("#passworderror").removeClass("hidden");
        $("#password").addClass("border border-red-600 ");
      } else {
        $("#passworderror").text("");
        $("#passworderror").addClass("hidden");
        $("#password").removeClass("border border-red-600 ");

      }
    })
  </script>



</body>

</html>