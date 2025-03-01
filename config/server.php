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
    $returndata["password_error"] = "Passwords do rohit match.";
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

  $returntaskdata["success"] = false;
  $taskerrcount = 0;

  if (isset($_POST['taskinput']) && isset($_POST['user_id'])) {

    $taskinput = $_POST['taskinput'];
    $user_id = $_POST['user_id'];

    if (empty($taskinput)) {
      $returntaskdata["massage"] = "Task is required.";
      $taskerrcount++;
    }

    if (empty($user_id)) {
      $returntaskdata["massage"] = "User id is required.";
      $taskerrcount++;
    }
    if ($taskerrcount == 0) {
      $qry = mysqli_query($conn, "select id from users where id = '$user_id'");
      if (mysqli_num_rows($qry) < 1) {
        $returntaskdata["massage"] = "User id not found";
        $taskerrcount++;
      }
    }

    if ($taskerrcount == 0) {
      $qry = "insert into tasks (tasks_name ,created_by , updated_by) values ('$taskinput' , '$user_id' , '$user_id')";
      $result = mysqli_query($conn, $qry);
      if ($result) {
        $run = mysqli_query($conn, "select * from  tasks where created_by = '$user_id' order by id desc");
        if ($run) {
          $data = [];
          while ($row = mysqli_fetch_assoc($run)) {
            $data[] = $row;
          }
        }
        $returntaskdata["tasklist"] = $data;
        $returntaskdata["success"] = true;
        $returntaskdata["massage"] = "Add task successfully";
      } else {
        $returntaskdata["massage"] = "add task not successfully";
      }
    }
  } else {
    $returntaskdata["massage"] = "Task input or user id not found";
  }
  echo json_encode($returntaskdata, true);
}

// fetching data from database
if (isset($_POST['getData'])) {

  $check_api = 0;

  $returntaskdata["success"] = false;

  $result = mysqli_query($conn, "select * from tasks where created_by = '$_SESSION[loginid]' order by  id desc");
  if ($result) {
    $data = [];
    while ($row = mysqli_fetch_assoc(result: $result)) {
      $data[] = $row;
    }
    $returntaskdata["tasklist"] = $data;
    $returntaskdata["success"] = true;
    $returntaskdata["massage"] = "Data fetched success fully";
  }
  echo json_encode($returntaskdata, true);
}

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

// update task 
if (isset($_POST['updateTask'])) {

  $check_api = 0;

  $returndata["success"] = false;
  $id = $_POST['id'];
  $task = $_POST['task'];
  $errcount = 0;

  if ($task == '') {
    $returndata["task_error"] = "Task is required.";
    $errcount++;
  }

  if ($errcount == 0) {
    $result = mysqli_query($conn, "update tasks set task = '$task' where id = '$id'");
    if ($result) {
      $returndata["success"] = true;
      $returndata["massage"] = "Task updated successfully";
    } else {
      $returndata["massage"] = "Task not updated successfully";
    }
  }
  echo json_encode($returndata, true);
}

//  new list create 
if (isset($_POST['newListdata'])) {
  $check_api = 0;
  // $user_id = $_POST['user_id'];
  $list_name = $_POST['listname'];
  $returndata = ["success" => false];

  $run = mysqli_query($conn, "INSERT INTO lists (list_name 	) VALUES ('$list_name' )");
  if ($run) {
    $result = mysqli_query($conn, "select id , list_name from lists where  id = '$conn->insert_id' ORDER BY id desc");
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
  $result = mysqli_query($conn, "select id, list_name from lists  ORDER BY id desc");
  if ($result) {
    $data = [];
    while ($row = mysqli_fetch_assoc($result)) {
      $data[] = $row;
    }
    $returndata["getnewlistdata"] = $data;
    $returndata["success"] = true;
  } else {
    $returndata["success"] = false;
  }

  echo json_encode($returndata, true);
}
// delete list
if (isset($_POST['deletelistapi'])) {
  $check_api = 0;
  $returndata["success"] = false;
  $id = $_POST['id'];

  // Validate list ID
  $query = "SELECT id FROM lists WHERE id = '$id'";
  $result = mysqli_query($conn, $query);
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

  $listId = $_POST['id'];
  $listName = isset($_POST['rename']) ?? '';

  // Check if list exists
  // $query = mysqli_query($conn, "SELECT id FROM lists WHERE id = '$listId'");
  // if (mysqli_num_rows($query) > 0) {
    // Update list name
    $updateQuery = "UPDATE lists SET list_name = '$listName' WHERE id = '$listId'";
    $result = mysqli_query($conn, $updateQuery);

    if ($result) {
      $returndata["success"] = true;
      $returndata["message"] = "List updated successfully";
    } else {
      $returndata["message"] = "Failed to update list";
    }
  // } else {
  //   $returndata["message"] = "Invalid list ID";
  // }

  echo json_encode($returndata, true);
}

// apifetch error 
if ($check_api == 1) {
  $returndata["success"] = false;
  $returndata["massage"] = "Invalid request Api";
  echo json_encode($returndata, true);
}

?>