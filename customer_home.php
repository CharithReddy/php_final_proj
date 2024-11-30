<?php
require('dbinit.php'); 


$query = "SELECT * FROM cars";
$results = mysqli_query($dbc, $query);

if (!$results) {
    die('Error fetching data: ' . mysqli_error($dbc));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container my-5">
        <h1 class="text-center mb-4">Our Cars</h1>
        <div class="row row-cols-1 row-cols-md-2 g-4">
            <?php while ($row = mysqli_fetch_assoc($results)): ?>
                <div class="col">
                    <div class="card h-100 shadow-sm">
                        <img src="tesla.jpg" class="card-img-top" alt="<?= htmlspecialchars($row['carName']) ?>">
                        <div class="card-body">
                            <h5 class="card-title"><?= htmlspecialchars($row['carName']) ?></h5>
                            <p class="card-text"><?= htmlspecialchars($row['carDescription']) ?></p>
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item">Price: $<?= number_format($row['price'], 2) ?></li>
                                <li class="list-group-item">Fuel Type: <?= htmlspecialchars($row['fuelType']) ?></li>
                                <li class="list-group-item">Drive Type: <?= htmlspecialchars($row['driveType']) ?></li>
                                <li class="list-group-item">Discount: $<?= number_format($row['discount'], 2) ?></li>
                            </ul>
                        </div>
                        <div class="card-footer text-center">
                            <button class="btn btn-primary">Add to Cart</button>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
