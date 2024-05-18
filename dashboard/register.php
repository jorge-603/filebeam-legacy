<?php

    require "../config/connection.php";

    $error = null;
    
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        if(empty($_POST["username"] || empty('password'))){
            $error = "Por favor rellene los campos";
        } else {
            $statement = $conn->prepare("SELECT * FROM users WHERE username = :username");
            $statement->bindParam(":username", $_POST["username"]);
            $statement->execute();

            if($statement->rowCount() > 0){
                $error = "Este usuario ha sido ocupado.";
            } else {
                $conn->prepare("INSERT INTO users (username, password) VALUES (:username, :password)")
                ->execute([
                    ":username" => $_POST["username"],
                    ":password" => password_hash($_POST["password"], PASSWORD_BCRYPT),
                ]);

                $statement = $conn->prepare("SELECT * FROM users WHERE username = :username");
                $statement->bindParam(":username", $_POST["username"]);
                $statement->execute();

                header("Location: login.php");
            }
        }

    }
    session_start();

    if(isset($_SESSION["user"])){
        header("Location: login.php");
        return;
    }
?>

<?php require "partials/header.php"; ?>

<body>
<div class="container pt-5">
  <div class="row justify-content-center">
    <div class="col-md-8">
      <div class="card">
        <div class="card-header">Register</div>
        <div class="card-body">
          <?php if ($error): ?>
            <p class="text-danger">
              <?= $error ?>
            </p>
          <?php endif ?>
          <form method="POST" action="register.php">

            <div class="mb-3 row">
              <label for="username" class="col-md-4 col-form-label text-md-end">Username</label>

              <div class="col-md-6">
                <input id="username" type="text" class="form-control" name="username" autocomplete="username" autofocus required>
              </div>
            </div>

            <div class="mb-3 row">
              <label for="password" class="col-md-4 col-form-label text-md-end">Password</label>

              <div class="col-md-6">
                <input id="password" type="password" class="form-control" name="password" autocomplete="password" autofocus required>
              </div>
            </div>

            <div class="mb-3 row">
              <div class="col-md-6 offset-md-4">
                <button type="submit" class="btn btn-primary">Register</button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

</body>
</html>