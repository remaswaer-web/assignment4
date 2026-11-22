<?php
require_once "auth.php";
require_once "db.php";

$sql = "SELECT c.id, c.first_name, COUNT(o.id) AS orders_count
        FROM customers c
        LEFT JOIN orders o ON c.id = o.customer_id
        GROUP BY c.id, c.first_name
        ORDER BY orders_count DESC, c.first_name ASC";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>3. Orders Count per Customer</title>
    <style>
        body { margin: 0; font-family: Arial, sans-serif; background: #f8fafc; }
        .container { max-width: 850px; margin: 30px auto; background: #fff; padding: 20px; border-radius: 8px; }
        ul { list-style: none; padding: 0; }
        li { padding: 10px; border-bottom: 1px solid #e2e8f0; font-size: 16px; }
    </style>
</head>
<body>
    <?php include "navbar.php"; ?>
    <div class="container">
        <h2>Orders Count per Customer</h2>
        <ul>
            <?php if ($result && $result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <li><?= htmlspecialchars($row["first_name"]) ?> <?= htmlspecialchars($row["orders_count"]) ?></li>
                <?php endwhile; ?>
            <?php else: ?>
                <li>No data found.</li>
            <?php endif; ?>
        </ul>
    </div>
</body>
</html>