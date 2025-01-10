<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Mambo Quiz</title>
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
            padding: 40px 20px;
        }

        .dashboard-container {
            max-width: 1000px;
            margin: 0 auto;
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 20px;
            padding: 40px;
            position: relative;
            overflow: hidden;
        }

        .dashboard-container::before {
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

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            position: relative;
        }

        h1 {
            color: #184e68;
            font-size: 2.5rem;
            font-weight: 600;
        }

        h2 {
            color: #2c5364;
            font-size: 1.5rem;
            margin-bottom: 30px;
        }

        h3 {
            color: #184e68;
            font-size: 1.8rem;
            margin-bottom: 20px;
        }

        .quiz-list {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 20px;
            margin: 30px 0;
        }

        .quiz-item {
            background: white;
            border-radius: 15px;
            padding: 20px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            transition: transform 0.2s ease, box-shadow 0.2s ease;
            position: relative;
            overflow: hidden;
        }

        .quiz-item:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15);
        }

        .quiz-item h4 {
            color: #184e68;
            font-size: 1.3rem;
            margin-bottom: 10px;
        }

        .quiz-item p {
            color: #666;
            margin-bottom: 20px;
            line-height: 1.5;
        }

        .btn {
            display: inline-block;
            padding: 12px 25px;
            border-radius: 12px;
            text-decoration: none;
            font-weight: 600;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .btn:hover {
            transform: translateY(-2px);
        }

        .start-quiz {
            background: linear-gradient(135deg, #2c5364 0%, #57ca85 100%);
            color: white;
            box-shadow: 0 4px 15px rgba(87, 202, 133, 0.3);
        }

        .start-quiz:hover {
            box-shadow: 0 6px 20px rgba(87, 202, 133, 0.4);
        }

        .materi {
            background: linear-gradient(135deg, #ffd700 0%, #ffa500 100%);
            color: #333;
            box-shadow: 0 4px 15px rgba(255, 193, 7, 0.3);
            margin-right: 15px;
        }

        .materi:hover {
            box-shadow: 0 6px 20px rgba(255, 193, 7, 0.4);
        }

        .logout {
            background: linear-gradient(135deg, #184e68 0%, #2c5364 100%);
            color: white;
            box-shadow: 0 4px 15px rgba(24, 78, 104, 0.3);
        }

        .logout:hover {
            box-shadow: 0 6px 20px rgba(24, 78, 104, 0.4);
        }

        .actions {
            margin-bottom: 30px;
        }

        .no-quiz {
            text-align: center;
            color: #666;
            font-size: 1.2rem;
            padding: 40px;
            background: white;
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        @media (max-width: 768px) {
            .dashboard-container {
                padding: 20px;
            }

            .header {
                flex-direction: column;
                text-align: center;
                gap: 15px;
            }

            .quiz-list {
                grid-template-columns: 1fr;
            }

            .actions {
                display: flex;
                flex-direction: column;
                gap: 10px;
            }

            .btn {
                width: 100%;
                text-align: center;
            }
        }
    </style>
</head>
<body>
    <div class="dashboard-container">
        <div class="header">
            <h1>Dashboard</h1>
            <h2>Welcome, <?= esc(session()->get('user')['username'] ?? 'Guest') ?>! 👋</h2>
        </div>

        <div class="actions">
            <a href="/materi" class="btn materi">📚 Learning Materials</a>
            <a href="/user/logout" class="btn logout">🚪 Logout</a>
        </div>

        <h3>Available Quizzes</h3>
        <div class="quiz-list">
            <?php if (!empty($quizzes) && is_array($quizzes)): ?>
                <?php foreach ($quizzes as $quiz): ?>
                    <div class="quiz-item">
                        <h4><?= esc($quiz['title']) ?></h4>
                        <p><?= esc($quiz['description']) ?></p>
                        <a href="/quiz/start/<?= esc($quiz['id']) ?>" class="btn start-quiz">▶️ Start Quiz</a>
                    </div>
                <?php endforeach ?>
            <?php else: ?>
                <div class="no-quiz">
                    <p>No quizzes available at the moment. Check back later! 📝</p>
                </div>
            <?php endif ?>
        </div>
    </div>
</body>
</html>