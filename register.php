<?php

require 'config.php';

// var_dump($_POST);

if(!empty($_POST)){
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    if($username == "" || $email == "" || $password == ""){
        echo "<script>alert('Please Fill The ALL Fields.')</script>";
        // exit();
    }else{
        $sql = "SELECT COUNT(email) As num FROM users WHERE email = :email";
        $stmt = $pdo->prepare($sql);

        $stmt -> bindValue(':email', $email);

        $stmt -> execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if($user['num'] > 0){
            echo "<script>alert('This user email is already exit.')</script>";
        }else{
            $passwordHash = password_hash($password,PASSWORD_BCRYPT);
            
            $sql = "INSERT INTO users(name,email,password) VALUES(:username,:email,:password)";
            
            $stmt = $pdo->prepare($sql);

            $stmt -> bindValue(':username',$username);
            $stmt -> bindValue(':email',$email);
            $stmt -> bindValue(':password',$passwordHash);

            $result = $stmt->execute();

            if($result){
                echo "Thank for your registeation" . "<a href='login.php'>Login</a>";
            }
        }
    }
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
</head>

<body>

    <div class="container mt-5">
        <div class="card shadow-sm">
            <div class="card-body">
                <h1 class="card-title text-center mb-4">Register</h1>
                <form action="register.php" method="post">
                    <div class="mb-3">
                        <label for="username" class="form-label">Name</label>
                        <input type="text" class="form-control" id="username" name="username">
                    </div>
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
                        <button type="submit" class="btn btn-primary btn-block">Register</button>
                    </div>
                </form>
                <div class="text-center mt-3">
                    <a href="login.php">Already have an account? Login here</a>
                </div>
            </div>
        </div>
    </div>


</body>

</html>