<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($quiz['title']) ?></title>
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

        .quiz-container {
            max-width: 800px;
            margin: 0 auto;
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 20px;
            padding: 40px;
            position: relative;
            overflow: hidden;
        }

        .quiz-container::before {
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
            font-size: 2rem;
            margin-bottom: 10px;
            position: relative;
        }

        p {
            color: #2c5364;
            margin-bottom: 30px;
            line-height: 1.6;
            position: relative;
        }

        .question {
            background: white;
            padding: 25px;
            border-radius: 15px;
            margin-bottom: 25px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            position: relative;
        }

        h3 {
            color: #184e68;
            margin-bottom: 20px;
            font-size: 1.2rem;
        }

        .options {
            display: grid;
            gap: 12px;
        }

        .option {
            position: relative;
        }

        .option input[type="radio"] {
            display: none;
        }

        .option label {
            display: block;
            padding: 15px 20px;
            background: #f8f9fa;
            border: 2px solid #e9ecef;
            border-radius: 10px;
            cursor: pointer;
            transition: all 0.3s ease;
            color: #2c5364;
        }

        .option input[type="radio"]:checked + label {
            background: #184e68;
            color: white;
            border-color: #184e68;
            transform: translateY(-2px);
            box-shadow: 0 4px 10px rgba(24, 78, 104, 0.2);
        }

        .option label:hover {
            background: #e9ecef;
            transform: translateY(-2px);
        }

        .submit-quiz {
            background: linear-gradient(135deg, #184e68 0%, #57ca85 100%);
            color: white;
            padding: 15px 30px;
            border: none;
            border-radius: 12px;
            font-size: 1.1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            display: block;
            width: 100%;
            margin-top: 30px;
            position: relative;
        }

        .submit-quiz:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(24, 78, 104, 0.3);
        }

        @media (max-width: 768px) {
            .quiz-container {
                padding: 20px;
            }

            .question {
                padding: 20px;
            }

            h1 {
                font-size: 1.5rem;
            }
        }
    </style>
</head>
<body>
    <div class="quiz-container">
        <h1><?= esc($quiz['title']) ?></h1>
        <p><?= esc($quiz['description']) ?></p>

        <form action="/quiz/submit" method="POST">
            <input type="hidden" name="quiz_id" value="<?= esc($quiz['id']) ?>" />

            <?php foreach ($questions as $index => $question): ?>
                <div class="question">
                    <h3>Question <?= $index + 1 ?>: <?= esc($question['question_text']) ?></h3>
                    <div class="options">
                        <?php foreach ($question['options'] as $option): ?>
                            <div class="option">
                                <input type="radio" 
                                       id="option-<?= esc($option['id']) ?>" 
                                       name="answers[<?= esc($question['id']) ?>]" 
                                       value="<?= esc($option['id']) ?>" 
                                       required>
                                <label for="option-<?= esc($option['id']) ?>"><?= esc($option['option_text']) ?></label>
                            </div>
                        <?php endforeach ?>
                    </div>
                </div>
            <?php endforeach ?>
            <button type="submit" class="submit-quiz">Submit Quiz</button>
        </form>
    </div>
</body>
</html>