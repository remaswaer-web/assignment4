<?php
require_once "auth.php";
require_once "db.php";

$sql = "SELECT * FROM customers WHERE salary > 20000 ORDER BY salary DESC";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>1. Salary &gt; 20,000</title>
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
        <h2>Customers with Salary &gt; 20,000</h2>
        <table>
            <tr>
                <th>ID</th>
                <th>First Name</th>
                <th>City</th>
                <th>Salary</th>
            </tr>
            <?php if ($result && $result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= htmlspecialchars($row["id"]) ?></td>
                        <td><?= htmlspecialchars($row["first_name"]) ?></td>
                        <td><?= htmlspecialchars($row["city"]) ?></td>
                        <td><?= htmlspecialchars($row["salary"]) ?></td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr><td colspan="4">No customers found with salary &gt; 20,000.</td></tr>
            <?php endif; ?>
        </table>
    </div>
</body>
</html>