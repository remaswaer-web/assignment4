<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>HomePage - MySQL Task</title>
    <style>
        body { margin: 0; font-family: Arial, sans-serif; }
        .hero {
            height: 420px;
            background: linear-gradient(rgba(15, 23, 42, 0.65), rgba(15, 23, 42, 0.65)),
                        url('https://images.unsplash.com/photo-1555066931-4365d14bab8c?auto=format&fit=crop&w=1400&q=80') center/cover no-repeat;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            text-align: center;
        }
        .hero h1 { font-size: 42px; margin: 0; }
    </style>
</head>
<body>
    <?php include "navbar.php"; ?>

    <header class="hero">
        <div>
            <h1>Welcome to MySQL</h1>
        </div>
    </header>
</body>
</html>