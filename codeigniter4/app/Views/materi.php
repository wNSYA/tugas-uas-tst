<?php
// Decode the JSON string
$data = json_decode($items, true);

if ($data["status"] === 200) {
    $items = $data["data"];
} else {
    $items = [];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JSON to Web Cards</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 20px;
            margin: 20px;
        }
        .card {
            border: 1px solid #ccc;
            border-radius: 8px;
            padding: 20px;
            text-align: center;
            width: 200px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .card button {
            margin-top: 10px;
            padding: 10px 20px;
            background-color: #007BFF;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .card button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>

<?php foreach ($items as $item): ?>
    <div class="card">
        <h3><?php echo htmlspecialchars($item["name"]); ?></h3>
        <button onclick="window.location.href='/materi/<?php echo $item['id']; ?>'">
            Go to <?php echo htmlspecialchars($item["name"]); ?>
        </button>
    </div>
<?php endforeach; ?>

</body>
</html>
