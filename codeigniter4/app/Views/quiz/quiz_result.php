<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($quizTitle) ?> - Result</title>
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

        .result-container {
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

        .result-container::before {
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
            margin-bottom: 30px;
            position: relative;
        }

        .score {
            background: white;
            padding: 25px;
            border-radius: 15px;
            margin-bottom: 30px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            text-align: center;
            position: relative;
        }

        .score p {
            font-size: 1.5rem;
            color: #184e68;
            font-weight: 600;
        }

        .answers h3 {
            color: #184e68;
            margin-bottom: 20px;
            font-size: 1.3rem;
            position: relative;
        }

        .question {
            background: white;
            padding: 25px;
            border-radius: 15px;
            margin-bottom: 20px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .question h4 {
            color: #184e68;
            margin-bottom: 15px;
            font-size: 1.1rem;
        }

        .answer {
            padding: 15px;
            border-radius: 10px;
            margin-bottom: 10px;
        }

        .answer strong {
            display: block;
            margin-bottom: 5px;
        }

        .correct {
            background: rgba(87, 202, 133, 0.1);
            color: #2d8a4f;
            border-left: 4px solid #57ca85;
        }

        .incorrect {
            background: rgba(255, 107, 107, 0.1);
            color: #d63031;
            border-left: 4px solid #ff6b6b;
        }

        .back-button {
            background: linear-gradient(135deg, #184e68 0%, #57ca85 100%);
            color: white;
            padding: 15px 30px;
            border-radius: 12px;
            text-decoration: none;
            font-weight: 600;
            display: inline-block;
            transition: all 0.3s ease;
            position: relative;
        }

        .back-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(24, 78, 104, 0.3);
        }

        @media (max-width: 768px) {
            .result-container {
                padding: 20px;
            }

            .question {
                padding: 20px;
            }

            h1 {
                font-size: 1.5rem;
            }

            .score p {
                font-size: 1.2rem;
            }
        }
    </style>
</head>
<body>
    <div class="result-container">
        <h1><?= esc($quizTitle) ?> - Result</h1>
        
        <div class="score">
            <p>Your Score: <?= esc($score) ?> out of <?= esc($totalQuestions) ?></p>
        </div>

        <div class="answers">
            <h3>Detailed Results</h3>
            <?php foreach ($correctAnswers as $questionId => $answer): ?>
                <div class="question">
                    <?php $question = (new \App\Models\QuestionModel())->find($questionId); ?>
                    <h4><?= esc($question['question_text']) ?></h4>
                    <div class="answer <?= ($answer['selected_option_id'] == $answer['correct_option_id']) ? 'correct' : 'incorrect' ?>">
                        <strong>Your Answer:</strong> 
                        <?php 
                            $selectedOption = (new \App\Models\OptionModel())->find($answer['selected_option_id']);
                            echo esc($selectedOption['option_text']);
                        ?>
                    </div>
                    <div class="answer correct">
                        <strong>Correct Answer:</strong> 
                        <?php 
                            $correctOption = (new \App\Models\OptionModel())->find($answer['correct_option_id']);
                            echo esc($correctOption['option_text']);
                        ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <a href="/dashboard" class="back-button">← Back to Dashboard</a>
    </div>
</body>
</html>