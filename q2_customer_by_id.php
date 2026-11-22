<?php
require_once "auth.php";
require_once "db.php";

$error = "";
$customer = null;
$idInput = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $idInput = trim($_POST["id"] ?? "");

    if ($idInput === "" || !ctype_digit($idInput)) {
        $error = "من فضلك أدخل رقم ID صحيح (أرقام صحيحة موجبة فقط).";
    } elseif (strlen($idInput) > 10) {
        $error = "رقم الـ ID طويل جداً.";
    } else {
        $id = (int)$idInput;
        $stmt = $conn->prepare("SELECT * FROM customers WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $res = $stmt->get_result();
        $customer = $res->fetch_assoc();
        if (!$customer) {
            $error = "لا يوجد عميل بهذا الـ ID.";
        }
        $stmt->close();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>2. Customer by ID</title>
    <style>
        body { margin: 0; font-family: Arial, sans-serif; background: #f8fafc; }
        .container { max-width: 850px; margin: 30px auto; background: #fff; padding: 20px; border-radius: 8px; }
        input { padding: 8px; width: 220px; }
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
        <h2>Find Customer by ID</h2>
        <form method="POST" action="">
            <input type="text" name="id" value="<?= htmlspecialchars($idInput) ?>" placeholder="Enter Customer ID" required>
            <button type="submit">Search</button>
        </form>

        <?php if ($error !== ""): ?>
            <div class="err"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <?php if ($customer): ?>
            <table>
                <tr>
                    <?php foreach ($customer as $col => $val): ?>
                        <?php if ($col !== "password"): ?>
                            <th><?= htmlspecialchars($col) ?></th>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </tr>
                <tr>
                    <?php foreach ($customer as $col => $val): ?>
                        <?php if ($col !== "password"): ?>
                            <td><?= htmlspecialchars((string)$val) ?></td>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </tr>
            </table>
        <?php endif; ?>
    </div>
</body>
</html>