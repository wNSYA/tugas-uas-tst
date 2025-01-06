<!-- app/Views/landing_page.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mambo Quiz - Landing Page</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
        }

        .container {
            text-align: center;
            max-width: 800px;
            margin: 100px auto;
            padding: 20px;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        h1 {
            color: #333;
            font-size: 3em;
        }

        p {
            color: #555;
            font-size: 1.2em;
        }

        .btn {
            display: inline-block;
            padding: 10px 20px;
            margin: 10px;
            font-size: 1.1em;
            color: #fff;
            text-decoration: none;
            border-radius: 4px;
            transition: background-color 0.3s;
        }

        .btn-primary {
            background-color: #007bff;
        }

        .btn-primary:hover {
            background-color: #0056b3;
        }

        .btn-success {
            background-color: #28a745;
        }

        .btn-success:hover {
            background-color: #218838;
        }

    </style>
</head>
<body>
    <div class="container">
        <h1>Welcome to Mambo Quiz</h1>
        <p>Test your knowledge with our quizzes on various subjects!</p>
        <div>
            <a href="/user/login" class="btn btn-primary">Login</a>
            <a href="/user/register" class="btn btn-success">Sign Up</a>
        </div>
    </div>
</body>
</html>
