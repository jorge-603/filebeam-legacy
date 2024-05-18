<?php

include "../config/connection.php";

$error = null;

if($_SERVER['REQUEST_METHOD'] === 'POST'){

    if(empty($_POST['username'] || empty($_POST['password']))){
        $error = "Por favor rellene todos los campos";
    } else {
        $statement = $conn->prepare("SELECT * FROM users WHERE username = :username LIMIT 1");
        $statement->bindParam(":username" , $_POST['username']);
        $statement->execute();

        if($statement->rowCount() == 0){
            $error = "El usuario no existe";
        } else {
            $user = $statement->fetch(PDO::FETCH_ASSOC);
    
            if(!password_verify($_POST['password'], $user["password"])) {
                $error = "Credenciales invalidas";
            } else {

                $statement = $conn->prepare("SELECT * FROM admins WHERE id_user = :id_user LIMIT 1");
                $statement->bindParam(":id_user", $user["id_user"]);
                $statement->execute();

                if($statement->rowCount() == 0){
                    $error = "No tienes permisos suficientes";
                } else {
                    session_start();
    
                    unset($user["password"]);
    
                    $_SESSION["user"] = $user;
    
                    header("Location: .");
                }
            }
        }
    }

}

session_start();

if(isset($_SESSION["user"])){
  $user = $_SESSION["user"];
  $statement = $conn->prepare("SELECT * FROM admins WHERE id_user = :id_user LIMIT 1");
  $statement->bindParam(":id_user", $user["id_user"]);
  $statement->execute();

  if($statement->rowCount() == 0){
      $error = "No tienes permisos suficientes";
  } else {
      session_start();

      unset($user["password"]);

      $_SESSION["user"] = $user;

      header("Location: .");
  }
}
?>

<?php require "partials/header.php"; ?>

<body>
<div class="container pt-5">
  <div class="row justify-content-center">
    <div class="col-md-8">
      <div class="card">
        <div class="card-header">Login</div>
        <div class="card-body">
          <?php if ($error): ?>
            <p class="text-danger">
                <?= $error ?>
            </p>
          <?php endif ?>
          <form method="POST" action="login.php">
            <div class="mb-3 row">
              <label for="username" class="col-md-4 col-form-label text-md-end">Nombre de usuario</label>

              <div class="col-md-6">
                <input id="username" type="text" class="form-control" name="username" autocomplete="username" autofocus rerquired>
              </div>
            </div>

            <div class="mb-3 row">
              <label for="password" class="col-md-4 col-form-label text-md-end">Contraseña</label>

              <div class="col-md-6">
                <input id="password" type="password" class="form-control" name="password" autocomplete="password" autofocus required>
              </div>
            </div>

            <div class="mb-3 row">
              <div class="col-md-6 offset-md-4">
                <button type="submit" class="btn btn-primary">Login</button>
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