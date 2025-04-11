
$(document).ready(function () {
    toastr.options = {
        'closeButton': true,
        'debug': false,
        'newestOnTop': false,
        'progressBar': true,
        'positionClass': 'toast-top-right',
        'preventDuplicates': false,
        'showDuration': '500',
        'hideDuration': '1000',
        'timeOut': '1000',
        'extendedTimeOut': '1000',
        'showEasing': 'swing',
        'hideEasing': 'linear',
        'showMethod': 'fadeIn',
        'hideMethod': 'fadeOut',
    };
});
// toastr end
$(document).ready(function () {
    fetchlistdata();
    let activeListId = $(".active-list").attr("data-id");
    // console.log(activeListId);
    fetchdata(activeListId);
    // counter();
    // getImpCount();
});

$(document).on("click", "#task-add", function (e) {
    e.preventDefault();
    let task = $("#taskinput").val().trim();
    let errorCount = 0;
    let form = $("#taskform");
    let url = form.attr("action");
    let activeListId = $(".active-list").attr("data-id");
    // let id = $(".taskImp").attr("data-id");
    let listId = $(".active-list").data("id");


    let formData = form.serialize();
    formData += "&activeListId=" + activeListId;

    if (activeListId == "Important") {
        formData += "&is_imp=1";
    } else {
        formData += "&is_imp=0";
    }

    // Validation
    if (task === "") {
        $("#taskinput").addClass("border-red-500");
        errorCount++;
    }

    if (errorCount == 0) {
        $.ajax({
            url: url,
            type: "POST",
            data: formData,
            success: function (response) {
                let arr = JSON.parse(response);
                if (arr.success) {
                    toastr.success(arr.massage);

                    $("#taskinput").val("").removeClass("border-red-500");
                    fetchdata(activeListId); // Refresh task list after adding
                }
            }
        });
    } else {
        toastr.error("Task name is required");
    }
});

// fetch data
function fetchdata(id = '') {
    let request = {
        getData: true,
    }
    if (id != '') {
        request.id = id;
    }
    $.ajax({
        url: "./config/server.php",
        type: "POST",
        data: request,
        success: function (response) {
            let arr = JSON.parse(response);
            if (arr.success) {
                // $(".count").text(arr.countasks)
                renderdata(arr.tasklist);
            }
            else {
                console.error(arr.massage);
            }
        },
        error: function (response) {
            console.error("ajax error");
        }
    });
}

function renderdata(tasklist) {
    let taskHtmlTwo = '';
    let taskHtml = '';
    let countComp = 0;
    let count = 0;
    let activeListId = $(".active-list").data("id");
    let countImp = 0;


    if (tasklist) {
        tasklist.forEach((element) => {
            // $(".countComp").html("");

            let is_imp = (element.is_imp == 1) ? "text-yellow-500" : "text-white";

            let isDon = (element.is_don == 1) ? "bg-blue-500 rounded-full m-1 text-white" : "";

            let disTask = `
                             <div class="text-center  overflow-hidden task-option  deletebtn removeTask${element.id} sidebarmenu" data-id="${element.id}" >
                               <div  class="flex justify-between border w-full border-black  bg-gray-800 text-white rounded mb-2 p-2 items-center">
                                 <div class="flex items-center space-x-2"  >
                                 <div class="check taskCompleted"  data-id="${element.id}"  don-task="${element.is_don}">
                                   <input type="checkbox" class="mr-2  ${isDon}"  >
                                   </div>
                                   <p class="newtask">${element.tasks_name}</p>
                                 </div>
                                  <div class="star-btn ${is_imp}  hover:text-yellow-300 taskImp taskImps${element.id}" data-id="${element.id}" data-imp="${element.is_imp}">
                                   <i class="  fa-regular fa-star"> </i>
                                   </div>
                                   </div>
                                 </div>
                               </div>
                             </div>         
                         `;

            if (element.is_don == 1) {
                taskHtmlTwo += disTask;
                countComp++;
            } else {
                taskHtml += disTask;
                if (activeListId === "MyDay" && element.list_id === "MyDay") {
                    count++;
                } else if (activeListId == "Important" && element.is_imp == 1) {
                    countImp++;
                }
            }
        });
        (countComp == 0) ? $(".compHide").addClass("hidden") : $(".compHide").removeClass("hidden");


        // alert("loop");
        $("#display-data").html(taskHtml);
        $("#CompTasks").html(taskHtmlTwo);
        $(".countComp").html(countComp);
        $(".count").text(count);
        $(".countImp").html(countImp);
    } else {
        console.log("no data");
    }
}



$(document).on("click", ".star-btn", function (e) {

    // let id = $(this).attr("data-id");
    e.stopPropagation();
});
$(document).on("click", ".check", function (e) {

    // let id = $(this).attr("data-id");
    e.stopPropagation();
});

$(document).on("click", ".sidebarmenu", function (e) {
    $(".sidebar").toggle();
    let is_open = $(".main_screen_size").attr("is_open");
    if (is_open == "0") {
        $(".main_screen_size").removeClass("w-full");
        $(".main_screen_size").addClass("w-3/5");
        $(".submitScreenSize").removeClass("w-10/12");
        $(".submitScreenSize").addClass("w-3/5");
        $(".main_screen_size").attr("is_open", "1");
    } else {
        $(".main_screen_size").addClass("w-full");
        $(".main_screen_size").removeClass("w-3/5");
        $(".submitScreenSize").addClass("w-10/12");
        $(".submitScreenSize").removeClass("w-3/5");
        $(".main_screen_size").attr("is_open", "0");
    }
})

let taskid = null;
// context menu task 
$(document).on("contextmenu", '.task-option', function (e) {
    e.preventDefault();
    taskid = $(this).data("id"); // Get the ID of the task to be deleted
    $(".deletetasklist").attr("data-id", taskid);
    $(".impTask").attr("data-id");


    let menu = $("#context-menu");
    let winWidth = $(window).width();
    let winHeight = $(window).height();
    let menuWidth = menu.outerWidth();
    let menuHeight = menu.outerHeight();

    let x = e.pageX;
    let y = e.pageY;

    // Ensure menu does not go off-screen
    if (x + menuWidth > winWidth) x -= menuWidth;
    if (y + menuHeight > winHeight) y -= menuHeight;

    menu.css({ top: y + "px", left: x + "px" }).removeClass("hidden");

});

$(document).on("click", function () {
    $("#context-menu").addClass("hidden");
})

$(document).on("click", ".deletetasklist", function () {
    taskid = $(this).attr("data-id");
    $.ajax({
        url: "./config/server.php",
        type: "POST",
        data: { deleteTask: true, id: taskid },
        success: function (response) {
            let res = JSON.parse(response);
            if (res.success) {
                toastr.success(res.massage);
                setTimeout(() => {
                    let activeListId = $(".active-list").data("id");
                    fetchdata(activeListId);
                }, 500);
            } else {
                console.error("Error:", res.massage);
            }
        }
    });
});

$("#close_modal").on("click", function () {
    $(".close").trigger("click");
})
// sidebarlistadd
// $(document).on("click", "#newList", function (e) {
//     e.preventDefault();
//     let listname = "Untitled list";
//     // let temp_list = "untitled list";
//     // let list_no = 1;

//     // if (temp_list != undefined) {

//     // }
//     $.ajax({
//         url: "./config/server.php",
//         type: "POST",
//         data: {
//             newListdata: true,
//             listname: listname,
//             // temp_list: temp_list,
//             // list_no: list_no
//         },
//         success: function (response) {
//             let res = JSON.parse(response);
//             // console.log(res);
//             if (res.success) {
//                 rendernewlist(res.listdata, 1);
//             }
//             else {
//                 console.error("Error:", res.massage);
//             }
//         }
//     });
// });

function fetchlistdata() {
    $.ajax({
        url: "./config/server.php",
        type: "POST",
        data: { getnewlist: true },
        success: function (response) {
            let res = JSON.parse(response);
            // console.log(res);
            if (res.success) {
                $("#addList").empty();
                rendernewlist(res.getnewlistdata);
            } else {

            }
        },
        error: function (xhr, status, error) {
            console.error("AJAX Error:", error);
        }
    });
}
function rendernewlist(data, is_input = '') {
    if (is_input == 1) {
        var input = "";
        var span = "hidden";
    } else {
        var input = "hidden";
        var span = "";
    }
    data.forEach((res, index) => {

        let html = `
      <li class="contexntRightClick delete_list max-h-40 cursor-pointer flex items-center space-x-2 text-white" data-id="${res.id}">
        <i class="fa-solid fa-bars"></i>
          <span class=" listSpan${res.id} ${span}  pointer-events-none listSpan listSpanActive"> ${res.list_name}</span>
          
          <input class="  listInput${res.id} ${input} listInput listInputActive bg-blue-800  border-none border-b-2 border-gray-300 text-white text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-blue-900 dark:border-gray-600 dark:placeholder-gray-400 dark:text-black dark:focus:ring-blue-500 dark:focus:border-blue-500" type="text" name="list_name" value="${res.list_name}">
      </li>
  `;
        $("#addList").append(html); // Append new list to the list
        $(".activeInput").attr("data-id", res.id);
        $(".listInput" + res.id).focus().select();
    })
}
let listId = null;

$(document).click(function (event) {
    if (!$(event.target).closest(".listInputActive , .context-menu-new-list").length) {
        let activeInput = $(".activeInput").data("id");  // html ma ha ya id input tag ma h 
        $(".listInput").addClass("hidden");
        $(".listSpan").removeClass("hidden");
        $(".listInput" + activeInput).focus().select();
        let listName = $('.listInput' + activeInput).val();
        // updatelist(activeInput, listName);
    }
})

// $(document).on("click", ".renamelist", function () {
//     let listId = $(this).data("id");
//     $(".activeInput").attr("data-id", listId);
//     $(".listInput" + listId).removeClass('hidden');
//     $(".listSpan" + listId).addClass('hidden');
//     $(".listInput" + listId).focus().select();
// })
// function updatelist(listId, listName) {
//     $.ajax({
//         url: "./config/server.php",
//         type: "POST",
//         data: { listrename: true, listId: listId, listName: listName },
//         success: function (response) {
//             let res = JSON.parse(response)
//             // console.log(res);
//             if (res.success) {
//                 toastr.success(res.massage);
//                 // getnewlist();
//                 $("#addlist").empty();
//                 fetchlistdata();
//             }
//         }
//     })
// }

$(document).on("contextmenu", ".contexntRightClick", function (e) {
    e.preventDefault();
    listId = $(this).data("id");
    $(".deletelist").attr("data-id", listId);
    $(".renamelist").attr("data-id", listId);
    // $(".taskCompleted").attr("data-id", listId);

    let menu = $(".context-menu-new-list");
    let winWidth = $(window).width();
    let winHeight = $(window).height();
    let menuWidth = menu.outerWidth();
    let menuHeight = menu.outerHeight();

    let x = e.pageX;
    let y = e.pageY;

    // Ensure menu does not go off-screen
    if (x + menuWidth > winWidth) x -= menuWidth;
    if (y + menuHeight > winHeight) y -= menuHeight;

    menu.css({ top: y + "px", left: x + "px" }).removeClass("hidden");
});

$(document).on("click", function () {
    $(".context-menu-new-list").addClass("hidden");
});

$(document).on("click", ".deletelist", function (e) {

    listId = $(this).attr("data-id");
    $.ajax({
        url: "./config/server.php",
        type: "POST",
        data: { deletelist: true, id: listId },
        success: function (response) {
            let res = JSON.parse(response)
            if (res.success) {
                toastr.success(res.massage);

                $("#addList").empty();
                fetchlistdata();

            } else {
                console.error(res.massage);
            }
        }
    });
});

$("#closemodallist").on("click", function () {

    $(".close_modallist").trigger("click");
})

// fetch default list data
// function fetchDefaultList() {
//     $.ajax({
//         url: "./config/server.php",
//         type: "POST",
//         data: { defaultList: true },
//         success: function (response) {
//             let res = JSON.parse(response);
//             let i = 0;
//             if (res.success) {
//                 res.listData.forEach(element => {
//                     let active = "";
//                     if (i == 0) {
//                         active = "active-list";
//                     }
//                     let html = `<li class="${active} active  cursor-pointer flex items-center space-x-2 text-blue-400  " data-id='${element.id}'>${element.list_name} </li>`;
//                     i++;
//                     $(".default-list").append(html);
//                 });
//             } else {
//                 console.error(res.massage);
//             }
//         }
//     })
// }

$(document).on("click", ".getDefaultList", function () {
    let id = $(this).attr("data-id");
    let activeListId = $(this).data("id");
    $(".getDefaultList").removeClass("active-list");
    $(this).addClass("active-list");
    if (activeListId == "completed") {
        $(".removecomp").addClass("hidden");
    } else {
        $(".removecomp").removeClass("hidden");
    }
    // if (activeListId === "completed") {
    // } 
    // else if (activeListId == "Important" || activeListId == "Planned" || activeListId == "all") {
    //     // alert("all");
    //     $(".compHide").addClass("hidden");
    // } else {
    //     $(".compHide").removeClass("hidden");

    // }

    // if (activeListId == "all") {
    //     $(".compHide").addClass("hidden");
    //     alert("all");
    // }
    fetchdata(id);
});

// let imp
$(document).on("click", ".taskImp", function () {
    let id = $(this).attr("data-id");
    let imp = $(this).attr("data-imp");
    let getList = $(".active-list").data("id");


    $.ajax({
        url: "./config/server.php",
        type: "POST",
        data: {
            updateImp: true,
            id: id,
            imp: imp
        },
        success: function (response) {
            let res = JSON.parse(response);
            if (res.success) {
                toastr.success(res.massage);
                if (imp == "0") {
                    $(".taskImps" + id).attr("data-imp", 1);
                    $(".taskImps" + id).removeClass("text-white").addClass("text-yellow-500");
                } else {
                    if (getList == "Important") {
                        setTimeout(() => {
                            $(".removeTask" + id).remove();
                        }, 500);
                    }
                    $(".taskImps" + id).attr("data-imp", 0)
                    $(".taskImps" + id).addClass("text-white").removeClass("text-yellow-500");
                }
            } else {
                console.error(res.massage);
            }

        }
    });
});

// task completed check box click 
$(document).on("click", ".taskCompleted", function () {
    let id = $(this).attr("data-id");
    let taskDon = $(this).attr("don-task");
    // let listId = $(".active-list").data("id");
    let activeListId = $(".active-list").attr("data-id");
    // alert(getList);
    // console.log(activeListId);
    $.ajax({
        url: "./config/server.php",
        type: "POST",
        data: {
            updateDon: true,
            id: id,
            isDon: taskDon,
            // listId: listId
        },
        success: function (response) {
            let res = JSON.parse(response);
            if (res.success) {
                toastr.success(res.massage);
                $(".removeTask" + id).remove();
                fetchdata(activeListId);

            }
        }
    });
})


$("#dropdown-btn").click(function () {
    if ($("#CompTasks").hasClass("hidden")) {
        $(".arrowDown").removeClass("hidden");
        $(".arrowRight").addClass("hidden");
    } else {

        $(".arrowDown").addClass("hidden");
        $(".arrowRight").removeClass("hidden");
    }
    $("#CompTasks").toggleClass("hidden");
});


$("#downloadExcel").on("click", function () {
    // Call PHP file to download Excel
    console.log("excel download");
    window.location.href = "download_tasks.php";
});


// uaer setting input field
$(document).on("click", ".dropSetting", function () {
    setTimeout(() => {
        $(".user_setting").toggleClass("hidden");
    }, 200);
})

$(document).on("click", ".manageAccount", function () {
    $("#manageAccountModal").toggleClass("hidden");
})

$("#closeManageAccountModal").click(function () {
    $("#manageAccountModal").toggleClass("hidden");
})
// $(document).on("click", ".taskCompleted, .taskImp", function () {
//     let id = $(this).attr("data-id") || $(this).attr("data-id");
//     let type = $(this).hasClass("taskCompleted") ? "updateDon" : "updateImp";
//     let value = $(this).attr("data-imp") || $(this).attr("don-task");

//     $.ajax({
//         url: "./config/server.php",
//         type: "POST",
//         data: {
//             action: type,
//             id: id,
//             value: value
//         },
//         success: function (response) {
//             let res = JSON.parse(response);
//             if (res.success) {
//                 toastr.success(res.message);

//                 if (type === "updateDon") {
//                     $(".removeTask" + id).remove();
//                 } else if (type === "updateImp") {
//                     if (value == "0") {
//                         $(".taskImps" + id).attr("data-imp", 1).removeClass("text-white").addClass("text-yellow-500");
//                     } else {
//                         let getList = $(".active-list").data("id");
//                         if (getList == "Important") {
//                             setTimeout(() => { $(".removeTask" + id).remove(); }, 500);
//                         }
//                         $(".taskImps" + id).attr("data-imp", 0).addClass("text-white").removeClass("text-yellow-500");
//                     }
//                 }
//             }
//         }
//     });
// });

