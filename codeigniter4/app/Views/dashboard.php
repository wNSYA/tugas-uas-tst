<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }

        h1 {
            font-size: 2rem;
            margin-bottom: 20px;
        }

        .quiz-list {
            margin-bottom: 20px;
        }

        .quiz-item {
            border: 1px solid #ccc;
            padding: 10px;
            margin-bottom: 10px;
            border-radius: 5px;
        }

        .start-quiz {
            display: inline-block;
            text-decoration: none;
            background-color: #28a745;
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            transition: background-color 0.3s;
        }

        .start-quiz:hover {
            background-color: #218838;
        }

        .logout {
            display: inline-block;
            text-decoration: none;
            background-color: #007bff;
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            transition: background-color 0.3s;
        }

        .logout:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <h1>Dashboard</h1>

    <h2>Welcome, <?= esc(session()->get('user')['username'] ?? 'Guest') ?>!</h2>

    <div class="quiz-list">
        <h3>Kuis yang Tersedia:</h3>
        <?php if (!empty($quizzes) && is_array($quizzes)): ?>
            <?php foreach ($quizzes as $quiz): ?>
                <div class="quiz-item">
                    <h4><?= esc($quiz['title']) ?></h4>
                    <p><?= esc($quiz['description']) ?></p>
                    <a href="/quiz/start/<?= esc($quiz['id']) ?>" class="start-quiz">Start Quiz</a>
                </div>
            <?php endforeach ?>
        <?php else: ?>
            <p>No quizzes available at the moment.</p>
        <?php endif ?>
    </div>

    <a href="/user/logout" class="logout">Logout</a>
</body>
</html>
