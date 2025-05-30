<?php
include "./config/database.php";

if (!isset($_SESSION['loginid'])) {

  header('Location: login.php');
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Microsoft To-Do Clone</title>
  <script src="./assets/CSS/tailwindcss.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
    integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link rel="stylesheet" href="./assets/CSS/style.css">
  <!-- <link href="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.css" rel="stylesheet" /> -->

  <link rel="stylesheet" type="text/css"
    href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
  <link rel="stylesheet" href="./assets/CSS/flowbite.min.css">
  <script>
    // JavaScript to toggle mobile menu
    function toggleMenu() {
      const menu = document.getElementById('sidebar-menu');

      menu.classList.toggle('hidden');
    }
  </script>

  <link rel="stylesheet" href="./assets/CSS/style.css">
  <style>
    /* width */
    ::-webkit-scrollbar {
      width: 5px;
    }

    /* Track */
    ::-webkit-scrollbar-track {
      /* box-shadow: inset 0 0 5px grey; */
      border-radius: 10px;
    }

    /* Handle */
    ::-webkit-scrollbar-thumb {
      background: black;
      /* border-radius: 1px; */
    }

    /* Handle on hover */
    ::-webkit-scrollbar-thumb:hover {
      background: #b30000;
    }

    /* Media Queries */
    @media (max-width: 768px) {
      .main_screen_size {
        width: 100% !important;
      }

      #sidebar-menu {
        z-index: 1000;
      }

      .task-option {
        flex-direction: column;
        align-items: flex-start;
      }

      .sidebar {
        width: 50% !important;
      }
    }

    @media (max-width: 480px) {
      .sidebar {
        width: 100% !important;
      }

    }
  </style>

</head>

<body class="bg-gray-900 text-gray-100 min-h-screen flex flex-col md:flex-row">
  <!-- Mobile Header -->
  <header class="md:hidden bg-gray-800 p-4 flex justify-between items-center">
    <div class="flex items-center">
      <div class="bg-purple-500 text-white rounded-full w-10 h-10 flex items-center justify-center mr-3">
        RV
      </div>
      <h2 class="text-sm font-semibold">Rohit Verma</h2>
    </div>
    <button onclick="toggleMenu()" class="text-white text-2xl focus:outline-none">
      ☰
    </button>
  </header>
  <!-- Mobile Header -->

  <!-- Sidebar -->
  <aside id="sidebar-menu"
    class="w-full   overflow-y-scroll overflow-x-hidden md:overflow-y-auto relative top-0 left-0 md:w-1/6 bg-gray-800 h-screen md:h-screen p-4  flex-col hidden md:block">
    <div class="flex items-center mb-6 dropSetting">
      <!-- Profile Icon -->
      <div class="bg-purple-500 text-white rounded-full w-10 h-10 flex items-center justify-center mr-3">
        <?php echo $_SESSION["logindata"]["firstname"][0];
        echo $_SESSION["logindata"]["lastname"][0]; ?>
      </div>
      <div>
        <h2 class="text-sm font-semibold"><?php echo $_SESSION["logindata"]["firstname"]; ?></h2>
        <p class="text-xs text-gray-400"><?php echo $_SESSION["logindata"]["email"]; ?></p>
      </div>
    </div>

    <!-- setting start -->
    <div class="w-64  hidden  user_setting">
      <!-- Manage accounts -->
      <div class="flex items-center space-x-3 hover:bg-gray-700 p-3 rounded cursor-pointer manageAccount">
        <i class="fas fa-user-cog fa-lg text-gray-300"></i>
        <span>Manage accounts</span>
      </div>

      <!-- Settings -->
      <div class="flex items-center space-x-3 hover:bg-gray-700 p-3 rounded cursor-pointer">
        <i class="fas fa-cog fa-lg text-gray-300"></i>
        <span>Settings</span>
      </div>

      <!-- Sync -->
      <div class="flex items-center space-x-3 hover:bg-gray-700 p-3 rounded cursor-pointer">
        <i class="fas fa-sync-alt fa-lg text-gray-300"></i>
        <span>Sync</span>
      </div>
    </div>
    <!-- setting end -->

    <!-- Search Bar -->
    <form class="max-w-md mb-3">
      <div class="relative">
        <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
          <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" inert xmlns="http://www.w3.org/2000/svg" fill="none"
            viewBox="0 0 20 20">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
          </svg>
        </div>
        <input type="search" id="default-search"
          class="block w-full p-4 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
          placeholder="Search Mockups, Logos..." required />
        <button type="submit"
          class="text-white absolute end-2.5 bottom-2.5 bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Search</button>

      </div>
    </form>

    <!-- Menu -->
    <ul class="space-y-3 border-b border-gray-200 mb-2 default-list">
      <div class=" active-list cursor-pointer flex items-center justify-between space-x-2 text-blue-400 getDefaultList "
        data-id="MyDay" data-icon="fas fa-sun text-yellow-400 mr-2">
        <li><i class="fas fa-sun"></i>My Day</li>
        <div class="text-white myDayCount"></div>
      </div>
      <div
        class="flex items-center space-x-2 cursor-pointer text-blue-400  getDefaultList removeComplete  justify-between"
        data-id="Important" data-icon="fas fa-star text-yellow-400 mr-2">

        <li class=""> <i class="fas fa-star"></i>Important</li>
        <div class="text-white ImportantCount"></div>
      </div>
      <div class="flex items-center space-x-2 cursor-pointer text-blue-400  getDefaultList" data-id="Planned"
        data-icon="fas fa-calendar-alt text-blue-800 mr-2">
        <li> <i class="fas fa-calendar-alt"></i>Planned
        </li>
        <div class="text-white PlannedCount"></div>
      </div>
      <div class="flex items-center space-x-2 cursor-pointer text-blue-400  getDefaultList" data-id="all"
        data-icon="fas fa-infinity text-green-300 mr-2">
        <li> <i class="fas fa-infinity"></i> All</li>
        <div class="text-white allCount"></div>
      </div>
      <div>
        <li class="flex items-center space-x-2 cursor-pointer text-blue-400  getDefaultList " data-id="completed"
          data-icon="fas fa-check-circle  text-red-500 mr-2"><i class="fas fa-check-circle"></i>
          Completed</li>
        <div class="text-white completedCount"></div>
      </div>
      <div>
        <li class="flex items-center space-x-2 cursor-pointer text-blue-400  getDefaultList" data-id="tasks"
          data-icon="fas fa-calendar-check text-rose-950 mr-2"> <i class="fas fa-calendar-check"></i> Tasks</li>
        </li>
        <div class="text-white tasksCount"></div>
      </div>
    </ul>
    <!-- Menu -->
    <nav>
      <input type="hidden" class="activeInput">
      <ul class="space-y-2 px-1 pb-10 " id="addList"></ul>
      <div class=" context-menu-new-list hidden absolute w-52 bg-gray-800 text-white rounded-lg shadow-lg z-50">
        <ul class="py-2">
          <li class="flex items-center px-4 py-2 hover:bg-gray-700 cursor-pointer  renamelist ">
            <span class="mr-3">✏️</span> Rename list <span class="ml-auto text-gray-400">F2</span>
          </li>
          <li class="flex items-center px-4 py-2 hover:bg-gray-700 cursor-pointer">
            <span class="mr-3">👥</span> Share list
          </li>
          <li class="flex items-center px-4 py-2 hover:bg-gray-700 cursor-pointer">
            <span class="mr-3">🖨️</span> Print list
          </li>
          <li class="flex items-center px-4 py-2 hover:bg-gray-700 cursor-pointer">
            <span class="mr-3">📧</span> Email list
          </li>
          <li class="flex items-center px-4 py-2 hover:bg-gray-700 cursor-pointer">
            <span class="mr-3">📌</span> Pin to Start
          </li>
          <li class="flex items-center px-4 py-2 hover:bg-gray-700 cursor-pointer">
            <span class="mr-3">📄</span> Duplicate list
          </li>
          <li data-modal-target="deletesidelist" data-modal-toggle="deletesidelist"
            class="flex items-center px-4 py-2 text-red-500 hover:bg-gray-700 cursor-pointer border-t border-gray-600">
            <span class="mr-3">🗑️</span> Delete list <span class="ml-auto text-gray-400">Delete</span>
          </li>
        </ul>
      </div>
    </nav>

    <!-- delete modal box -->
    <div id="deletesidelist" tabindex="-1" aria-hidden="true"
      class="hidden close_modallist overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-modal md:h-full">
      <div class="relative p-4 w-full max-w-md h-full md:h-auto">
        <!-- Modal content -->
        <div class="relative p-4 text-center bg-white rounded-lg shadow dark:bg-gray-800 sm:p-5">
          <button type="button"
            class="  text-gray-400 absolute top-2.5 right-2.5 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white"
            data-modal-toggle="deletesidelist">
            <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
              xmlns="http://www.w3.org/2000/svg">
              <path fill-rule="evenodd"
                d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                clip-rule="evenodd"></path>
            </svg>
            <span class="sr-only ">Close modal</span>
          </button>
          <svg class="text-gray-400 dark:text-gray-500 w-11 h-11 mb-3.5 mx-auto" aria-hidden="true" fill="currentColor"
            viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
            <path fill-rule="evenodd"
              d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
              clip-rule="evenodd"></path>
          </svg>
          <p class="mb-4 text-gray-500 dark:text-gray-300">Are you sure you want to delete this item?</p>
          <div class="flex justify-center items-center space-x-4">
            <button data-modal-toggle="deletesidelist" type="button"
              class="py-2 px-3 text-sm font-medium text-gray-500 bg-white rounded-lg border border-gray-200 hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-primary-300 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">
              No, cancel
            </button>
            <button type="submit" id="closemodallist"
              class=" deletelist py-2 px-3 text-sm font-medium text-center text-white bg-red-600 rounded-lg hover:bg-red-700 focus:ring-4 focus:outline-none focus:ring-red-300 dark:bg-red-500 dark:hover:bg-red-600 dark:focus:ring-red-900">
              Yes, I'm sure
            </button>
          </div>
        </div>
      </div>
    </div>
    <!-- delete modal  -->

    <button id="newList"
      class="text-sm bg-blue-950  fixed bottom-0 -left-2 hover:bg-blue-950 px-2 py-2 w-64  text-blue-500 hover:underline flex items-center h-38  space-x-2">
      <span class=" text-white">➕</span>
      <span class="text-white ">New list</span>
    </button>

    <!-- contextmenu left side list  -->
  </aside>
  <!-- Sidebar -->

  <!-- Main Content -->
  <main class="  px-3  py-4 w-full main_screen_size h-screen overflow-y-scroll overflow-x-hidden" is_open="0">
    <!-- Header -->
    <div class="flex justify-between items-center mb-6">
      <div class="">
        <h1 class="text-2xl font-bold taskHeader ">My Day</h1>
      </div>
      <span class="text-gray-400 max-sm:hidden">Friday, 17 January</span>
      <button id="downloadExcel" class="btn btn-success">Download Tasks </button>
      <div>


        <!-- <?php if (isset(($_SESSION['loginid'])) && !empty($_SESSION['loginid'])) { ?>

          <form action="./config/server.php" method="post" id="logout_form">
             <?php echo ($_SESSION['logindata']['firstname']); ?></span> 


            <button type="submit" name="logout" data-tooltip-target="tooltip-default"
              class="text-red-700 hover:text-white border border-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2 dark:border-red-500 dark:text-red-500 dark:hover:text-white dark:hover:bg-red-600 dark:focus:ring-red-900 cursor-pointer">Logout</button>
            <div id="tooltip-default" role="tooltip"
              class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-xs opacity-0 tooltip dark:bg-gray-700">
              logout
              <div class="tooltip-arrow" data-popper-arrow></div>
            </div>
          </form>
        <?php } else { ?>
          <span class="p-2 bg-blue-800 rounded-lg ml-2"><a href="login.php">Login</a></span>
          <span class="p-2 hover:bg-blue-800 rounded-lg ml-2"> <a href="signup.php"> SignUp </a></span>
        <?php } ?> -->
      </div>
    </div>
    <!-- Header -->

    <!-- display render data  -->
    <div id="display-data" class="">
      <div class="text-center  overflow-hidden task-option  deletebtn removeTask${element.id} sidebarmenu"
        data-id="${element.id}">
        <div
          class="flex justify-between border w-full border-black  bg-gray-800 text-white rounded mb-2 p-2 items-center">
          <div class="flex items-center space-x-2">
            <div class="check taskCompleted" data-id="${element.id}" don-task="${element.is_don}">
              <input type="checkbox" class="mr-2  ${isDon}">
            </div>
            <p class="newtask">${element.tasks_name}</p>
          </div>
          <div class="star-btn ${is_imp}  hover:text-yellow-300 taskImp taskImps${element.id}" data-id="${element.id}"
            data-imp="${element.is_imp}">
            <i class="  fa-regular fa-star"> </i>
          </div>
        </div>
        <div>hello</div>
      </div>
    </div>
    </div>

    </div>


    <!-- </div> -->
    <div class="w-full compHide">
      <button id="dropdown-btn" class="bg-blue-600 text-white px-4 py-2 rounded-md focus:outline-none">
        <span class=" arrowDown "><i class="fas fa-chevron-down text-white text-lg"></i></span>
        <span class=" arrowRight hidden "><i class="fas fa-angle-right text-white text-lg"></i></span>
        completed
        <span class="countComp"></span>
      </button>
      <div id="CompTasks" class="" data-id="menuComp" tag="1"> </div>
    </div>
    <!-- display render data -->

    <!-- delete modal box -->
    <div id="deleteModal" tabindex="-1" aria-hidden="true"
      class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-modal md:h-full">
      <div class="relative p-4 w-full max-w-md h-full md:h-auto">
        <!-- Modal content -->
        <div class="relative p-4 text-center bg-white rounded-lg shadow dark:bg-gray-800 sm:p-5">
          <button type="button"
            class="close text-gray-400 absolute top-2.5 right-2.5 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white"
            data-modal-toggle="deleteModal">
            <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
              xmlns="http://www.w3.org/2000/svg">
              <path fill-rule="evenodd"
                d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                clip-rule="evenodd"></path>
            </svg>
            <span class="sr-only">Close modal</span>
          </button>
          <svg class="text-gray-400 dark:text-gray-500 w-11 h-11 mb-3.5 mx-auto" aria-hidden="true" fill="currentColor"
            viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
            <path fill-rule="evenodd"
              d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
              clip-rule="evenodd"></path>
          </svg>
          <p class="mb-4 text-gray-500 dark:text-gray-300">Are you sure you want to delete this item?</p>
          <div class="flex justify-center items-center space-x-4">
            <button data-modal-toggle="deleteModal" type="button"
              class="py-2 px-3 text-sm font-medium text-gray-500 bg-white rounded-lg border border-gray-200 hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-primary-300 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">
              No, cancel
            </button>
            <button type="submit" id="close_modal"
              class=" deletetasklist  py-2 px-3 text-sm font-medium text-center text-white bg-red-600 rounded-lg hover:bg-red-700 focus:ring-4 focus:outline-none focus:ring-red-300 dark:bg-red-500 dark:hover:bg-red-600 dark:focus:ring-red-900">
              Yes, I'm sure
            </button>
          </div>
        </div>
      </div>
    </div>
    <!-- delete modal box -->

    <!-- Add Task Input -->
    <div class="fixed bottom-2 w-10/12  removecomp" is_open="0">
      <form action="./config/server.php" method="post" id="taskform" class="bg-gray-800 rounded-lg flex items-end  p-2">
        <input type="hidden" name="task_submit" value="1">
        <input type="hidden" name="user_id" value="<?php echo $_SESSION['loginid']; ?>">
        <div class="relative w-full">
          <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none" id="empty_input">
            <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" inert xmlns="http://www.w3.org/2000/svg" fill="none"
              viewBox="0 0 18 20">
              <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M3 5v10M3 5a2 2 0 1 0 0-4 2 2 0 0 0 0 4Zm0 10a2 2 0 1 0 0 4 2 2 0 0 0 0-4Zm12 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4Zm0 0V6a3 3 0 0 0-3-3H9m1.5-2-2 2 2 2" />
            </svg>
          </div>
          <input type="text" id="taskinput" name="taskinput"
            class=" task_input  bg-gray-50 border  border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
            placeholder="Search branch name..." />
        </div>
        <!-- Right: Font Awesome Icons -->
        <div class="flex items-center space-x-5 text-white text-2xl cursor-pointer ">
          <!-- Home Icon + Text -->
          <div class="flex items-center space-x-1">
            <i class="fas fa-house"></i>
            <span>Tasks</span>
          </div>

          <!-- Calendar Icon -->
          <div class="relative todayCalendar flex  ">
            <i class="fas fa-calendar-days"></i>
            <span class="showDay mx-2"></span>
          </div>
          <!-- click funcanality set days -->
          <div
            class="setTasksClander hidden w-64 bg-gray-800 absolute bottom-[103%] right-2 text-white rounded-lg shadow-md p-2 ">
            <!-- Today -->
            <div class="flex justify-between items-center hover:bg-gray-700 p-2 rounded-md cursor-pointer">
              <div class="flex items-center space-x-2 setToday"  data-day="Today">
                <i class="fas fa-calendar-day text-gray-400"></i>
                <span >Today</span>
              </div>
              <span class="text-gray-400">Fri</span>
            </div>

            <!-- Tomorrow -->
            <div class="flex  justify-between items-center hover:bg-gray-700 p-2 rounded-md cursor-pointer">
              <div class="flex items-center space-x-2 setToday " data-day="Tomorrow">
                <i class="fas fa-arrow-right text-gray-400"></i>
                <span>Tomorrow</span>
              </div>
              <span class="text-gray-400">Sat</span>
            </div>

            <!-- Next Week -->
            <div class="flex justify-between items-center hover:bg-gray-700 p-2 rounded-md cursor-pointer">
              <div class="flex items-center space-x-2 setToday">
                <i class="fas fa-forward text-gray-400"></i>
                <span>Next week</span>
              </div>
              <span class="text-gray-400">Sun</span>
            </div>

            <hr class="my-2 border-gray-600" />

            <!-- Pick a date -->
            <div class="flex items-center space-x-2 hover:bg-gray-700 p-2 rounded-md pickDate cursor-pointer"
              data-day="PickDate">
              <i class="fas fa-calendar-alt text-gray-400"></i>
              <span>Pick a date</span>
            </div>
          </div>
          <!-- click funcanality set days -->


          <!-- Clock Icon -->
          <div class="clockDateAndTime">
            <i class="fas fa-clock"></i>
          </div>
          <!-- pick a date and time -->
          <div
            class="w-64 pickTime hidden absolute bottom-[103%] right-2 bg-gray-800 rounded shadow-lg text-white border border-gray-700">
            <ul>
              <!-- Later today -->
              <li class="flex justify-between items-center px-4 py-3 hover:bg-gray-700 cursor-pointer">
                <div class="flex items-center gap-2">
                  <span>⏰</span>
                  <span>Later today</span>
                </div>
                <span class="text-sm text-gray-400">6:00 AM</span>
              </li>

              <!-- Tomorrow -->
              <li class="flex justify-between items-center px-4 py-3 hover:bg-gray-700 cursor-pointer">
                <div class="flex items-center gap-2">
                  <span>➡️</span>
                  <span>Tomorrow</span>
                </div>
                <span class="text-sm text-gray-400">Sun, 9:00 AM</span>
              </li>

              <!-- Pick a date & time -->
              <li class="flex items-center gap-2 px-4 py-3 hover:bg-gray-700 cursor-pointer">
                <span>📅</span>
                <span>Pick a date & time</span>
              </li>
            </ul>
          </div>
          <!-- pick a date and time -->

          <!-- Replay Icon -->
          <div class="repeatTaskButton">
            <i class="fas fa-rotate-left"></i>
          </div>
          <!-- Repeat options -->
          <div
            class=" repeatTask hidden absolute bottom-[103%] right-2 mt-4 w-64 bg-gray-800 rounded shadow-lg text-white border border-gray-700">
            <ul>
              <!-- Daily -->
              <li class="flex items-center gap-2 px-4 py-3 hover:bg-gray-700 cursor-pointer">
                <span>🔲</span>
                <span>Daily</span>
              </li>

              <!-- Weekdays -->
              <li class="flex items-center gap-2 px-4 py-3 hover:bg-gray-700 cursor-pointer">
                <span>🔲</span>
                <span>Weekdays</span>
              </li>

              <!-- Weekly -->
              <li class="flex items-center gap-2 px-4 py-3 hover:bg-gray-700 cursor-pointer">
                <span>🔲</span>
                <span>Weekly</span>
              </li>

              <!-- Monthly -->
              <li class="flex items-center gap-2 px-4 py-3 hover:bg-gray-700 cursor-pointer">
                <span>🔲</span>
                <span>Monthly</span>
              </li>

              <!-- Yearly -->
              <li class="flex items-center gap-2 px-4 py-3 hover:bg-gray-700 cursor-pointer">
                <span>✨</span>
                <span>Yearly</span>
              </li>

              <!-- Custom -->
              <li class="flex items-center gap-2 px-4 py-3 hover:bg-gray-700 cursor-pointer">
                <span>🗓️</span>
                <span>Custom</span>
              </li>
            </ul>
          </div>

        </div>
        <button type="submit" id="task-add"
          class="p-2 hidden ms-2 text-sm font-medium text-white bg-blue-700 rounded-lg border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Add
        </button>
      </form>
    </div>
    <!-- Add Task Input -->

    <!-- Context Menu -->
    <div id="context-menu"
      class="hidden absolute bg-gray-800 text-white shadow-md rounded-md w-56 py-2 border border-gray-700">
      <ul class="text-sm">
        <li class="px-4 py-2 hover:bg-gray-700 cursor-pointer flex items-center gap-2">
          <i class="fa-solid fa-sun text-white"></i> Remove from My Day
        </li>
        <li class="px-4 py-2 hover:bg-gray-700 cursor-pointer flex items-center gap-2 impTask " data-id="markImportant">
          <i class="fa-solid fa-star text-white"></i> Mark as important
        </li>
        <li class="px-4 py-2 hover:bg-gray-700 cursor-pointer flex items-center justify-between">
          <div class="flex items-center gap-2">
            <i class="fa-solid fa-check text-white"></i> Mark as completed
          </div>
          <a href=""></a>
          <span class="text-gray-400 text-xs">Ctrl+D</span>
        </li>
        <hr class="border-gray-600">
        <li class="px-4 py-2 hover:bg-gray-700 cursor-pointer flex items-center gap-2">
          <i class="fa-solid fa-calendar-day text-white"></i> Due today
        </li>
        <li class="px-4 py-2 hover:bg-gray-700 cursor-pointer flex items-center gap-2">
          <i class="fa-solid fa-calendar-week text-white"></i> Due tomorrow
        </li>
        <li class="px-4 py-2 hover:bg-gray-700 cursor-pointer flex items-center gap-2">
          <i class="fa-solid fa-calendar text-white"></i> Pick a date
        </li>
        <hr class="border-gray-600">
        <li class="px-4 py-2 hover:bg-gray-700 cursor-pointer flex items-center gap-2">
          <i class="fa-solid fa-folder text-white"></i> Move task to...
        </li>
        <hr class="border-gray-600">
        <li id="deleteButton" data-modal-target="deleteModal" data-modal-toggle="deleteModal"
          class="  px-4 py-2 hover:bg-red-600 cursor-pointer flex items-center gap-2  text-red-400">
          <i class="fa-solid fa-trash text-red-400"></i>
          Delete task
        </li>
      </ul>
    </div>
    <!-- Context Menu -->


    <!-- manage account modal box -->
    <div class="bg-gray-900 flex items-center justify-center ">
      <div class="bg-gray-800 text-white w-96 rounded-lg shadow-lg p-5 space-y-5  hidden  " id="manageAccountModal">
        <!-- Title -->
        <h2 class="text-center text-lg font-semibold">Manage accounts</h2>

        <!-- Account Info Row -->
        <div class="flex items-center justify-between bg-gray-700 p-3 rounded">
          <div class="flex items-center space-x-3">
            <!-- Profile Icon -->
            <?php if (isset(($_SESSION['loginid'])) && !empty($_SESSION['loginid'])) { ?>
              <form action="./config/server.php" method="post" id="logout_form">

                <div
                  class="bg-purple-600 text-white w-10 h-10 rounded-full flex items-center justify-center font-semibold">
                  <?php echo $_SESSION["logindata"]["firstname"][0];
                  echo $_SESSION["logindata"]["lastname"][0]; ?>
                </div>
                <!-- Name and Email -->
                <p class="font-medium"><?php echo ($_SESSION['logindata']['firstname']); ?></p>
                <p class="text-sm text-gray-300"><?php echo ($_SESSION['logindata']['email']); ?></p>


                <!-- <div>
              <p class="font-medium">Rohit Verma</p>
              <p class="text-sm text-gray-300">rohit995379@gmail.com</p>
            </div> -->
            </div>
            <!-- Sign Out Button -->
            <div>
              <button type="submit" name="logout" class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded">Sign
                out</button>
            </div>
          </div>
          </form>
        <?php } else { ?>
          <p class="font-medium">No account logged in</p>
          <p class="text-sm text-gray-300">Please log in to manage accounts</p>
        <?php } ?>



        <!-- Add Account -->
        <div class="flex items-center space-x-3 cursor-pointer hover:bg-gray-700 p-3 rounded">
          <i class="fas fa-plus text-white"></i>
          <span>Add account</span>
        </div>

        <!-- Close Button -->
        <div class="flex justify-end" id="closeManageAccountModal">
          <button class="bg-black hover:bg-gray-900 text-white px-4 py-1 rounded">Close</button>
        </div>
      </div>
    </div>
    <!-- manage account modal box -->
  </main>

  <!-- Sidebar -->
  <div class="sidebar h-screen w-1/5  fixed top-0 right-0 hidden ">
    <div class="bg-gray-800 text-white h-screen p-6 rounded-lg w-96 shadow-lg">
      <!-- Task Header -->
      <div class="flex items-center justify-between">
        <input type="checkbox" id="checkbox" class="w-5 h-5 accent-blue-500">
        <input type="text" value="Task Title" class="bg-transparent text-lg font-semibold outline-none w-full ml-2">
        <button class="text-gray-400 hover:text-yellow-400">
          <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="w-6 h-6" viewBox="0 0 24 24">
            <path
              d="M12 17.75l-6.16 3.75 1.18-7.03-5.02-4.89 6.99-1.01L12 2l3.01 6.07 6.99 1.01-5.02 4.89 1.18 7.03z" />
          </svg>
        </button>
      </div>
      <!-- Add Step -->

      <button class="text-blue-400 hover:text-blue-300 mt-2 text-sm">+ Add step</button>
      <!-- Action Buttons -->

      <div class="mt-4 space-y-2  ">
        <button class="flex  items-center w-full text-left p-2 hover:bg-gray-700 rounded">
          <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-yellow-400" viewBox="0 0 24 24"
            fill="currentColor">
            <path d="M12 3v10h9v3h-9v8H9v-8H3v-3h6V3h3z" />
          </svg>
          <span class="ml-2">Add to My Day</span>
        </button>
        <button class="flex items-center w-full text-left p-2 hover:bg-gray-700 rounded">
          <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-red-400" viewBox="0 0 24 24" fill="currentColor">
            <path
              d="M12 1C5.925 1 1 5.925 1 12s4.925 11 11 11 11-4.925 11-11S18.075 1 12 1zm0 20c-4.962 0-9-4.038-9-9s4.038-9 9-9 9 4.038 9 9-4.038 9-9 9zm-.5-13h1v6h-1zm0 7h1v1h-1z" />
          </svg>
          <span class="ml-2">Remind me</span>
        </button>
        <button class="flex items-center w-full text-left p-2 hover:bg-gray-700 rounded">
          <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-green-400" viewBox="0 0 24 24"
            fill="currentColor">
            <path
              d="M19 3h-2V1h-2v2H9V1H7v2H5C3.9 3 3 3.9 3 5v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 16H5V10h14v9z" />
          </svg>
          <span class="ml-2">Add due date</span>
        </button>
        <button class="flex items-center w-full text-left p-2 hover:bg-gray-700 rounded">
          <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-blue-400" viewBox="0 0 24 24" fill="currentColor">
            <path d="M6 11h12v2H6zm0 4h12v2H6zm0-8h12v2H6z" />
          </svg>
          <span class="ml-2">Repeat</span>
        </button>
        <button class="flex items-center w-full text-left p-2 hover:bg-gray-700 rounded">
          <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-purple-400" viewBox="0 0 24 24"
            fill="currentColor">
            <path
              d="M12 12c2.21 0 4-1.79 4-4S14.21 4 12 4s-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z" />
          </svg>
          <span class="ml-2">Assign to</span>
        </button>
        <button class="flex items-center w-full text-left p-2 hover:bg-gray-700 rounded">
          <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-yellow-400" viewBox="0 0 24 24"
            fill="currentColor">
            <path d="M14 2H6c-1.1 0-2 .9-2 2v16c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V8l-6-6zM6 20V4h7v5h5v11H6z" />
          </svg>
          <span class="ml-2">Add file</span>
        </button>
      </div>

      <!-- Notes Section -->
      <textarea class="bg-gray-700 w-full h-16 mt-4 p-2 rounded text-white placeholder-gray-400"
        placeholder="Add note"></textarea>

      <!-- Footer -->
      <div class="text-gray-400 text-xs mt-4 flex justify-between">
        <span>Created a few moments ago</span>
        <button class="text-red-400 hover:text-red-300">
          <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="currentColor">
            <path d="M6 19c0 1.1.9 2 2 2h8c1.1 0 2-.9 2-2V7H6v12zM18 4h-2.5l-1-1h-5l-1 1H6v2h12V4z" />
          </svg>
        </button>
      </div>
    </div>
  </div>
  <!-- Sidebar -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
    integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  <script src="./assets/js/flowbite.min.js"></script>

  <script type="text/javascript"
    src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
  <script src="./common/script.js"></script>
</body>

</html>