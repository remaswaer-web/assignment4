<?php
require_once "auth.php";
require_once "db.php";

$error = "";
$productNameInput = "";
$sales = [];

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $productNameInput = trim($_POST["product_name"] ?? "");

    if ($productNameInput === "") {
        $error = "من فضلك أدخل اسم المنتج.";
    } elseif (mb_strlen($productNameInput) > 100) {
        $error = "اسم المنتج طويل جداً.";
    } else {
        $pattern = "%" . $productNameInput . "%";
        $stmt = $conn->prepare("
            SELECT
                p.id AS product_id,
                p.name AS product_name,
                p.price,
                o.id AS order_id,
                o.order_date,
                c.first_name AS customer_name,
                oi.quantity,
                (p.price * oi.quantity) AS total_price
            FROM order_items oi
            JOIN products p ON oi.product_id = p.id
            JOIN orders o ON oi.order_id = o.id
            LEFT JOIN customers c ON o.customer_id = c.id
            WHERE p.name LIKE ?
            ORDER BY o.id DESC
        ");
        $stmt->bind_param("s", $pattern);
        $stmt->execute();
        $res = $stmt->get_result();
        while ($row = $res->fetch_assoc()) {
            $sales[] = $row;
        }
        if (count($sales) === 0) {
            $error = "لا توجد عمليات بيع مسجلة لهذا المنتج.";
        }
        $stmt->close();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>10. Product Sales Details</title>
    <style>
        body { margin: 0; font-family: Arial, sans-serif; background: #f8fafc; }
        .container { max-width: 950px; margin: 30px auto; background: #fff; padding: 20px; border-radius: 8px; }
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
        <h2>Sales Details for a Specific Product</h2>
        <form method="POST" action="">
            <input type="text" name="product_name" value="<?= htmlspecialchars($productNameInput) ?>" placeholder="Enter product name (e.g. Milk or Orange)" required>
            <button type="submit">Show Sales</button>
        </form>

        <?php if ($error !== ""): ?>
            <div class="err"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <?php if (count($sales) > 0): ?>
            <table>
                <tr>
                    <th>Order ID</th>
                    <th>Product</th>
                    <th>Unit Price</th>
                    <th>Quantity</th>
                    <th>Total Price</th>
                    <th>Customer</th>
                    <th>Order Date</th>
                </tr>
                <?php foreach ($sales as $row): ?>
                    <tr>
                        <td><?= htmlspecialchars($row["order_id"]) ?></td>
                        <td><?= htmlspecialchars($row["product_name"]) ?></td>
                        <td><?= htmlspecialchars($row["price"]) ?></td>
                        <td><?= htmlspecialchars($row["quantity"]) ?></td>
                        <td><?= htmlspecialchars(number_format((float)$row["total_price"], 2)) ?></td>
                        <td><?= htmlspecialchars($row["customer_name"] ?? "Unknown") ?></td>
                        <td><?= htmlspecialchars($row["order_date"]) ?></td>
                    </tr>
                <?php endforeach; ?>
            </table>
        <?php endif; ?>
    </div>
</body>
</html>