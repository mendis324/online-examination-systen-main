<?php
session_start();
if(isset($_SESSION["email"])){
session_destroy();
}
include_once 'dbConnection.php';
$ref=@$_GET['q'];
$email = $_POST['email'];
$password = $_POST['password'];

$email = stripslashes($email);
$email = addslashes($email);
$password = stripslashes($password); 
$password = addslashes($password);
#$password=md5($password); 
error_log("usename:$email password: $password ");
$result = mysqli_query($con,"SELECT name,role FROM users WHERE email = '$email' and password = '$password'") or die('Error');
$count=mysqli_num_rows($result);
if($count==1){
while($row = mysqli_fetch_array($result)) {
	$name = $row['name'];
	$role = $row['role'];
}
$_SESSION["name"] = $name;
$_SESSION["email"] = $email;
$_SESSION["role"] = $role;
error_log("role:$role");
    // Redirect based on user role
    if ($role == 'admin') {
        $_SESSION["session_key"] = 'sunny7785068889';
        header("location:dash.php?q=0"); // Admin page
    } else if ($role == 'user') {
        header("location:account.php?q=1"); // User page
    } else {
        header("Location: error.php"); // If role is unknown or missing, redirect to error page
    }
} else {
    // If login fails, redirect back with an error message
    header("Location: $ref?w=Wrong Username or Password");
}

?>