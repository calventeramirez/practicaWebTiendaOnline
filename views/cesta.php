<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cesta</title>
    <link rel="stylesheet" href="styles/estilos.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <?php require "../util/conecta_bbdd.php" ?>
</head>

<body>
    <?php
    session_start();
    if(isset($_SESSION["usuario"])){
        $usuario = $_SESSION["usuario"];
        $sql1 = "SELECT * FROM Cestas WHERE usuario = '$usuario'";
        $resultado = $conexion -> query($sql1);
       
        while($fila = $resultado -> fetch_assoc()){
            $idCesta = $fila["idCesta"];
            $precioTotal = $fila["precioTotal"];
        }

        $sql2 = "SELECT * FROM productosCestas WHERE idCesta = $idCesta";
        $resultado2 = $conexion -> query($sql2);

        while($fila = $resultado2->fetch_assoc()){
            $idProducto = $fila["idProducto"];
            $cantidad = $fila["cantidad"];
        }

        $sql3 = "SELECT * FROM productos WHERE idProducto = $idProducto";
        


    }
    ?>
    <div class="container">
        <h1>Cesta</h1>
        <?php
        if (isset($_SESSION["usuario"])) {
            echo "<h2>Bienvenido " . $_SESSION["usuario"] . "</h2>";
        }else{
            header("Location: login.php");
        }
        ?>
        <header>
            <nav class="navigator">
                <ul>
                    <li><a href="index.php">Inicio</a></li>
                    <?php
                    if (isset($_SESSION["rol"])) {
                        if ($_SESSION["rol"] == "admin")
                            echo "<li><a href='formularioAnadirProducto.php'>Añadir Productos</a></li>";
                    }
                    ?>

                    <?php
                    if (!isset($_SESSION["usuario"])) {
                        echo "<li><a href='login.php'>Login</a></li>";
                        echo "<li><a href='formularioAnadirUsuario.php'> Añadir Usuario</a></li>";
                    } else {
                        echo "<li><a href='cesta.php'>Cesta</a></li>";
                        echo "<li><a href='logout.php'>Logout</a></li>";
                    }
                    ?>
                </ul>
            </nav>
        </header>
        <main>
            <table>
                <thead>
                    <tr>
                        <td>Nombre</td>
                        <td>Imagen</td>
                        <td>Cantidad</td>
                    </tr>
                </thead>
                <tbody>
                    
                </tbody>
            </table>
        </main>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>

</html>