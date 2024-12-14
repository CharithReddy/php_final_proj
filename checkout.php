<?php
session_start();

// Ensure cart exists
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Restrict checkout if there is not exactly one item in the cart
if (count($_SESSION['cart']) !== 1) {
    header('Location: cart.php');
    exit;
}

// Handle checkout form submission
$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['checkout'])) {
    $name = trim($_POST['name'] ?? '');
    $address = trim($_POST['address'] ?? '');
    $phone = trim($_POST['phone'] ?? '');

    // Validate form inputs
    if (empty($name)) {
        $errors[] = 'Name is required.';
    }

    if (empty($address)) {
        $errors[] = 'Address is required.';
    }

    if (empty($phone) || !preg_match('/^\d{10}$/', $phone)) {
        $errors[] = 'Valid phone number is required.';
    }

    // If no errors, process the checkout
    if (empty($errors)) {
        // Retrieve the single cart item
        $item = reset($_SESSION['cart']); // Gets the first (and only) item in the cart
        $car_name = $item['name'];
        $quantity = $item['quantity'];
        $price_paid = $item['price'] * $quantity;

        // Simulate order processing
        // In a real application, save this data to the database
        $_SESSION['order'] = [
            'name' => $name,
            'address' => $address,
            'phone' => $phone,
            'car_name' => $car_name,
            'quantity' => $quantity,
            'price_paid' => $price_paid,
        ];

        // Clear the cart after successful checkout
        $_SESSION['cart'] = [];

        // Redirect to a Thank You page
        header('Location: thank_you.php');
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <?php include 'navbar.php'; ?>

    <div class="container my-5">
        <h1 class="text-center mb-4">Checkout</h1>

        <?php if (!empty($errors)): ?>
            <div class="alert alert-danger">
                <ul>
                    <?php foreach ($errors as $error): ?>
                        <li><?= htmlspecialchars($error) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <form method="post" action="checkout.php">
            <div class="mb-3">
                <label for="name" class="form-label">Full Name</label>
                <input type="text" name="name" id="name" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="address" class="form-label">Address</label>
                <textarea name="address" id="address" class="form-control" rows="3" required></textarea>
            </div>
            <div class="mb-3">
                <label for="phone" class="form-label">Phone Number</label>
                <input type="text" name="phone" id="phone" class="form-control" required pattern="\d{10}">
            </div>
            <button type="submit" name="checkout" class="btn btn-success">Confirm Order</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
