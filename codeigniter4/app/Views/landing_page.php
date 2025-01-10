<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mambo Quiz - Landing Page</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            min-height: 100vh;
            background: linear-gradient(135deg, #184e68 0%, #57ca85 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .container {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 20px;
            padding: 60px 40px;
            width: 100%;
            max-width: 800px;
            position: relative;
            overflow: hidden;
            text-align: center;
        }

        .container::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: linear-gradient(
                45deg,
                transparent 40%,
                rgba(255, 255, 255, 0.2) 45%,
                transparent 50%
            );
            transform: rotate(45deg);
            animation: shine 3s infinite;
        }

        @keyframes shine {
            0% { transform: translateX(-100%) rotate(45deg); }
            100% { transform: translateX(100%) rotate(45deg); }
        }

        h1 {
            color: #184e68;
            font-size: 3.5em;
            margin-bottom: 20px;
            position: relative;
            font-weight: 700;
        }

        p {
            color: #2c5364;
            font-size: 1.4em;
            margin-bottom: 40px;
            line-height: 1.6;
        }

        .buttons {
            display: flex;
            gap: 20px;
            justify-content: center;
            position: relative;
        }

        .btn {
            padding: 15px 40px;
            font-size: 1.1em;
            font-weight: 600;
            text-decoration: none;
            border-radius: 12px;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
            position: relative;
            overflow: hidden;
        }

        .btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(
                90deg,
                transparent,
                rgba(255, 255, 255, 0.2),
                transparent
            );
            transition: 0.5s;
        }

        .btn:hover::before {
            left: 100%;
        }

        .btn:hover {
            transform: translateY(-2px);
        }

        .btn-primary {
            background: linear-gradient(135deg, #184e68 0%, #2c5364 100%);
            color: white;
            box-shadow: 0 4px 15px rgba(24, 78, 104, 0.3);
        }

        .btn-primary:hover {
            box-shadow: 0 6px 20px rgba(24, 78, 104, 0.4);
        }

        .btn-success {
            background: linear-gradient(135deg, #2c5364 0%, #57ca85 100%);
            color: white;
            box-shadow: 0 4px 15px rgba(87, 202, 133, 0.3);
        }

        .btn-success:hover {
            box-shadow: 0 6px 20px rgba(87, 202, 133, 0.4);
        }

        /* Quiz icon animation */
        .quiz-icon {
            font-size: 4em;
            color: #184e68;
            margin-bottom: 20px;
            opacity: 0.8;
            animation: float 3s ease-in-out infinite;
        }

        @keyframes float {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
            100% { transform: translateY(0px); }
        }

        @media (max-width: 600px) {
            .container {
                padding: 40px 20px;
            }

            h1 {
                font-size: 2.5em;
            }

            p {
                font-size: 1.2em;
            }

            .buttons {
                flex-direction: column;
            }

            .btn {
                width: 100%;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="quiz-icon">🎯</div>
        <h1>Welcome to Mambo Quiz</h1>
        <p>Challenge yourself and expand your knowledge with our exciting collection of quizzes across various subjects!</p>
        <div class="buttons">
            <a href="/user/login" class="btn btn-primary">Login</a>
            <a href="/user/register" class="btn btn-success">Sign Up</a>
        </div>
    </div>
</body>
</html>