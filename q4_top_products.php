<?php
require_once "auth.php";
require_once "db.php";

$sql = "SELECT p.id, p.name, p.price, COALESCE(SUM(oi.quantity), 0) AS total_quantity
        FROM products p
        LEFT JOIN order_items oi ON p.id = oi.product_id
        GROUP BY p.id, p.name, p.price
        ORDER BY total_quantity DESC
        LIMIT 5";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>4. Top 5 Products</title>
    <style>
        body { margin: 0; font-family: Arial, sans-serif; background: #f8fafc; }
        .container { max-width: 850px; margin: 30px auto; background: #fff; padding: 20px; border-radius: 8px; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        th, td { border: 1px solid #cbd5e1; padding: 10px; text-align: left; }
        th { background: #1e293b; color: #fff; }
    </style>
</head>
<body>
    <?php include "navbar.php"; ?>
    <div class="container">
        <h2>Top 5 Products by Quantity Sold</h2>
        <table>
            <tr>
                <th>Product ID</th>
                <th>Product Name</th>
                <th>Price</th>
                <th>Total Quantity Sold</th>
            </tr>
            <?php if ($result && $result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= htmlspecialchars($row["id"]) ?></td>
                        <td><?= htmlspecialchars($row["name"]) ?></td>
                        <td><?= htmlspecialchars($row["price"]) ?></td>
                        <td><?= htmlspecialchars($row["total_quantity"]) ?></td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr><td colspan="4">No products found.</td></tr>
            <?php endif; ?>
        </table>
    </div>
</body>
</html>