<?php
require_once "auth.php";
require_once "db.php";

$sql = "SELECT e.id AS employee_id, e.name AS employee_name, m.name AS manager_name
        FROM employees e
        LEFT JOIN employees m ON e.manager_id = m.id
        ORDER BY e.id ASC";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>5. Employees &amp; Managers</title>
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
        <h2>Employees and Their Managers (Self-Join)</h2>
        <table>
            <tr>
                <th>Employee ID</th>
                <th>Employee Name</th>
                <th>Manager Name</th>
            </tr>
            <?php if ($result && $result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= htmlspecialchars($row["employee_id"]) ?></td>
                        <td><?= htmlspecialchars($row["employee_name"]) ?></td>
                        <td><?= htmlspecialchars($row["manager_name"] ?? "No Manager (Top Level)") ?></td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr><td colspan="3">No employees found.</td></tr>
            <?php endif; ?>
        </table>
    </div>
</body>
</html>