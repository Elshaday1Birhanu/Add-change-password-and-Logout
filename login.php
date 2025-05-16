<?php
$error_message = ""; // Initialize error message variable

if (isset($_POST['Login'])) {
    $usernameOrEmail = $_POST['usernameOrEmail'];
    $password = $_POST['password'];

    $host = 'localhost';
    $user = 'root';
    $pass = '';
    $dbname = 'self_education';

    // Create connection
    $conn = mysqli_connect($host, $user, $pass, $dbname);

    // Check connection
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // Check if the email is already registered
    $checkEmailSql = "SELECT * FROM self_education WHERE email=?";
    $checkEmailStmt = mysqli_prepare($conn, $checkEmailSql);
    mysqli_stmt_bind_param($checkEmailStmt, 's', $usernameOrEmail);
    mysqli_stmt_execute($checkEmailStmt);
    $emailResult = mysqli_stmt_get_result($checkEmailStmt);

    if (mysqli_num_rows($emailResult) > 0) {
        // If the email is registered, proceed to login attempt
        $sql = "SELECT * FROM self_education WHERE username=? OR email=?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, 'ss', $usernameOrEmail, $usernameOrEmail);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            // Verify the password
            if (password_verify($password, $row['password'])) {
                // Start the session and redirect to subproject12.html
                session_start();
                $_SESSION['user_id'] = $row['id']; // Store user ID in session
                header("Location: subproject12.html"); // Redirect to subproject12.html
                exit();
            } else {
                $error_message = "Incorrect password."; // Set error message for incorrect password
            }
        } else {
            $error_message = "No user found with this username or email."; // Set error message for no user found
        }
    } else {
        $error_message = "Email is not registered."; // Set error message for unregistered email
    }
elseif (isset($_POST['reset_password'])) {
        $token = trim($_POST['token']);
        $password = $_POST['password'];
        $stmt = mysqli_prepare($conn, "SELECT * FROM self_education WHERE reset_token=? AND reset_expires > ?");
        $current_time = date('Y-m-d H:i:s');
        mysqli_stmt_bind_param($stmt, 'ss', $token, $current_time);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $updateStmt = mysqli_prepare($conn, "UPDATE self_education SET password=?, reset_token=NULL, reset_expires=NULL WHERE id=?");
            mysqli_stmt_bind_param($updateStmt, 'si', $hashed_password, $row['id']);
            if (mysqli_stmt_execute($updateStmt)) {
                $success_message = "Password reset successfully! You can now login.";
                header("Refresh: 3; url=login.php");
            } else {
                $error_message = "Failed to reset password. Please try again.";
                error_log("Password update error: " . mysqli_error($conn));
            }
        } else {
            $error_message = "Invalid or expired reset token. Please request a new password reset.";
            error_log("Invalid token attempt with token: " . $token);
        }
    }
}

$show_reset_form = isset($_GET['token']) || (isset($_GET['action']) && $_GET['action'] === 'reset');
$token = isset($_GET['token']) ? $_GET['token'] : '';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <style>
        body {
            background-image: url('E.jpg'); /* Replace with your image path */
            background-size: cover;
            color: #ffffff;
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .login-container {
            background-color: rgba(30, 30, 30, 0.8);
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
            width: 300px;
        }
        h2 {
            text-align: center;
        }
        input[type="text"], input[type="password"], input[type="email"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #555;
            border-radius: 5px;
            background-color: #333;
            color: #fff;
        }
        button {
            width: 100%;
            padding: 10px;
            background-color: #4CAF50;
            border: none;
            border-radius: 5px;
            color: white;
            font-size: 16px;
            cursor: pointer;
        }
        button:hover {
            background-color: #45a049;
        }
        .signup-link {
            text-align: center;
            margin-top: 10px;
        }
        .signup-link a {
            color: #4CAF50;
            text-decoration: none;
        }
        .error-message {
            background-color: #ffcccc; /* Light red background */
            color: #d8000c; /* Dark red color */
            border: 1px solid #d8000c; /* Dark red border */
            padding: 10px;
            margin-bottom: 10px;
            border-radius: 5px;
            text-align: center;
        }
    </style>
</head>
<body>

<div class="login-container">
    <h2>Login</h2>
    <?php if ($error_message): ?>
        <div class="error-message"><?php echo $error_message; ?></div>
    <?php endif; ?>
    <form action="login.php" method="POST">
        <input type="text" name="usernameOrEmail" placeholder="Username or Email" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit" name="Login">Login</button>
    </form>
    <div class="signup-link">
        Don't have an account? <a href="index.php">Sign up here</a>
    </div>
</div>

</body>
</html>