<?php

require 'config.php';

if(!empty($_POST)){
    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE  email = :email";
    $stmt = $pdo->prepare($sql);

    $stmt->bindValue(':email',$email);
    $stmt->execute();

    $test = $stmt->fetch(PDO::FETCH_ASSOC);
    // print'<pre>';
    // print_r($test);

    if(empty($test)){
        echo "<script>alert('Incorrect credentials,Try again!')</script>";
    }else{
        $validPass = password_verify($password,$test['password']);
        if($validPass){
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['logged_in'] = time();

            header('Location:index.php');
            exit();
        }
    }
    
}


?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="card shadow-sm">
        <div class="card-body">
            <h1 class="card-title text-center mb-4">Login</h1>
            <form action="login.php" method="post">

                <!-- can check validate by required-->
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email">
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password">
                </div>
                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-primary btn-block">Login</button>
                </div>
            </form>
            <div class="text-center mt-3">
                <a href="register.php">You need to create account. Register here</a>
            </div>
        </div>
    </div>
</body>

</html>