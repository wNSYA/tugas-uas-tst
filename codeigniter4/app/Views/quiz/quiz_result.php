<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($quizTitle) ?> - Result</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }

        h1 {
            font-size: 2rem;
            margin-bottom: 20px;
        }

        .result {
            margin-top: 20px;
        }

        .question {
            margin-bottom: 20px;
        }

        .answer {
            margin-bottom: 10px;
        }

        .correct {
            color: green;
        }

        .incorrect {
            color: red;
        }

        .score {
            margin-top: 20px;
            font-size: 1.2rem;
        }

        .back-button {
            margin-top: 30px;
            display: inline-block;
            background-color: #007bff;
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            text-decoration: none;
        }

        .back-button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <h1><?= esc($quizTitle) ?> - Result</h1>
    <div class="result">
        <div class="score">
            <p>Your Score: <?= esc($score) ?> out of <?= esc($totalQuestions) ?></p>
        </div>

        <div class="answers">
            <h3>Answers:</h3>
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

        <a href="/dashboard" class="back-button">Back to Dashboard</a>
    </div>
</body>
</html>
