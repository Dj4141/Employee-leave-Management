<?php
session_start();
include('includes/config.php');

if (isset($_POST['signin'])) {
    // Retrieve user inputs and sanitize them
    $uname = htmlspecialchars(trim($_POST['username']));
    $password = htmlspecialchars(trim($_POST['password']));

    // Validate inputs
    if (empty($uname) || empty($password)) {
        echo "<script>alert('Username and password are required');</script>";
    } else {
        // Hash the password
        $hashed_password = md5($password);

        // Prepare and execute SQL query
        $sql = "SELECT UserName, Password FROM admin WHERE UserName = :uname AND Password = :password";
        $query = $dbh->prepare($sql);
        $query->bindParam(':uname', $uname, PDO::PARAM_STR);
        $query->bindParam(':password', $hashed_password, PDO::PARAM_STR);
        $query->execute();
        $results = $query->fetchAll(PDO::FETCH_OBJ);

        // Check if a matching record is found
        if ($query->rowCount() > 0) {
            $_SESSION['alogin'] = $uname;
            echo "<script type='text/javascript'> document.location = 'dashboard.php'; </script>";
            exit(); // Stop further execution
        } else {
            echo "<script>alert('Invalid username or password');</script>";
        }
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>

    <!-- Title  -->
    <title>Employee leave management system | Admin</title>

    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <meta charset="UTF-8">
    <meta name="description" content="Responsive Admin Dashboard Template" />
    <meta name="keywords" content="admin,dashboard" />
    <meta name="author" content="Steelcoders" />

    <!-- Styles  -->
    <link type="text/css" rel="stylesheet" href="../assets/plugins/materialize/css/materialize.min.css" />
    <link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="../assets/plugins/material-preloader/css/materialPreloader.min.css" rel="stylesheet">
    <link href="../assets/css/alpha.min.css" rel="stylesheet" type="text/css" />
    <link href="../assets/css/custom.css" rel="stylesheet" type="text/css" />
</head>

<body class="signin-page">

    <div class="mn-content valign-wrapper">

        <main class="mn-inner container">
            <h4 align="center"><a href="../index.php" style="color:#000;">Employee Leave Management System | Admin Login</a></h4>
            <div class="valign">
                <div class="row">

                    <div class="col s12 m6 l4 offset-l4 offset-m3">
                        <div class="card white darken-1">
                            <div class="card-content ">
                                <span class="card-title">Sign In</span>
                                <div class="row">
                                    <form class="col s12" name="signin" method="post">
                                        <div class="input-field col s12">
                                            <input id="username" type="text" name="username" class="validate" autocomplete="off" required>
                                            <label for="email">Username</label>
                                        </div>
                                        <div class="input-field col s12">
                                            <input id="password" type="password" class="validate" name="password" autocomplete="off" required>
                                            <label for="password">Password</label>
                                        </div>
                                        <div class="col s12 right-align m-t-sm">

                                            <input type="submit" name="signin" value="Sign in" class="waves-effect waves-light btn teal">
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <!-- Javascripts  -->
    <script src="../assets/plugins/jquery/jquery-2.2.0.min.js"></script>
    <script src="../assets/plugins/materialize/js/materialize.min.js"></script>
    <script src="../assets/plugins/material-preloader/js/materialPreloader.min.js"></script>
    <script src="../assets/plugins/jquery-blockui/jquery.blockui.js"></script>
    <script src="../assets/js/alpha.min.js"></script>

</body>

</html>