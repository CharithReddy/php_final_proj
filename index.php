<?php
require('dbinit.php');
session_start();

// Function to validate name, username
function validate_name($value) {
    $value = trim($value);

    if (preg_match('/[a-zA-Z]{5,15}/', $value)) {
        return true;
    } else {
        return false;
    }
}

// Handle login or registration form submission
if (!empty($_POST)) {
    $action = $_POST['actioninfo'];

    // Define an errors array
    $errors = [];

    if ($action == "login") {
        $username = $_POST['login-username'];
        $password = $_POST['login-password'];

        // Fetch the user from the database
        $stmt = $dbc->prepare("SELECT * FROM customer WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();

        // Fetch the result
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        if ($row) {
            // Check if the provided password matches the one in the database
            if ($row['password'] == $password) {
                // Successful login
                unset($_SESSION['errors']);
                unset($_SESSION['form_data']);
                $_SESSION['logged_inuser'] = $username;

                // Redirect based on user type
                if ($username == "admin") {
                    header('Location: admin_inventory.php');
                } else {
                    header('Location: customer_home.php');
                }
                exit;
            } else {
                $errors['login_error'] = "Incorrect password. Please try again.";
            }
        } else {
            $errors['login_error'] = "No user found with that username.";
        }
    } elseif ($action == "register") {
        // Handle user registration
        $username = $_POST['signup-username'];
        $password = $_POST['signup-password'];
        $firstname = $_POST['signup-firstname'];
        $lastname = $_POST['signup-lastname'];
        $phone = $_POST['signup-phone'];

        // Insert the new user into the database
        $query = "INSERT INTO customer (first_name, last_name, username, password, phone_no) 
                  VALUES (?, ?, ?, ?, ?)";
        $stmt = $dbc->prepare($query);
        $stmt->bind_param("ssssi", $firstname, $lastname, $username, $password, $phone);

        if ($stmt->execute()) {
            // Registration successful
            unset($_SESSION['errors']);
            unset($_SESSION['form_data']);
            $_SESSION['logged_inuser'] = $username;
            header('Location: customer_home.php');
            exit;
        } else {
            $errors['register_error'] = "Registration failed. Please try again.";
        }
    }

    // If there are errors, store them in the session
    if (!empty($errors)) {
        $_SESSION['errors'] = $errors;
        $_SESSION['form_data'] = $_POST;
        header('Location: index.php');
        exit;
    }
}

// Prefill form data if available
$form_data = $_SESSION['form_data'] ?? [];
$errors = $_SESSION['errors'] ?? [];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login/Register</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" 
        rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" 
        crossorigin="anonymous">

    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-6">
                <h2>Login</h2>
                <form method="post" action="index.php" novalidate>
                    <input type="hidden" name="actioninfo" value="login">
                    
                    <div class="mb-3">
                        <label for="login-username" class="form-label">Username</label>
                        <input type="text" id="login-username" name="login-username" class="form-control"
                            value="<?= isset($form_data['login-username']) ? $form_data['login-username'] : "" ?>" required>
                    </div>

                    <div class="mb-3">
                        <label for="login-password" class="form-label">Password</label>
                        <input type="password" id="login-password" name="login-password" class="form-control"
                            value="<?= isset($form_data['login-password']) ? $form_data['login-password'] : "" ?>" required>
                    </div>

                    <button type="submit" class="btn btn-primary">Login</button>
                    <div class="mt-2 text-danger">
                        <?= isset($errors['login_error']) ? $errors['login_error'] : "" ?>
                    </div>
                </form>
            </div>

            <div class="col-md-6">
                <h2>Register</h2>
                <form method="post" action="index.php" novalidate>
                    <input type="hidden" name="actioninfo" value="register">
                    
                    <div class="mb-3">
                        <label for="signup-username" class="form-label">Username</label>
                        <input type="text" id="signup-username" name="signup-username" class="form-control"
                            value="<?= isset($form_data['signup-username']) ? $form_data['signup-username'] : "" ?>" required>
                    </div>

                    <div class="mb-3">
                        <label for="signup-password" class="form-label">Password</label>
                        <input type="password" id="signup-password" name="signup-password" class="form-control"
                            value="<?= isset($form_data['signup-password']) ? $form_data['signup-password'] : "" ?>" required>
                    </div>

                    <div class="mb-3">
                        <label for="signup-firstname" class="form-label">First Name</label>
                        <input type="text" id="signup-firstname" name="signup-firstname" class="form-control"
                            value="<?= isset($form_data['signup-firstname']) ? $form_data['signup-firstname'] : "" ?>" required>
                    </div>

                    <div class="mb-3">
                        <label for="signup-lastname" class="form-label">Last Name</label>
                        <input type="text" id="signup-lastname" name="signup-lastname" class="form-control"
                            value="<?= isset($form_data['signup-lastname']) ? $form_data['signup-lastname'] : "" ?>" required>
                    </div>

                    <div class="mb-3">
                        <label for="signup-phone" class="form-label">Phone Number</label>
                        <input type="text" id="signup-phone" name="signup-phone" class="form-control"
                            value="<?= isset($form_data['signup-phone']) ? $form_data['signup-phone'] : "" ?>" required>
                    </div>

                    <button type="submit" class="btn btn-primary">Register</button>
                    <div class="mt-2 text-danger">
                        <?= isset($errors['register_error']) ? $errors['register_error'] : "" ?>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
