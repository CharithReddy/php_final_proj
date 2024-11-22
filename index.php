<?php
    require('dbinit.php');

    $query = 'SELECT * FROM cars;'; 
    $results = @mysqli_query($dbc,$query);
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

    <?php

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

        if (!empty($_POST)) {
            $action = $_POST['actioninfo'];

            // Define an errors array
            $errors = [];

            if ($action == "login") {
                $username = $_POST['login-username'];
                $password = $_POST['login-password'];

                $stmt = $dbc->prepare("SELECT password FROM customer WHERE username = ?");
                $stmt->bind_param("s", $username);
                $stmt->execute();

                // Fetch the result
                $result = $stmt->get_result();
                $row = $result->fetch_assoc();

                if ($row) {
                    if ($row['password'] == $password) {
                        unset($_SESSION['errors']);
                        unset($_SESSION['form_data']);
                        $_SESSION['logged_inuser'] = $username;

                        if ($username == "admin") {
                            header('Location: admin_inventory.php');
                        } else {
                            header('Location: customer_home.php');
                        }
                        
                    } else {
                        $errors['login_error'] = "Incorrect password. Please try again.";
                    }

                } else {
                    echo "No user found.";
                }
            } else {
                $username = $_POST['signup-username'];
                $password = $_POST['signup-password'];
                $fistname = $_POST['signup-firstname'];
                $lastname = $_POST['signup-lastname'];
                $phone = $_POST['signup-phone'];

                $query = "INSERT INTO `customer`(`first_name`, `last_name`, `username`, `password`, `phone_no`) 
                                 VALUES (?, ?, ?, ?, ?)";
                $stmt = mysqli_prepare($dbc, $query);

                mysqli_stmt_bind_param(
                    $stmt,
                    'ssssi',
                    $username,
                    $password,
                    $fistname,
                    $lastname,
                    $phone
                );
                // $result = mysqli_stmt_execute($stmt);
                $stmt->execute();
                $result = $stmt->get_result();
                if ($result) {
                    // echo $result;
                    $errors['register_error'] = "Registration failed. Please try again.";
                }
            }

            if (!empty($errors)) {
                $_SESSION['errors'] = $errors;
                $_SESSION['form_data'] = $_POST;
                header('Location: index.php');
            } else {
                unset($_SESSION['errors']);
                unset($_SESSION['form_data']);
            }
            
        }

        // Use the session data to prefill the form
        $form_data = $_SESSION['form_data'] ?? [];
        $errors = $_SESSION['errors'] ?? [];
    ?>

    <!-- <div class="container"> -->
        <div class="login-signup">
            <div class="login">
                <form class="needs-validation"
                        method="post" action="index.php" novalidate>
                    <div class="form-group">

                        <div class="mb-4 hidden">
                            <label for="actioninfo" class="form-label">Action: </label>
                            <input type="text" id="actioninfo" name="actioninfo"
                                class="form-control" value="login" readonly>
                        </div>

                        <div class="mb-4">
                            <label for="login-username" class="form-label">Username: </label>
                            <input type="text" id="login-username" name="login-username" 
                                class="form-control"
                                value="<?= isset($form_data['login-username']) ? $form_data['login-username'] : "" ?>">
                        </div>

                        <div class="mb-4">
                            <label for="login-password" class="form-label">Password: </label>
                            <input type="text" id="login-password" name="login-password" class="form-control"
                            value="<?= isset($form_data['login-password']) ? $form_data['login-password'] : "" ?>">
                        </div>

                        <div class="mb-4">
                            <button type="submit" class="btn btn-primary">Submit</button>
                            <button type="submit" class="btn btn-danger">Cancel</button>
                        </div>

                        <div class="mb-4">
                            <span class="errortext">
                                <?= isset($errors["login_error"]) ? $errors["login_error"] : "" ?>
                            </span>
                        </div>

                        <div class="mb-4">
                            <p>Not Registered? <a href="" id="gotoregister">Click Here</a> to Register</p>
                        </div>
                    </div>
                </form>
            </div>

            <div class="register hidden">
                <form class="needs-validation"
                        method="post" action="index.php" novalidate>
                    <div class="form-group">

                        <div class="mb-4 hidden">
                            <label for="actioninfo" class="form-label">Action: </label>
                            <input type="text" id="actioninfo" name="actioninfo"
                                class="form-control" value="register" readonly>
                        </div>

                        <div class="mb-4">
                            <label for="signup-username" class="form-label">Username: </label>
                            <input type="text" id="signup-username" name="signup-username" class="form-control"
                                value="<?= isset($form_data['signup-username']) ? $form_data['signup-username'] : "" ?>">
                        </div>

                        <div class="mb-4">
                            <label for="signup-password" class="form-label">Password: </label>
                            <input type="text" id="signup-password" name="signup-password" class="form-control"
                                value="<?= isset($form_data['signup-password']) ? $form_data['signup-password'] : "" ?>">
                        </div>

                        <div class="mb-4">
                            <label for="signup-firstname" class="form-label">First Name: </label>
                            <input type="text" id="signup-firstname" name="signup-firstname" class="form-control"
                            value="<?= isset($form_data['signup-firstname']) ? $form_data['signup-firstname'] : "" ?>">
                        </div>

                        <div class="mb-4">
                            <label for="signup-lastname" class="form-label">Last Name: </label>
                            <input type="text" id="signup-lastname" name="signup-lastname" class="form-control"
                                value="<?= isset($form_data['signup-lastname']) ? $form_data['signup-lastname'] : "" ?>">
                        </div>

                        <div class="mb-4">
                            <label for="signup-phone" class="form-label">Phone Number: </label>
                            <input type="text" id="signup-phone" name="signup-phone" class="form-control"
                                value="<?= isset($form_data['signup-phone']) ? $form_data['signup-phone'] : "" ?>">
                        </div>

                        <div class="mb-4">
                            <span class="errortext">
                                <?= isset($errors["register_error"]) ? $errors["register_error"] : "" ?>
                            </span>
                        </div>

                        <div class="mb-4">
                            <button type="submit" class="btn btn-primary">Submit</button>
                            <button type="submit" class="btn btn-danger">Cancel</button>
                        </div>

                        <div class="mb-4">
                            <p><a href="" id="gotologin">Click Here</a> to Login</p>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    <!-- </div> -->

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="loginregister.js"></script>
</body>
</html>

