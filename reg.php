<?php

session_start(); // Move this to the top
include("reg.php");

// Enable error reporting
ini_set('display_errors', 1);
error_reporting(E_ALL);

// This PHP section handles the form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fullName = $_POST['fullName'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $phoneNumber = $_POST['phoneNumber'];
    $password = $_POST['password'];
    $gender = $_POST['gender'];
    
    if (!empty($email) && !empty($password) && !is_numeric($email)) {
        $query = "INSERT INTO self_education (fullName, username, email, phoneNumber, password, gender) VALUES ('$fullName', '$username', '$email', '$phoneNumber', '$password', '$gender')";
        if (mysqli_query($conn, $query)) {
            echo "<script type='text/javascript'> alert('Successfully Registered');</script>";
        } else {
            echo "<script type='text/javascript'> alert('Please enter some valid information');</script>"; 
        }
    }
}

$conn = mysqli_connect("localhost:8080", "root", "", "self_education")or die(mysql_error());
?>