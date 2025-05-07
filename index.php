<?php
if (isset($_POST['Register'])) {
    $fullName = $_POST['fullName'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $phoneNumber = $_POST['phoneNumber'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirmPassword']; // Get the confirmation password
    $gender = $_POST['gender'];   
    
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

    // Check if the email already exists
    $emailCheck = "SELECT * FROM self_education WHERE email='$email'";
    $result = mysqli_query($conn, $emailCheck);

    if (mysqli_num_rows($result) > 0) {
        echo "<script type='text/javascript'> alert('This email is already in use. Please use another email.');</script>"; 
    } elseif ($password !== $confirmPassword) {
        echo "<script type='text/javascript'> alert('Passwords do not match!');</script>"; 
    } elseif (strlen($password) < 8 || 
              !preg_match('/[A-Z]/', $password) || 
              !preg_match('/[a-z]/', $password) || 
              !preg_match('/\d/', $password) || 
              !preg_match('/[!@#$%^&*(),.?":{}|<>]/', $password)) {
        echo "<script type='text/javascript'> alert('Password must be at least 8 characters long and include uppercase letters, lowercase letters, numbers, and special characters.');</script>"; 
    } else {
        // Hash the password
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Prepare the SQL statement
        $sql = "INSERT INTO self_education (fullName, username, email, phoneNumber, password, gender) VALUES ('$fullName', '$username', '$email', '$phoneNumber', '$hashedPassword', '$gender')";
        
        if (!empty($email) && !empty($password) && !is_numeric($email)) {
            if (mysqli_query($conn, $sql)) {
                // Redirect to subproject12.html after successful registration
                header("Location: subproject12.html");
                exit(); // Make sure to exit after the redirect
            } else {
                echo "<script type='text/javascript'> alert('Error: " . mysqli_error($conn) . "');</script>"; 
            }
        }
    }
    
    // Close the connection
    mysqli_close($conn);
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>Responsive Registration Form</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <link rel="stylesheet" href="style.css" />
    <style>
        /* Your existing CSS styles */
      
        .login-link {
            text-align: center;
            margin-top: 20px;
            font-size: 16px;
        }
        .login-link a {
            color: #00ffff;
            font-weight: bold;
            text-decoration: none;
            text-shadow: 0 0 5px #00ffff;
            transition: color 0.3s ease-in-out;
        }
        .login-link a:hover {
            text-decoration: underline;
            color: #00ffff;
        }
        .temp {
            color: whitesmoke;
        }
        .error {
            color: red;
        }
        .success {
            color: green;
        }
        a {
            text-decoration: none;
        }
        .welcome-title, .website-title {
            font-size: 36px;
            text-align: center;
            color: #00ffff; /* Change to your preferred color */
            animation: blink 1s infinite; /* Animation for blinking */
        }
        @keyframes blink {
            0%, 100% {
                opacity: 1;
            }
            50% {
                opacity: 0; /* Fades out */
            }
        }
    </style>
</head>
<body >
    <div class="container">
        <h1 class="welcome-title">Welcome to Our Self-Education </h1>
        <h1 class="welcome-title" style="text-align: center;">Website!</h1>
        <h1 class="form-title">Registration<br>Self-Educational Website</h1> 
        <form id="registrationForm" action="#" method="POST" autocomplete="off">
            <div class="main-user-info">
                <div class="user-input-box">
                    <label for="fullName">Full Name</label>
                    <input type="text" id="fullName" name="fullName" placeholder="Enter Full Name" required />
                </div>
                <div class="user-input-box">
                    <label for="username">Username</label>
                    <input type="text" id="username" name="username" placeholder="Enter Username" required />
                </div>
                <div class="user-input-box">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" placeholder="Enter Email" required />
                </div>
                <div class="user-input-box">
                    <label for="phoneNumber">Phone Number</label>
                    <input type="text" id="phoneNumber" name="phoneNumber" placeholder="Enter Phone Number" required />
                </div>
                <div class="user-input-box">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" placeholder="Enter Password" required />
                    <span id="passwordStrength" class="error"></span>
                </div>
                <div class="user-input-box">
                    <label for="confirmPassword">Confirm Password</label>
                    <input type="password" id="confirmPassword" name="confirmPassword" placeholder="Confirm Password" required />
                    <span id="passwordMismatch" class="error"></span>
                </div>
            </div>
            <div class="gender-details-box" style="align-items: center;">
                <span class="gender-title">Gender</span>
                <div class="gender-category">
                    <input type="radio" name="gender" id="male" value="male" required>
                    <label for="male">Male</label>
                    <input type="radio" name="gender" id="female" value="female" required>
                    <label for="female">Female</label>
                </div>
            </div>
            <div class="form-submit-btn">
                <input type="submit" value="Register" name="Register">
            </div>
        </form>
        <div class="login-link">
            <p class="temp">Already have an account? <a href="login.php">Login here</a></p>
        </div>
    </div>

    <script>
        const passwordInput = document.getElementById('password');
        const confirmPasswordInput = document.getElementById('confirmPassword');
        const passwordStrength = document.getElementById('passwordStrength');
        const passwordMismatch = document.getElementById('passwordMismatch');

        passwordInput.addEventListener('input', () => {
            const password = passwordInput.value;
            const hasUpperCase = /[A-Z]/.test(password);
            const hasLowerCase = /[a-z]/.test(password);
            const hasNumbers = /\d/.test(password);
            const hasSymbols = /[!@#$%^&*(),.?":{}|<>]/.test(password);

            if (password.length < 8) {
                passwordStrength.textContent = 'Password must be at least 8 characters.';
                passwordStrength.style.color = 'red';
            } else if (!hasUpperCase || !hasLowerCase || !hasNumbers || !hasSymbols) {
                passwordStrength.textContent = 'Password must contain at least one uppercase letter, one lowercase letter, one number, and one special character.';
                passwordStrength.style.color = 'red';
            } else {
                passwordStrength.textContent = 'Password is strong.';
                passwordStrength.style.color = 'green'; // Change text color to green for strong password
            }
        });

        confirmPasswordInput.addEventListener('input', () => {
            if (passwordInput.value !== confirmPasswordInput.value) {
                passwordMismatch.textContent = 'Passwords do not match!';
            } else {
                passwordMismatch.textContent = '';
            }
        });
    </script>

</body>
</html>