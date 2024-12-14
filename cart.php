<?php
session_start();

// Initialize cart if not already set
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Handle Add and Remove Quantity
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['add_quantity'])) {
        $car_id = $_POST['car_id'];
        foreach ($_SESSION['cart'] as &$item) {
            if ($item['id'] == $car_id) {
                $item['quantity']++;
                break;
            }
        }
    }

    if (isset($_POST['remove_quantity'])) {
        $car_id = $_POST['car_id'];
        foreach ($_SESSION['cart'] as $key => &$item) {
            if ($item['id'] == $car_id) {
                $item['quantity']--;
                if ($item['quantity'] <= 0) {
                    unset($_SESSION['cart'][$key]); // Remove item if quantity is 0
                }
                break;
            }
        }
    }

    // Redirect back to the cart to avoid form resubmission
    header('Location: cart.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cart</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <?php include 'navbar.php'; ?>

    <div class="container my-5">
        <h1 class="text-center mb-4">Your Cart</h1>
        <?php if (!empty($_SESSION['cart'])): ?>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Car</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Total</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($_SESSION['cart'] as $item): ?>
                    <tr>
                        <td><?= htmlspecialchars($item['name']) ?></td>
                        <td>$<?= number_format($item['price'], 2) ?></td>
                        <td>
                            <div class="d-flex align-items-center">
                                <form method="post" action="cart.php" class="d-inline">
                                    <input type="hidden" name="car_id" value="<?= htmlspecialchars($item['id']) ?>">
                                    <button type="submit" name="remove_quantity" class="btn btn-outline-danger btn-sm">-</button>
                                </form>
                                <span class="mx-3"><?= $item['quantity'] ?></span>
                                <form method="post" action="cart.php" class="d-inline">
                                    <input type="hidden" name="car_id" value="<?= htmlspecialchars($item['id']) ?>">
                                    <button type="submit" name="add_quantity" class="btn btn-outline-success btn-sm">+</button>
                                </form>
                            </div>
                        </td>
                        <td>$<?= number_format($item['price'] * $item['quantity'], 2) ?></td>
                        <td>
                            <form method="post" action="cart.php">
                                <input type="hidden" name="car_id" value="<?= htmlspecialchars($item['id']) ?>">
                                <button type="submit" name="remove_from_cart" class="btn btn-danger btn-sm">Remove</button>
                            </form>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p class="text-center">Your cart is empty.</p>
        <?php endif; ?>

        <div class="text-end">
            <a href="checkout.php" class="btn btn-success">Proceed to Checkout</a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
