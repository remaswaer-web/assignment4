<?php
session_start();
require_once "db.php";

$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = trim($_POST["first_name"] ?? "");
    $password = trim($_POST["password"] ?? "");

    if ($name === "" || $password === "") {
        $error = "من فضلك أدخل الاسم وكلمة المرور.";
    } elseif (mb_strlen($name) > 100 || mb_strlen($password) > 100) {
        $error = "عدد الحروف المدخلة كبير جداً.";
    } else {
        $stmt = $conn->prepare("SELECT id, first_name, password FROM customers WHERE first_name = ? LIMIT 1");
        $stmt->bind_param("s", $name);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();

        if ($user && $user["password"] === $password) {
            $_SESSION["customer_id"] = $user["id"];
            $_SESSION["customer_name"] = $user["first_name"];
            header("Location: q1_high_salary.php");
            exit;
        } else {
            $error = "الاسم أو كلمة المرور غير صحيحة.";
        }
        $stmt->close();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login - MySQL Task</title>
    <style>
        body { margin: 0; font-family: Arial, sans-serif; background: #f8fafc; }
        .box { max-width: 380px; margin: 50px auto; background: #fff; padding: 24px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.08); }
        input { width: 100%; padding: 10px; margin: 8px 0 16px; box-sizing: border-box; }
        button { width: 100%; padding: 10px; background: #1e293b; color: #fff; border: none; cursor: pointer; }
        .err { color: #dc2626; margin-bottom: 12px; }
    </style>
</head>
<body>
    <?php include "navbar.php"; ?>

    <div class="box">
        <h2>Login</h2>
        <?php if ($error !== ""): ?>
            <div class="err"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <form method="POST" action="">
            <label>First Name:</label>
            <input type="text" name="first_name" required>

            <label>Password:</label>
            <input type="password" name="password" required>

            <button type="submit">Login</button>
        </form>
    </div>
</body>
</html>