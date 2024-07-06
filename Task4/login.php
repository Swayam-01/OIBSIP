<?php

session_start();
$_SESSION['login_status'] = false;

//$conn = new mysqli("localhost", "root", "", "project", 3306);
include_once "connection.php";

// Prepare the query to fetch password
$qr = "SELECT password FROM user WHERE username = ?";
$stmt = mysqli_prepare($conn, $qr);
mysqli_stmt_bind_param($stmt, "s", $_POST['username']);
mysqli_stmt_execute($stmt);
$pwd_result = mysqli_stmt_get_result($stmt);

// Fetch the password
if ($pwd_row = mysqli_fetch_assoc($pwd_result)) {
    $password = $pwd_row['password'];

    // Verify the password
    $verify = password_verify($_POST['password'], $password);
}

// Prepare the query to check username and password
$query = "SELECT * FROM user WHERE username = ? AND password = ?";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, "ss", $_POST['username'], $password);
mysqli_stmt_execute($stmt);
$sql_result = mysqli_stmt_get_result($stmt);

// Check if login is successful
if (mysqli_num_rows($sql_result) > 0 or $verify) {
    if ($dbrow = mysqli_fetch_assoc($sql_result)) {
        $_SESSION['login_status'] = true;
        $_SESSION['usertype'] = $dbrow['usertype'];
        $_SESSION['username'] = $dbrow['username'];
        $_SESSION['userid'] = $dbrow['userid'];

        if ($dbrow['usertype'] == 'Vendor') {
            header('location:../vendor/home.php');
            exit;
        } else if ($dbrow['usertype'] == 'Customer') {
            header('location:../customer/view_pdt.php');
            exit;
        }
    }
} else {
    echo "<h1>Login Failed</h1>";
}

// Close statement and connection
mysqli_stmt_close($stmt);
mysqli_close($conn);


// // orignal
// //-----------------------------------------------------------------------------------------------------------------
// $qr = "select password from user where username = '$_POST[username]'"; // writing query to fetch data from database
// // echo $qr;
// $pwd = mysqli_query($conn, $qr); // making request to fetch data
// $pwd = mysqli_fetch_assoc($pwd); // fetching data
// $password = $pwd['password']; //data fetched
// // echo $password;
// $userpwd = $_POST['password'];
// $verify = password_verify($userpwd, $password);
// // if($verify)
// // {
// //     echo "YES";
// // }
// // else{
// //     echo "NO";
// // }
// //-----------------------------------------------------------------------------------------------------------------
// $query = "select * from user where username = '$_POST[username]' and password = '$_POST[password]'";

// //echo $query."<br>";

// $sql_result = mysqli_query($conn, $query);

// //print_r($sql_result);

// if(mysqli_num_rows($sql_result)>0 or $verify){
//     echo "<h1>Login Success</h1>";

//     $dbrow = mysqli_fetch_assoc($sql_result);
//     //print_r($dbrow);

//     $_SESSION['login_status'] = true;
//     $_SESSION['usertype'] = $dbrow['usertype'];
//     $_SESSION['username'] = $dbrow['username'];
//     $_SESSION['userid'] = $dbrow['userid'];

//     if($dbrow['usertype'] == 'Vendor'){
//         header('location:../vendor/home.php');
//     }
//     else if($dbrow['usertype'] == 'Customer'){
//         header('location:../customer/view_pdt.php');
//     }
// }

// else{
//     echo "<h1>Login Failed</h1>";
// }

?>

<!-- {../} means : To get out of the current folder -->
<!-- JWT Token -->