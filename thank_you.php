<?php
session_start();

// Retrieve the last order
$order = $_SESSION['order'] ?? null;

// If no order exists, redirect to cart
if (!$order) {
    header('Location: customer_home.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thank You</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <?php include 'navbar.php'; ?>

    <div class="container my-5">
        <h1 class="text-center mb-4">Thank You for Your Order!</h1>
        <div class="alert alert-success">
            <p><strong>Order Details:</strong></p>
            <ul>
                <li><strong>Name:</strong> <?= htmlspecialchars($order['name']) ?></li>
                <li><strong>Address:</strong> <?= htmlspecialchars($order['address']) ?></li>
                <li><strong>Phone:</strong> <?= htmlspecialchars($order['phone']) ?></li>
                <li><strong>Car:</strong> <?= htmlspecialchars($order['car_name']) ?></li>
                <li><strong>Quantity:</strong> <?= htmlspecialchars($order['quantity']) ?></li>
                <li><strong>Total Price Paid:</strong> $<?= number_format($order['price_paid'], 2) ?></li>
            </ul>
        </div>
        <a href="customer_home.php" class="btn btn-primary">Go Back to Home</a>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
