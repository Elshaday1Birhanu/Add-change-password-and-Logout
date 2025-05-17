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
if (isset($_POST['action']) && $_POST['action'] === 'change') {
    $response = array();
    $email = trim(mysqli_real_escape_string($conn, $_POST['email']));
    $current_password = $_POST['current_password'];
    $new_password = $_POST['new_password'];
    $query = "SELECT id, password FROM self_education WHERE email = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, 's', $email);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    if ($row = mysqli_fetch_assoc($result)) {
        if (password_verify($current_password, $row['password'])) {
            $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
            $update_query = "UPDATE self_education SET password = ? WHERE id = ?";
            $update_stmt = mysqli_prepare($conn, $update_query);
            mysqli_stmt_bind_param($update_stmt, 'si', $hashed_password, $row['id']);
            if (mysqli_stmt_execute($update_stmt)) {
                $response['success'] = true;
                $response['message'] = 'Password updated successfully! Redirecting to login page...';
            } else {
                $response['success'] = false;
                $response['message'] = 'Failed to update password. Please try again.';
                error_log("Password update SQL error: " . mysqli_error($conn));
            }
            mysqli_stmt_close($update_stmt);
        } else {
            $response['success'] = false;
            $response['message'] = 'Current password is incorrect.';
        }
    } else {
        $response['success'] = false;
        $response['message'] = 'Email not found.';
    }
    mysqli_stmt_close($stmt);
    header('Content-Type: application/json');
    echo json_encode($response);
    mysqli_close($conn);
    exit();
}

// Initialize messages
$error_message = "";
$success_message = "";

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['Login'])) {
        $usernameOrEmail = trim(strtolower($_POST['usernameOrEmail']));
        $password = $_POST['password'];
        $stmt = mysqli_prepare($conn, "SELECT * FROM self_education WHERE LOWER(username)=? OR LOWER(email)=?");
        mysqli_stmt_bind_param($stmt, 'ss', $usernameOrEmail, $usernameOrEmail);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            if (password_verify($password, $row['password'])) {
                $_SESSION['user_id'] = $row['id'];
                header("Location: subproject12.html");
                exit();
            } else {
                $error_message = "Incorrect password.";
            }
        } else {
            $error_message = "Invalid credentials.";
        }
    } 
    // Reset password functionality
    elseif (isset($_POST['reset_request'])) {
        $email = trim(strtolower($_POST['email']));
        $stmt = mysqli_prepare($conn, "SELECT * FROM self_education WHERE LOWER(email)=?");
        mysqli_stmt_bind_param($stmt, 's', $email);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        
        if (mysqli_num_rows($result) > 0) {
            $token = bin2hex(random_bytes(32));
            $expires = date("Y-m-d H:i:s", strtotime('+1 hour'));
            $updateStmt = mysqli_prepare($conn, "UPDATE self_education SET reset_token=?, reset_expires=? WHERE LOWER(email)=?");
            mysqli_stmt_bind_param($updateStmt, 'sss', $token, $expires, $email);
            mysqli_stmt_execute($updateStmt);
            $mail = new PHPMailer(true);
            try {
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = 'elshadaybirhanu75@gmail.com';
                $mail->Password = 'miua xleb vrjl suhh';
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port = 587;
                $mail->setFrom('elshadaybirhanu75@gmail.com', 'Self Education System');
                $mail->addAddress($email);
                $mail->isHTML(true);
                $mail->Subject = 'Password Reset Request';
                $resetLink = "http://localhost/web_project/login.php?action=reset&token=" . urlencode($token);
                $mail->Body = "<p>You requested a password reset. Click the link below to reset your password:</p><p><a href='$resetLink'>Reset Password</a></p><p>This link will expire in 1 hour.</p>";
                $mail->send();
                $success_message = 'Password reset link has been sent to your email!';
            } catch (Exception $e) {
                error_log("Mailer Error: " . $mail->ErrorInfo);
                $error_message = 'Failed to send reset email. Please try again later.';
            }
        } else {
            $error_message = "Email not found.";
        }
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
