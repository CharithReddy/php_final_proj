<?php
session_start();
require('dbinit.php');

// Ensure cart session is initialized
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

$message = ''; // To store success or error messages

// Handle Add to Cart functionality
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_to_cart'])) {
    $car_id = $_POST['car_id'];
    $car_name = $_POST['car_name'];
    $price = $_POST['price'];

    // Check if the item is already in the cart
    $found = false;
    foreach ($_SESSION['cart'] as &$item) {
        if ($item['id'] == $car_id) {
            $item['quantity']++;
            $found = true;
            $message = "$car_name has been added to your cart again!";
            break;
        }
    }

    // If not found, add as a new item
    if (!$found) {
        $_SESSION['cart'][] = [
            'id' => $car_id,
            'name' => $car_name,
            'price' => $price,
            'quantity' => 1,
        ];
        $message = "$car_name has been added to your cart!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Home</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <?php include 'navbar.php'; ?>

    <div class="container my-5">
        <h1 class="text-center mb-4">Our Cars</h1>

        <!-- Display Success Message -->
        <?php if (!empty($message)): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?= htmlspecialchars($message) ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <!-- Products Listing -->
        <div class="row row-cols-1 row-cols-md-2 g-4">
            <?php
            $query = "SELECT * FROM cars";
            $results = mysqli_query($dbc, $query);

            while ($row = mysqli_fetch_assoc($results)): ?>
                <div class="col">
                    <div class="card h-100 shadow-sm">
                        <img src="tesla.png" class="card-img-top" alt="<?= htmlspecialchars($row['carName']) ?>">
                        <div class="card-body">
                            <h5 class="card-title"><?= htmlspecialchars($row['carName']) ?></h5>
                            <p class="card-text"><?= htmlspecialchars($row['carDescription']) ?></p>
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item">Price: $<?= number_format($row['price'], 2) ?></li>
                                <li class="list-group-item">Fuel Type: <?= htmlspecialchars($row['fuelType']) ?></li>
                                <li class="list-group-item">Drive Type: <?= htmlspecialchars($row['driveType']) ?></li>
                            </ul>
                        </div>
                        <div class="card-footer text-center">
                            <form method="post" action="customer_home.php">
                                <input type="hidden" name="car_id" value="<?= htmlspecialchars($row['carID']) ?>">
                                <input type="hidden" name="car_name" value="<?= htmlspecialchars($row['carName']) ?>">
                                <input type="hidden" name="price" value="<?= htmlspecialchars($row['price']) ?>">
                                <button type="submit" name="add_to_cart" class="btn btn-primary">Add to Cart</button>
                            </form>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
