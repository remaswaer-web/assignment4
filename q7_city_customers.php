<?php
require_once "auth.php";
require_once "db.php";

$cities = [];
$cityRes = $conn->query("SELECT DISTINCT city FROM customers WHERE city IS NOT NULL AND city <> '' ORDER BY city ASC");
if ($cityRes) {
    while ($cRow = $cityRes->fetch_assoc()) {
        $cities[] = $cRow["city"];
    }
}

$error = "";
$selectedCity = "";
$customers = [];

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $selectedCity = trim($_POST["city"] ?? "");

    if ($selectedCity === "") {
        $error = "من فضلك اختر مدينة من القائمة.";
    } elseif (!in_array($selectedCity, $cities, true)) {
        $error = "المدينة المختارة غير صالحة.";
    } else {
        $stmt = $conn->prepare("SELECT id, first_name, city, salary FROM customers WHERE city = ? ORDER BY first_name ASC");
        $stmt->bind_param("s", $selectedCity);
        $stmt->execute();
        $res = $stmt->get_result();
        while ($row = $res->fetch_assoc()) {
            $customers[] = $row;
        }
        if (count($customers) === 0) {
            $error = "لا يوجد عملاء مسجلون في هذه المدينة.";
        }
        $stmt->close();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>7. Customers by City</title>
    <style>
        body { margin: 0; font-family: Arial, sans-serif; background: #f8fafc; }
        .container { max-width: 850px; margin: 30px auto; background: #fff; padding: 20px; border-radius: 8px; }
        select { padding: 8px 12px; min-width: 220px; }
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
        <h2>Customers by City</h2>
        <form method="POST" action="">
            <select name="city" required>
                <option value="">-- Select City --</option>
                <?php foreach ($cities as $city): ?>
                    <option value="<?= htmlspecialchars($city) ?>" <?= ($selectedCity === $city) ? "selected" : "" ?>>
                        <?= htmlspecialchars($city) ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <button type="submit">Show Customers</button>
        </form>

        <?php if ($error !== ""): ?>
            <div class="err"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <?php if (count($customers) > 0): ?>
            <table>
                <tr>
                    <th>ID</th>
                    <th>First Name</th>
                    <th>City</th>
                    <th>Salary</th>
                </tr>
                <?php foreach ($customers as $row): ?>
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