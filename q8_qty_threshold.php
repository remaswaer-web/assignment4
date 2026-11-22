<?php
require_once "auth.php";
require_once "db.php";

$error = "";
$minQtyInput = "";
$products = [];

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $minQtyInput = trim($_POST["min_qty"] ?? "");

    if ($minQtyInput === "" || !ctype_digit($minQtyInput)) {
        $error = "من فضلك أدخل رقماً صحيحاً موجباً (بدون حروف أو رموز).";
    } elseif (strlen($minQtyInput) > 9) {
        $error = "الرقم المدخل كبير جداً.";
    } else {
        $minQty = (int)$minQtyInput;
        $stmt = $conn->prepare("
            SELECT p.id, p.name, p.price, COALESCE(SUM(oi.quantity), 0) AS total_sold
            FROM products p
            LEFT JOIN order_items oi ON p.id = oi.product_id
            GROUP BY p.id, p.name, p.price
            HAVING total_sold > ?
            ORDER BY total_sold DESC
        ");
        $stmt->bind_param("i", $minQty);
        $stmt->execute();
        $res = $stmt->get_result();
        while ($row = $res->fetch_assoc()) {
            $products[] = $row;
        }
        if (count($products) === 0) {
            $error = "لا توجد منتجات مجموع مبيعاتها أكبر من " . $minQty . ".";
        }
        $stmt->close();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>8. Products with Total Quantity &gt; Number</title>
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
        <h2>Products Where Total Quantity Sold &gt; Input</h2>
        <form method="POST" action="">
            <input type="text" name="min_qty" value="<?= htmlspecialchars($minQtyInput) ?>" placeholder="Enter quantity (e.g. 500)" required>
            <button type="submit">Filter</button>
        </form>

        <?php if ($error !== ""): ?>
            <div class="err"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <?php if (count($products) > 0): ?>
            <table>
                <tr>
                    <th>Product ID</th>
                    <th>Product Name</th>
                    <th>Price</th>
                    <th>Total Quantity Sold</th>
                </tr>
                <?php foreach ($products as $row): ?>
                    <tr>
                        <td><?= htmlspecialchars($row["id"]) ?></td>
                        <td><?= htmlspecialchars($row["name"]) ?></td>
                        <td><?= htmlspecialchars($row["price"]) ?></td>
                        <td><?= htmlspecialchars($row["total_sold"]) ?></td>
                    </tr>
                <?php endforeach; ?>
            </table>
        <?php endif; ?>
    </div>
</body>
</html>