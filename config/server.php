<?php
include("database.php");

$check_api = 1;
//signup  form api
if (isset($_POST['signup'])) {
  $check_api = 0;

  $firstname = $_POST["firstname"];
  $lastname = $_POST["lastname"];
  $email = $_POST["email"];
  $phoneno = $_POST["phoneno"];
  $password = $_POST["password"];
  $confirmPassword = $_POST["confirmpassword"];

  $returndata["success"] = false;
  $errcount = 0;
  // $hashed_password = password_hash($password, PASSWORD_DEFAULT);

  if (empty($firstname)) {
    $returndata["firstname_error"] = "First name is required.";
    $errcount++;
  }
  if (empty($lastname)) {
    $returndata["lastnameerror"] = "Last name is required.";
    $errcount++;
  }
  if (empty($email)) {
    $returndata["email_error"] = "Email is required.";
    $errcount++;
  }
  if (empty($phoneno)) {
    $returndata["phoneno_error"] = "Phone number is required.";
    $errcount++;
  }
  if (empty($password)) {
    $returndata["password_error"] = "Password is required.";
    $errcount++;
  }
  if (empty($confirmPassword)) {
    $returndata["confirmpassword_error"] = "Confirm password is required.";
    $errcount++;
  }

  if ($password !== $confirmPassword) {
    $returndata["password_error"] = "Passwords do't  match.";
    $errcount++;
  }

  if ($errcount == 0) {
    $checkphoneno = "select id from users where phoneno = '$phoneno'";
    $phonequery = mysqli_query($conn, $checkphoneno);

    $checkemail = "select id  from users where email = '$email'";
    $result = mysqli_query($conn, $checkemail);
    if (mysqli_num_rows($result) > 0) {
      $returndata["email_error"] = "Email already exists";
    } else if (mysqli_num_rows($phonequery) > 0) {
      $returndata["phoneno_error"] = "phone number already exit";
    } else {
      // $hashed_password = password_hash($password, PASSWORD_DEFAULT);
      $query = "insert into users (firstname , lastname , email , phoneno , password) values ('$firstname' , '$lastname' , '$email' , '$phoneno' , '$password')";
      $run = mysqli_query($conn, $query);

      if ($run) {
        $id = $conn->insert_id;
        $sql = "select id , firstname , lastname , email , phoneno ,password from users where id = '$id'";
        $run = mysqli_query($conn, $sql);
        $userData = mysqli_fetch_assoc($run);
        $_SESSION['loginid'] = $id;
        $_SESSION['logindata'] = $userData;
        $returndata["success"] = true;
        $returndata["massage"] = "Data inserted successfully";
      } else {
        $returndata["massage"] = "invalid data inserted";
      }
    }
  }
  echo json_encode($returndata, true);
}

// login  form api 
if (isset($_POST['login'])) {

  $check_api = 0;

  $email = $_POST['email'];
  $password = $_POST['password'];
  $errCount = 0;
  $returndata = ["success" => false];

  // Validation
  if (empty($email)) {
    $returndata["email_error"] = "Email is required.";
    $errCount++;
  }
  if (empty($password)) {
    $returndata["password_error"] = "Password is required.";
    $errCount++;
  }

  if ($errCount == 0) {
    $query = "SELECT id, email, password , phoneno , firstname , lastname FROM users WHERE email = '$email' ";
    // $passwordquery = "SELECT id, email, password FROM todo WHERE email = '$email'";

    // $passwordquery = "SELECT id, email, password FROM todo WHERE email = '$password'";
    // $passresult = mysqli_query($conn, $passwordquery);
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
      $row = mysqli_fetch_assoc($result);
      $dbpassword = $row['password'];

      if ($password === $row['password']) {

        $_SESSION['loginid'] = $row['id'];
        $_SESSION['logindata'] = $row;

        $returndata["success"] = true;
        $returndata["massage"] = "Login successfully";
      } else {
        $returndata["password_error"] = "Password not incorrect";
      }

    } else {
      $returndata["email_error"] = "user not fuound";
    }
  }

  echo json_encode($returndata, true);
}

// logout section
if (isset($_POST['logout'])) {
  session_destroy();
  header('Location: ../login.php');
}

// task section
if (isset($_POST['task_submit'])) {

  $check_api = 0;

  $returndata["success"] = false;
  $taskerrcount = 0;

  if (isset($_POST['taskinput']) && isset($_POST['user_id'])) {

    $taskinput = $_POST['taskinput'];
    $user_id = $_POST['user_id'];
    $activeListId = $_POST['activeListId'];

    if (empty($taskinput)) {
      $returndata["massage"] = "Task is required.";
      $taskerrcount++;
    }

    if (empty($user_id)) {
      $returndata["massage"] = "User id is required.";
      $taskerrcount++;
    }
    if ($taskerrcount == 0) {
      $qry = mysqli_query($conn, "select id from users where id = '$user_id'");
      if (mysqli_num_rows($qry) < 1) {
        $returndata["massage"] = "User id not found";
        $taskerrcount++;
      }
    }
    if (empty($activeListId)) {
      $returndata["massage"] = "List id is required.";
      $taskerrcount++;
    }
    $isimp = $_POST["is_imp"];

    if ($taskerrcount == 0) {
      $qry = "insert into tasks (tasks_name,list_id , is_imp ,created_by , updated_by) values ('$taskinput' , '$activeListId' ,'$isimp', '$user_id' , '$user_id')";
      $result = mysqli_query($conn, $qry);
      if ($result) {
        $run = mysqli_query($conn, "select * from  tasks where created_by = '$user_id' and   list_id = '$activeListId'   order by id desc");
        if ($run) {
          $data = [];
          while ($row = mysqli_fetch_assoc($run)) {
            $data[] = $row;
          }
        }
        $returndata["tasklist"] = $data;
        $returndata["success"] = true;
        $returndata["massage"] = "Add task successfully";
      } else {
        $returndata["massage"] = "add task not successfully";
      }
    }
  } else {
    $returndata["massage"] = "Task input or user id not found";
  }
  echo json_encode($returndata, true);
}

// fetching data from database
if (isset($_POST['getData'])) {
  $check_api = 0;
  $returndata["success"] = false;
  $id = $_POST['id'];
  $where = "";
  if (isset($_POST['id'])) {
    if ($_POST['id'] == 'Important') {
      $where = "AND is_imp = '1' and is_don = '0' ";
    } elseif ($_POST['id'] == "completed") {
      $where = "AND is_don = '1'";
    } elseif ($_POST['id'] == "all") {
      $where = "AND is_don = '0'";
    } elseif ($id = "MyDay") {
      $where = "AND( list_id = 'MyDay' OR  list_id = 'Planned')";
    } elseif ($_POST['id'] == "tasks") {
      $where = "";
    } else {
      $where = "AND list_id = '$id'";
    }
    
  }

  $result = mysqli_query($conn, "SELECT * FROM tasks WHERE created_by = '$_SESSION[loginid]'  $where ORDER BY id DESC");

  if ($result) {
    $data = [];
    while ($row = mysqli_fetch_assoc($result)) {
      $data[] = $row;
    }
    $count_task = [
      "MyDay" => "SELECT COUNT(*) as countTask FROM tasks WHERE created_by = '$_SESSION[loginid]' and( list_id = 'MyDay' or list_id = 'Planned'   ) And is_don = '0'",
      "Important" => "SELECT COUNT(*) as countTask FROM tasks WHERE created_by = '$_SESSION[loginid]' and is_imp = '1' and is_don = '0'",
      "Planned" => "SELECT COUNT(*) as countTask FROM tasks WHERE created_by = '$_SESSION[loginid]' and is_don = '0' AND list_id = 'Planned'",
      "all" => "SELECT COUNT(*) as countTask FROM tasks WHERE created_by = '$_SESSION[loginid]' and is_don = '0'",
      "completed" => "SELECT COUNT(*) as countTask FROM tasks WHERE created_by = '$_SESSION[loginid]' AND is_don = '1'",
      "tasks" => "SELECT COUNT(*) as countTask FROM tasks WHERE created_by = '$_SESSION[loginid]' and is_don = '0'",
    ];
    // print_r($count_task);

    $count = [];
    foreach ($count_task as $key => $value) {
      $Count_query = mysqli_query($conn, $value);
      if ($Count_query) {
        $count[$key] = mysqli_fetch_assoc($Count_query)['countTask'];
      } else {
        $count[$key] = 0; // Default value if query fails
      }
    }
    // print_r($count);
    // die;
    $returndata["countTasks"] = $count;
    $returndata["tasklist"] = $data;
    $returndata["success"] = true;
    $returndata["massage"] = "Data fetched success fully";
  } else {
    $returndata["massage"] = "No data found";
  }
  echo json_encode($returndata, true);
}

// if (isset($_POST['getData'])) {
//   $returndata = ["success" => false];
//   $id = $_POST['id'];
//   $where = "";

//   if ($id == 'Planned') {
//     $where = "AND is_don = '0'";
//   } elseif ($id == 'Important') {
//     $where = "AND is_imp = '1' AND is_don = '0'";
//   } elseif ($id == 'completed') {
//     $where = "AND is_don = '1'";
//   } elseif ($id == 'all') {
//     $where = "AND is_don = '0'";
//   } elseif ($id == 'tasks') {
//     $where = "";
//   } else {
//     $where = "AND list_id = '$id'";
//   }

//   $result = mysqli_query($conn, "SELECT * FROM tasks WHERE created_by = '{$_SESSION['loginid']}' $where ORDER BY id DESC");

//   if ($result) {
//     $data = [];
//     while ($row = mysqli_fetch_assoc($result)) {
//       $data[] = $row;
//     }

//     // $count_task = [
//     //   "MyDay" => "SELECT COUNT(*) as countTask FROM tasks WHERE created_by = '{$_SESSION['loginid']}' AND is_don = '0'",
//     //   "Important" => "SELECT COUNT(*) as countTask FROM tasks WHERE created_by = '{$_SESSION['loginid']}' AND is_imp = '1' AND is_don = '0'",
//     //   "Planned" => "SELECT COUNT(*) as countTask FROM tasks WHERE created_by = '{$_SESSION['loginid']}' AND is_don = '0' AND is_imp = '0'",
//     //   "all" => "SELECT COUNT(*) as countTask FROM tasks WHERE created_by = '{$_SESSION['loginid']}' AND is_don = '0'",
//     //   "completed" => "SELECT COUNT(*) as countTask FROM tasks WHERE created_by = '{$_SESSION['loginid']}' AND is_don = '1'",
//     //   "tasks" => "SELECT COUNT(*) as countTask FROM tasks WHERE created_by = '{$_SESSION['loginid']}'"
//     // ];

//     // $count = [];
//     // foreach ($count_task as $key => $query) {
//     //   $Count_query = mysqli_query($conn, $query);
//     //   $count[$key] = $Count_query ? mysqli_fetch_assoc($Count_query)['countTask'] : 0;
//     // }

//     // $returndata["countTasks"] = $count;
//     $returndata["tasklist"] = $data;
//     $returndata["success"] = true;
//     $returndata["message"] = "Data fetched successfully";
//   } else {
//     $returndata["message"] = "No data found";
//   }

//   echo json_encode($returndata, true);
// }

// delete task  id 
if (isset($_POST['deleteTask'])) {

  $check_api = 0;

  $returndata["success"] = false;
  $id = $_POST['id'];

  $result = mysqli_query($conn, "delete from tasks where id = '$id'");

  if ($result) {
    $returndata["success"] = true;
    $returndata["massage"] = "Task deleted successfully";
  } else {
    $returndata["massage"] = "Task not delete successfully";
  }
  echo json_encode($returndata, true);
}

//  new list create 
if (isset($_POST['newListdata'])) {
  $check_api = 0;
  // $user_id = $_POST['user_id'];
  $list_name = $_POST['listname'];
  $temp_list = $_POST['temp_list'];
  $list_no = $_POST['list_no'];
  $is_default = 0;
  $returndata = ["success" => false];

  $run = mysqli_query($conn, "INSERT INTO lists (list_name , is_default , temp_list , list_no 	) VALUES ('$list_name' ,'$is_default' , '$temp_list' , '$list_no')");

  if ($run) {
    $result = mysqli_query($conn, "select id , list_name , temp_list, list_no from lists where  id = '$conn->insert_id' ORDER BY id desc");
    $row = mysqli_fetch_assoc($result);
    $data[] = $row;
    $returndata["listdata"] = $data;
    $returndata["success"] = true;
  } else {
    $returndata["success"] = false;
  }

  echo json_encode($returndata, true);
}

// fetch newlist data
if (isset($_POST["getnewlist"])) {

  $check_api = 0;

  $returndata["success"] = false;

  $result = mysqli_query($conn, "select id, list_name from lists where is_default = '0' ORDER BY id desc");
  if ($result) {
    $data = [];
    while ($row = mysqli_fetch_assoc($result)) {
      $data[] = $row;
    }
    $returndata["getnewlistdata"] = $data;
    $returndata["success"] = true;
    $returndata["massage"] = "Data fetched success fully";
  } else {
    $returndata["success"] = false;
    $returndata["massage"] = "Data not fetched";
  }
  echo json_encode($returndata, true);
}

// delete list
if (isset($_POST['deletelist'])) {
  $check_api = 0;
  $returndata["success"] = false;
  $id = $_POST['id'];

  // Validate list ID
  $result = mysqli_query($conn, "SELECT id FROM lists WHERE id = '$id'");
  if (mysqli_num_rows($result) > 0) {
    // List ID is valid, proceed with deletion
    $result = mysqli_query($conn, "delete from lists where id = '$id'");
    if ($result) {
      $returndata["success"] = true;
      $returndata["massage"] = "List deleted successfully";
    } else {
      $returndata["massage"] = "List not deleted";
    }
  } else {
    $returndata["massage"] = "Invalid list ID";
  }

  echo json_encode($returndata, true);
}

// listupdate api 
if (isset($_POST['listrename'])) {
  $check_api = 0;
  $returndata["success"] = false;
  $listId = $_POST['listId'];
  $listName = $_POST['listName'];
  if (empty($listId)) {
    $returndata["message"] = "List ID is required.";
    echo json_encode($returndata, true);
    exit;
  }
  if (empty($listName)) {
    $returndata["message"] = "List name is required.";
    echo json_encode($returndata, true);
    exit;
  }
  $updateQuery = "UPDATE lists SET list_name = '$listName' WHERE id = '$listId'";
  $result = mysqli_query($conn, $updateQuery);
  if ($result) {
    $returndata["success"] = true;
    $returndata["message"] = "List updated successfully";
  } else {
    $returndata["message"] = "Failed to update list";
  }
  echo json_encode($returndata, true);
}

// PHP Code (server.php)
// if (isset($_POST['action'])) {
//   $check_api = 0;
//   $id = $_POST['id'];
//   $value = $_POST['value'];
//   $column = ($_POST['action'] == 'updateImp') ? 'is_imp' : 'is_don';
//   $newValue = ($value == 0) ? 1 : 0;

//   $result = mysqli_query($conn, "UPDATE tasks SET $column = '$newValue' WHERE id = '$id'");

//   $response = [
//     "success" => $result ? true : false,
//     "message" => $result ? (($_POST['action'] == 'updateImp') ? "Task marked as important successfully" : "Task completed successfully") : "Failed to update task"
//   ];
//   echo json_encode($response);
// }

if (isset($_POST['defaultList'])) {
  $check_api = 0;
  $returndata["success"] = false;

  $result = mysqli_query($conn, "SELECT id , list_name  from lists where is_default = '1'");
  if ($result) {
    $data = [];
    while ($row = mysqli_fetch_assoc($result)) {
      $data[] = $row;
    }
    $returndata["listData"] = $data;
    $returndata["success"] = true;
    $returndata["massage"] = "Data fetched success fully";
  } else {
    $returndata["success"] = true;
    $returndata["massage"] = "Data not found";
  }
  echo json_encode($returndata, true);
}

if (isset($_POST['updateImp'])) {
  $check_api = 0;
  $returndata["success"] = false;
  $id = $_POST['id'];
  $imp = $_POST['imp'];
  if ($imp == 0) {
    $is_imp = 1;
  } else {
    $is_imp = 0;
  }
  $result = mysqli_query($conn, query: "update tasks set is_imp ='$is_imp'  WHERE id = '$id'");
  if ($result) {
    $returndata["success"] = true;
    $returndata["massage"] = "Task add Important successfully";
  } else {
    $returndata["success"] = true;
    $returndata["massage"] = "Task not add Important successfully";
  }
  echo json_encode($returndata, true);
}

if (isset($_POST['updateDon'])) {
  $check_api = 0;
  $returndata["success"] = false;
  $id = $_POST['id'];
  $isDon = $_POST['isDon'];
  $where = "";
  // $listId = $_POST['listId'];


  if ($isDon == 0) {
    $is_don = 1;
  } else {
    $is_don = 0;
  }
  $returndata["countTaskComp"] = 0;

  $result = mysqli_query($conn, "update tasks set is_don ='$is_don'   where id = '$id'");

  if ($result) {

    $returndata["success"] = true;
    $returndata["massage"] = "Task completed successfully";
  } else {
    $returndata["success"] = true;
    $returndata["massage"] = "Task not completed successfully";
  }
  // }
  echo json_encode($returndata, true);
}

if ($check_api == 1) {
  $returndata["success"] = false;
  $returndata["massage"] = "Invalid request Api";
  echo json_encode($returndata, true);
}
?>