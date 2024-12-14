<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">CarShop</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="customer_home.php">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="cart.php">Cart</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="checkout.php">Checkout</a>
                </li>
            </ul>
            <!-- Logout button aligned to the right -->
            <form class="d-flex ms-auto" method="POST" action="index.php">
                <button class="btn btn-outline-danger" type="submit">Logout</button>
            </form>
        </div>
    </div>
</nav>
