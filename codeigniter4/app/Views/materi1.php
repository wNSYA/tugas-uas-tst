<?php
// Decode the JSON string

$data = json_decode($items, true);

if ($data["status"] === 200) {
    $item = $data["data"];
} else {
    $item = null;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Materi Detail</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            padding: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        .container {
            max-width: 800px;
            border: 1px solid #ccc;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .container h1 {
            font-size: 24px;
            margin-bottom: 10px;
        }
        .container p {
            font-size: 16px;
            line-height: 1.5;
            margin-bottom: 20px;
        }
        .container a {
            display: inline-block;
            padding: 10px 20px;
            background-color: #007BFF;
            color: white;
            text-decoration: none;
            border-radius: 4px;
            transition: background-color 0.3s;
        }
        .container a:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>

<?php if ($item): ?>
    <div class="container">
        <h1><?php echo htmlspecialchars($item["name"]); ?></h1>
        <p><?php echo htmlspecialchars($item["description"]); ?></p>
        <a href="<?php echo htmlspecialchars($item["video_link"]); ?>" target="_blank">Watch Video</a>
    </div>
<?php else: ?>
    <p>Data not available.</p>
<?php endif; ?>

</body>
</html>
