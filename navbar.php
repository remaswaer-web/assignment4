<?php
$currentPage = basename($_SERVER["PHP_SELF"]);
?>
<nav style="display: flex; justify-content: space-between; align-items: center; padding: 12px 24px; background: #1e293b; color: #fff; font-family: Arial, sans-serif;">
    <div style="font-size: 20px; font-weight: bold;">
        <a href="index.php" style="color: #fff; text-decoration: none;">MySQL Hub</a>
    </div>

    <div style="display: flex; flex-wrap: wrap; gap: 14px; font-size: 14px;">
        <a href="index.php" style="color: #e2e8f0; text-decoration: none;">Home</a>
        <a href="q1_high_salary.php" style="color: #e2e8f0; text-decoration: none;">1. Salary &gt; 20k</a>
        <a href="q2_customer_by_id.php" style="color: #e2e8f0; text-decoration: none;">2. Customer ID</a>
        <a href="q3_orders_count.php" style="color: #e2e8f0; text-decoration: none;">3. Orders Count</a>
        <a href="q4_top_products.php" style="color: #e2e8f0; text-decoration: none;">4. Top Products</a>
        <a href="q5_employees_managers.php" style="color: #e2e8f0; text-decoration: none;">5. Self Join</a>
        <a href="q6_search_name.php" style="color: #e2e8f0; text-decoration: none;">6. Search Name</a>
        <a href="q7_city_customers.php" style="color: #e2e8f0; text-decoration: none;">7. By City</a>
        <a href="q8_qty_threshold.php" style="color: #e2e8f0; text-decoration: none;">8. Qty &gt; N</a>
        <a href="q9_top3_city.php" style="color: #e2e8f0; text-decoration: none;">9. Top 3 City</a>
        <a href="q10_product_sales.php" style="color: #e2e8f0; text-decoration: none;">10. Product Sales</a>
        <?php if (isset($_SESSION["customer_id"])): ?>
            <a href="logout.php" style="color: #fca5a5; text-decoration: none;">Logout</a>
        <?php else: ?>
            <a href="login.php" style="color: #86efac; text-decoration: none;">Login</a>
        <?php endif; ?>
    </div>
</nav>