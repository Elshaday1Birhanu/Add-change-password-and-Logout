<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Self Education - Learn HTML, CSS, Java, and More</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Roboto', sans-serif;
            background: url('E.jpg') no-repeat center center/cover;
            color: aquamarine;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            overflow: hidden;
            text-align: center;
            
            background-image: url('box.jpeg'); /* Path to your image */
            background-size: cover; /* Cover the entire background */
            background-position: center; /* Center the image */
            background-repeat: no-repeat; /* Prevent the image from repeating */
        
        }

        .container {
            font-family: Copperplate, Papyrus, fantasy;
    padding: 50px;
    position: relative;
    background: rgba(0, 0, 0, 0.6);
    border-radius: 15px;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);
    max-width: 600px;
    width: 200%;
    text-align: center;
    margin-top: auto; /* Pushes content to the bottom */
}

        h1 {
            font-size: 3rem;
            animation: fadeIn 2s;
        }

        p {
            font-size: 1.2rem;
            margin: 20px 0;
            animation: fadeIn 3s;
        }

        .image-container {
            display: flex;
            justify-content: space-around;
            flex-wrap: wrap;
            margin: 20px 0;
        }

        .image-box {
            position: relative;
            width: 100px; /* Adjust the size as needed */
            height: 100px; /* Adjust the size as needed */
            margin: 10px;
            border-radius: 8px;
            overflow: hidden;
        }

        .image-box::before, .image-box::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            border-radius: 8px;
            transition: all 0.5s;
            z-index: 1;
        }

        .image-box:hover::before, .image-box:hover::after {
            transform: scale(1.05);
        }

        .image-box:nth-child(1)::before,
        .image-box:nth-child(1)::after {
            background: linear-gradient(315deg, #ffbc00, #ff0058);
        }

        .image-box:nth-child(2)::before,
        .image-box:nth-child(2)::after {
            background: linear-gradient(315deg, #03a9f4, #ff0058);
        }

        .image-box:nth-child(3)::before,
        .image-box:nth-child(3)::after {
            background: linear-gradient(315deg, #4dff03, #00d0ff);
        }

        .image-box:nth-child(4)::before,
        .image-box:nth-child(4)::after {
            background: linear-gradient(315deg, #ff007e, #ff8c00); /* Gradient for JavaScript */
        }

        .image-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 0;
            height: 0;
            border-radius: 8px;
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            opacity: 0;
            transition: 0.1s;
            animation: animate 2s ease-in-out infinite;
            box-shadow: 0 5px 15px rgba(0,0,0,0.08);
        }

        .image-box:hover .image-overlay {
            width: 100%;
            height: 100%;
            opacity: 1;
        }

        .image-container img {
            max-width: 100%;
            max-height: 100%;
            border-radius: 8px;
            position: relative;
            z-index: 2; /* Ensure the image is above the gradients */
            transition: transform 0.3s;
            animation: animate 2s ease-in-out infinite; /* Apply animation to images */
        }

        @keyframes animate {
            0%, 100% {
                transform: translateY(10px);
            }
            50% {
                transform: translateY(-10px);
            }
        }

        .buttons {
            margin-top: 30px;
            animation: slideIn 2.5s;
        }

        .buttons a {
            text-decoration: none;
            color: aqua;
            background: rgba(0, 0, 0, 0.2);
            padding: 15px 30px;
            margin: 10px;
            border-radius: 30px;
            font-size: 1rem;
            font-weight: bold;
            transition: all 0.3s ease;
        }

        .buttons a:hover {
            background: rgba(255, 255, 255, 0.8);
            color: #333;
            transform: scale(1.1);
        }

        @keyframes fadeIn {
            0% { opacity: 0; }
            100% { opacity: 1; }
        }

        @keyframes slideIn {
            0% { transform: translateY(50px); opacity: 0; }
            100% { transform: translateY(0); opacity: 1; }
        }

        .animation {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1;
            overflow: hidden;
        }

        .animation span {
            position: absolute;
            display: block;
            width: 20px;
            height: 20px;
            background: rgba(255, 255, 255, 0.3);
            border-radius: 50%;
            animation: move 10s linear infinite;
        }

        @keyframes move {
            0% {
                transform: translateY(0);
                opacity: 1;
            }
            100% {
                transform: translateY(-100vh);
                opacity: 0;
            }
        }

        .inspirational-text {
            font-family: Georgia, serif;
            font-size: 1.5rem;
            margin-bottom: 20px;
            animation: fadeIn 1.5s;
            position: absolute;
            top: 20px;
            left: 50%;
            transform: translateX(-50%);
            width: 90%;
            text-align: center;
            color: #000000;
            padding: 40px 20px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.5);
            font-size: 22px;
        
            
        }
        .temp{
            color: aqua;
        }
    </style>
</head>
<body>
    <div class="inspirational-text">
        <h2 class="temp">Programming isn't just about code; it's about creating solutions, building dreams, and shaping the future. Start your journey now!</h2>
    </div>
    <div class="container">
        <h1>Welcome to Self Education</h1>
        <p>Explore tutorials on HTML, CSS, Java, JavaScript, and more! Your journey to self-learning begins here.</p>
        <div class="image-container">
            <div class="image-box">
                <img src="htmlimage.png" alt="HTML">
                <div class="image-overlay"></div>
            </div>
            <div class="image-box">
                <img src="cssimage.png" alt="CSS">
                <div class="image-overlay"></div>
            </div>
            <div class="image-box">
                <img src="javaimage.png" alt="Java">
                <div class="image-overlay"></div>
            </div>
            <div class="image-box">
                <img src="javascript.png" alt="JavaScript">
                <div class="image-overlay"></div>
            </div>
        </div>
        <div class="buttons">
            <a href="login.php">Login</a>
            <a href="index.php">Sign Up</a>
        </div>
    </div>
    <div class="animation">
        <!-- Animation Elements -->
        <span style="left: 10%; animation-delay: 0s;"></span>
        <span style="left: 20%; animation-delay: 2s;"></span>
        <span style="left: 30%; animation-delay: 4s;"></span>
        <span style="left: 50%; animation-delay: 6s;"></span>
        <span style="left: 70%; animation-delay: 3s;"></span>
        <span style="left: 80%; animation-delay: 7s;"></span>
        <span style="left: 90%; animation-delay: 1s;"></span>
    </div>
</body>
</html>
