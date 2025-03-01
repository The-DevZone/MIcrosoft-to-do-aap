<!-- <!-- <!DOCTYPE html>
 
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task UI Fullscreen</title>
    <script src="https://cdn.tailwindcss.com"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />        .sidebar {
            transform: translateX(100%);
            transition: transform 0.3s ease-in-out;
        }

        .sidebar.open {
            transform: translateX(0);
        }
    </style>
</head>

<body class="bg-gray-100 min-h-screen flex justify-end">

    <button id="toggleSidebar" class="fixed top-4 right-4 bg-blue-500 text-white px-4 py-2 rounded-lg shadow-lg">Toggle
        Sidebar</button>

    <div id="sidebar" class="sidebar fixed top-0 right-0 w-80 h-full bg-white shadow-lg p-5 overflow-y-auto">
        <div class="border p-3 mb-4">
            <div class="flex items-center mb-3">
                <input type="checkbox" class="form-checkbox text-blue-500 mr-2">
                <strong>s</strong>
                <i class="fa fa-star text-yellow-500 ml-auto"></i>
            </div>
            <a href="#" class="text-blue-500 block mb-3">+ Add step</a>
        </div>

        <div class="flex items-center p-3 hover:bg-gray-200 cursor-pointer">
            <i class="fa fa-sun mr-2"></i> Add to My Day
        </div>

        <div class="border p-3 mb-4">
            <div class="flex items-center p-3 hover:bg-gray-200 cursor-pointer">
                <i class="fa fa-bell mr-2"></i> Remind me
            </div>
            <div class="flex items-center p-3 hover:bg-gray-200 cursor-pointer">
                <i class="fa fa-calendar mr-2"></i> Add due date
            </div>
            <div class="flex items-center p-3 hover:bg-gray-200 cursor-pointer">
                <i class="fa fa-redo mr-2"></i> Repeat
            </div>
        </div>

        <div class="flex items-center p-3 hover:bg-gray-200 cursor-pointer">
            <i class="fa fa-user mr-2"></i> Assign to
        </div>
        <div class="flex items-center p-3 hover:bg-gray-200 cursor-pointer">
            <i class="fa fa-paperclip mr-2"></i> Add file
        </div>
        <div class="flex items-center p-3 hover:bg-gray-200 cursor-pointer">
            <i class="fa fa-sticky-note mr-2"></i> Add note
        </div>

        <p class="text-center text-gray-500 text-sm mt-4">Created today</p>
        <div class="text-right mt-2">
            <i class="fa fa-trash text-red-500 cursor-pointer"></i>
        </div>
    </div>

    <script>
        const sidebar = document.getElementById("sidebar");
        const toggleButton = document.getElementById("toggleSidebar");

        toggleButton.addEventListener("click", function (event) {
            sidebar.classList.toggle("open");
        });

        document.addEventListener("click", function (event) {
            if (!sidebar.contains(event.target) && !toggleButton.contains(event.target)) {
                sidebar.classList.remove("open");
            }
        });
    </script>

</body>

</html> -->



<!-- 
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Text to Input</title>
</head>

<body>

  <p id="text">Click to edit me!</p>
  <button onclick="makeEditable()">Edit</button>

  <script>
    function makeEditable() {
      let textElement = document.getElementById("text");

      // Pehle se input hai to return kar do
      if (textElement.tagName === "INPUT") return;

      // Pehle se jo text tha use store karna
      let currentText = textElement.innerText;

      // Naya input element banana
      let inputElement = document.createElement("input");
      inputElement.type = "text";
      inputElement.value = currentText;

      // Jab user input se bahar click kare (`blur`), tab wapas text me convert karna
      inputElement.addEventListener("blur", function () {
        textElement.innerText = inputElement.value;
        textElement.addEventListener("click", makeEditable);
      });

      // Pehle wale text ko replace karna input field se
      textElement.replaceWith(inputElement);

      // Input me cursor focus karna
      inputElement.focus();
    }
  </script>

</body>

</html> -->


<!-- <!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Right-Click Popup Example</title>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
</head>

<body>

    <button class="help" style="position:absolute; left:100px; top:150px;">Help</button>

    <script>
        $(document).ready(function () {
            $help = $('.help');

            $help.on("contextmenu", function (event) {
                event.preventDefault(); // Default right-click menu ko disable karega

                var x = event.pageX; // Mouse ka X position
                var y = event.pageY; // Mouse ka Y position

                var helpWindow = window.open("", "", "width=200, height=100, left=" + x + ", top=" + y);
                // helpWindow.document.write("<p>Right-click Info text</p>");
            });
        });
    </script>

</body>

</html> -->

$(document).on("click", ".addList", function(e){
    let listName = "Untitled list"
    $.ajax({
        type: "POST",
        url: './config/server.php',
        data: {
            addList: true,
            listName: listName
        },
        success: function(res) {
            let response = JSON.parse(res);
            console.log(response);
            if(response.success){
                let  html = `<li class="flex p-2 rounded-md hover:bg-gray-200 cursor-pointer right-click justify-between items-center" data-id="${response.data['id']}">
                                <i class="fas fa-bars mr-1"></i>
                                <span class="hidden listSpan${response.data['id']} listSpan">${response.data['list_name']}</span>
                                <input class="listInput${response.data['id']} listInput listInputActive bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-white dark:border-gray-600 dark:placeholder-gray-400 dark:text-black dark:focus:ring-blue-500 dark:focus:border-blue-500" type="text" name="list_name" value="${listName}"> 
                            </li>`;
                $(".addListSection").append(html);
                $(".activeInput").attr("data-id",response.data['id']);
                $(".listInput"+response.data['id']).focus().select();
            }
        },
        error: function(res) {
            console.log("this is errror")
        }
    })
})

$(document).click(function(event) {
    // Check if the clicked element is NOT inside .exclude
    if (!$(event.target).closest('.listInputActive').length) {

        let activeInput = $('.activeInput').data('id');
        $('.listInput').addClass('hidden');
        $('.listSpan').removeClass('hidden');
        $(".listInput"+activeInput).focus().select();
        console.log("Clicked outside the excluded area");
        // Run your code here
    }
});