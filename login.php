<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <?php require "depurar.php" ?>
    <?php require "conecta_bbdd.php" ?>
</head>

<body>
    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST["usuario"])) {
            $temp_usuario = depurar($_POST["usuario"]);
        } else {
            $temp_usuario = "";
        }
        if (isset($_POST["contrasena"])) {
            $temp_contrasena = depurar($_POST["contrasena"]);
        } else {
            $temp_contrasena = "";
        }

        $sql = "SELECT * FROM usuarios WHERE usuario = '$temp_usuario'";
        $resultado = $conexion->query($sql);

        while ($fila = $resultado->fetch_assoc()) {
            $contrasenaCifrada = $fila['$contrasena'];
        }
        if ($resultado->num_rows == 0) {
    ?>
            <div class="alert alert-danger" role="alert">
                El usuario no existe
            </div>
            <?php
        } else {
            $accesoValido = password_verify($temp_contrasena, $contrasenaCifrada);
            if ($accesoValido) {
                echo "Validado correctamente";
                session_start();
                $_SESSION["usuario"] = $usuario;
                header("Location: index.php");
            } else {
            ?>
                <div class="alert alert-danger" role="alert">
                    No nos hemos podido validar.
                </div>
    <?php
            }
        }
    }
    ?>
    <div class="container">
        <h1>LOGIN</h1>
        <form method="post" action="">
            <div class="mb-3">
                <label for="usuario" class="form-label">Usuario: </label>
                <input type="text" name="usuario" id="usuario" placeholder="Usuario" class="form-control">
            </div>
            <div class="mb-3">
                <label for="contrasena" class="form-label">Contraseña: </label>
                <input type="text" name="contrasena" id="contrasena" placeholder="Contraseña" class="form-control">
            </div>
            <button type="submit" class="btn btn-primary">Login</button>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>

</html>