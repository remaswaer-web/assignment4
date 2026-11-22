<?php
require_once "auth.php";
require_once "db.php";

$error = "";
$nameInput = "";
$rows = [];

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nameInput = trim($_POST["first_name"] ?? "");

    if ($nameInput === "") {
        $error = "من فضلك أدخل اسم أو جزء من اسم للبحث.";
    } elseif (mb_strlen($nameInput) > 50) {
        $error = "نص البحث طويل جداً (الحد الأقصى 50 حرفاً).";
    } else {
        $likePattern = "%" . $nameInput . "%";
        $stmt = $conn->prepare("SELECT id, first_name, city, salary FROM customers WHERE first_name LIKE ? ORDER BY first_name ASC");
        $stmt->bind_param("s", $likePattern);
        $stmt->execute();
        $res = $stmt->get_result();
        while ($r = $res->fetch_assoc()) {
            $rows[] = $r;
        }
        if (count($rows) === 0) {
            $error = "لم يتم العثور على عملاء مطابقين للبحث.";
        }
        $stmt->close();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>6. Search Customer by Name</title>
    <style>
        body { margin: 0; font-family: Arial, sans-serif; background: #f8fafc; }
        .container { max-width: 850px; margin: 30px auto; background: #fff; padding: 20px; border-radius: 8px; }
        input { padding: 8px; width: 240px; }
        button { padding: 8px 16px; background: #1e293b; color: #fff; border: none; cursor: pointer; }
        .err { color: #dc2626; margin-top: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        th, td { border: 1px solid #cbd5e1; padding: 10px; text-align: left; }
        th { background: #1e293b; color: #fff; }
    </style>
</head>
<body>
    <?php include "navbar.php"; ?>
    <div class="container">
        <h2>Search Customers by First Name</h2>
        <form method="POST" action="">
            <input type="text" name="first_name" value="<?= htmlspecialchars($nameInput) ?>" placeholder="Enter name (e.g. Le or Ahmed)" required>
            <button type="submit">Search</button>
        </form>

        <?php if ($error !== ""): ?>
            <div class="err"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <?php if (count($rows) > 0): ?>
            <table>
                <tr>
                    <th>ID</th>
                    <th>First Name</th>
                    <th>City</th>
                    <th>Salary</th>
                </tr>
                <?php foreach ($rows as $row): ?>
                    <tr>
                        <td><?= htmlspecialchars($row["id"]) ?></td>
                        <td><?= htmlspecialchars($row["first_name"]) ?></td>
                        <td><?= htmlspecialchars($row["city"]) ?></td>
                        <td><?= htmlspecialchars($row["salary"]) ?></td>
                    </tr>
                <?php endforeach; ?>
            </table>
        <?php endif; ?>
    </div>
</body>
</html>