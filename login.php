<?php
session_start();

error_reporting(E_ALL);
ini_set('display_errors', 1);


// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Construct the connection string
    $dbhost = 'localhost'; // Assuming the database is running on localhost
    $dbport = '1521'; // Default port for Oracle Database
    $dbname = 'XE'; // Name of the Oracle database
    $connString = "(DESCRIPTION=(ADDRESS=(PROTOCOL=TCP)(HOST=$dbhost)(PORT=$dbport))(CONNECT_DATA=(SERVER=DEDICATED)(SERVICE_NAME=$dbname)))";

    // Database connection
    $conn = oci_connect('SYSTEM', '2024DIZON', $connString);
    if (!$conn) {
        $error_message = "Database connection failed.";
    } else {
        // Prepare SQL statement to fetch user details from users table
        $sql_users = "SELECT * FROM SE.users WHERE username = :username AND password = :password";
        $stmt_users = oci_parse($conn, $sql_users);
        oci_bind_by_name($stmt_users, ':username', $username);
        oci_bind_by_name($stmt_users, ':password', $password);
        
        // Execute the SQL statement for users
        if (oci_execute($stmt_users) && oci_fetch_assoc($stmt_users)) {
            $_SESSION['user_type'] = 'USERS';
            header("Location: pages/home.php");
            exit;
        }

        // Prepare SQL statement to fetch user details from moderators table
        $sql_moderators = "SELECT * FROM SE.moderators WHERE username = :username AND password = :password";
        $stmt_moderators = oci_parse($conn, $sql_moderators);
        oci_bind_by_name($stmt_moderators, ':username', $username);
        oci_bind_by_name($stmt_moderators, ':password', $password);
        
        // Execute the SQL statement for moderators
        if (oci_execute($stmt_moderators) && oci_fetch_assoc($stmt_moderators)) {
            $_SESSION['user_type'] = 'MODERATORS';
            header("Location: pages/moderator.php");
            exit;
        }

        // Prepare SQL statement to fetch user details from admin table
        $sql_admin = "SELECT * FROM SE.admin WHERE username = :username AND password = :password";
        $stmt_admin = oci_parse($conn, $sql_admin);
        oci_bind_by_name($stmt_admin, ':username', $username);
        oci_bind_by_name($stmt_admin, ':password', $password);
        
        // Execute the SQL statement for admin
        if (oci_execute($stmt_admin) && oci_fetch_assoc($stmt_admin)) {
            $_SESSION['user_type'] = 'ADMIN';
            header("Location: pages/admin.php"); // Redirect to admin.php
            exit;
        }

        // If no match found
        $error_message = "Invalid username or password.";
        
        // Free statements and close connection
        oci_free_statement($stmt_users);
        oci_free_statement($stmt_moderators);
        oci_free_statement($stmt_admin);
        oci_close($conn);
    }
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Form</title>
    <link rel="icon" type="image/x-icon" href="images/qculogo.png">
    <link rel="stylesheet" href="style/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <div class="container mt-5 d-flex flex-column align-items-center justify-content-center ">
        <header class="login text-center mb-3 w-100" style="max-width: 400px;">
            <div class="header-content d-flex justify-content-center align-items-center">
                <img src="images/qculogo.png" alt="QC University Logo" class="rounded-circle">
                <h2>Kiyusiyu Connect</h2>
            </div>
        </header>

        <div class="w-100" style="max-width: 400px;">
            <div class="p-4 login">    
                <div class="text-center mb-2">
                    <h2><b>Student Log In</b></h2>
                </div>

                <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                    <!-- Username input -->
                    <div class="mb-3">
                        <label for="username" class="form-label"><b>Username</b></label>
                        <input type="text" class="form-control" id="username" name="username" required autocomplete="username">
                    </div>
    
                    <!-- Password input -->
                    <div class="mb-3">
                        <label for="password" class="form-label"><b>Password</b></label>
                        <div class="input-group">
                            <input type="password" class="form-control" id="password" name="password" required autocomplete="current-password">
                            <button class="btn btn-outline-secondary" type="button" id="togglePassword"><i class="fa fa-eye" aria-hidden="true"></i></button>
                        </div>
                    </div>
    
                    <!-- Forgot password link -->
                    <div class="mb-2 text-end">
                        <a href="#" class="text-decoration-none">Forgot password?</a>
                    </div>

                    <!-- Remember Me Checkbox -->
                    <div class="mb-3 d-flex justify-content-center align-items-center">
                        <input type="checkbox" id="rememberMe" class="me-2">
                        <label for="rememberMe" class="form-check-label"><b>Remember Me</b></label>
                    </div>
    
                    <!-- Submit button -->
                    <div class="d-flex justify-content-center">
                        <button type="submit" class="btn btn-primary px-5 py-2">Log In</button>
                    </div>
    
                    <p class="mt-2 text-center">
                        By logging in, you agree to our 
                        <a href="#" class="text-decoration-none"><b>Terms of Use</b></a> and that you have read our 
                        <a href="#" class="text-decoration-none"><b>Privacy Policy</b></a>.
                    </p>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('togglePassword').addEventListener('click', function (e) {
            const password = document.getElementById('password');
            const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
            password.setAttribute('type', type);
            this.innerHTML = type === 'password' ? '<i class="fa fa-eye" aria-hidden="true"></i>' : '<i class="fa fa-eye-slash" aria-hidden="true"></i>';
        });
    </script>
</body>
</html>
