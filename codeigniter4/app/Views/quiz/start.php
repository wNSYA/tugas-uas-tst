<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
    <title><?= esc($quiz['title']) ?></title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }

        h1 {
            font-size: 2rem;
            margin-bottom: 20px;
        }

        .question {
            margin-bottom: 20px;
        }

        .options {
            margin-top: 10px;
        }

        .option {
            margin-bottom: 10px;
        }

        .submit-quiz {
            margin-top: 20px;
            display: inline-block;
            text-decoration: none;
            background-color: #007bff;
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            transition: background-color 0.3s;
        }

        .submit-quiz:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <h1><?= esc($quiz['title']) ?></h1>
    <p><?= esc($quiz['description']) ?></p>

    <form action="/quiz/submit" method="POST">
        <!-- Hidden input to pass the quiz_id -->
        <input type="hidden" name="quiz_id" value="<?= esc($quiz['id']) ?>" />

        <?php foreach ($questions as $index => $question): ?>
            <div class="question">
                <h3>Q<?= $index + 1 ?>: <?= esc($question['question_text']) ?></h3>
                <div class="options">
                    <?php foreach ($question['options'] as $option): ?>
                        <div class="option">
                            <input type="radio" id="option-<?= esc($option['id']) ?>" name="answers[<?= esc($question['id']) ?>]" value="<?= esc($option['id']) ?>" required>
                            <label for="option-<?= esc($option['id']) ?>"><?= esc($option['option_text']) ?></label>
                        </div>
                    <?php endforeach ?>
                </div>
            </div>
        <?php endforeach ?>
        <button type="submit" class="submit-quiz">Submit Quiz</button>
    </form>
</body>
</html>
