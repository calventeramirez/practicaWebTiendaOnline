<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <?php require "../util/conecta_bbdd.php" ?>
    <?php require "../util/producto.php" ?>
    <?php require "../util/depurar.php" ?>
    <link rel="stylesheet" href="styles/estilos.css">
</head>

<body>
    <?php
    session_start();
    $sql = "SELECT * FROM productos";
    $resultado = $conexion->query($sql);
    $productos = [];
    while ($fila = $resultado->fetch_assoc()) {
        $nuevo_producto = new Producto($fila["idProducto"], $fila["nombreProducto"], $fila["precio"], $fila["descripcion"], $fila["cantidad"], $fila["imagen"]);
        array_push($productos, $nuevo_producto);
    }

    if($_SERVER["REQUEST_METHOD"] == "POST"){
        if(isset($_POST["idProducto"])){
            $idProducto = depurar($_POST["idProducto"]);
            $usuario = $_SESSION["usuario"];
            $sql2 = "SELECT * FROM cestas WHERE usuario = '$usuario'";
            $resultado = $conexion->query($sql2);
            $idCesta = -1;
            $temp_cantidad = depurar($_POST["cantidad"]);

            //Compruebo cantidad
            if($temp_cantidad <= 0 || $temp_cantidad > 5){
                $err_cantidad = "La cantidad debe ser entre 1 y 5";
            }else{
                $cantidad = $temp_cantidad;
            }

            while($fila = $resultado->fetch_assoc()){
               $idCesta = $fila["idCesta"];
            }

            if($idCesta != -1 && isset($cantidad)){
                $sqlCantida = "SELECT cantidad FROM productos WHERE idProducto = $idProducto";
                $cantidadTotal = $conexion->query($sqlCantida)->fetch_assoc()["cantidad"];
                $sqlcantidadEnCesta = "SELECT cantidad FROM productosCestas WHERE idProducto = $idProducto AND idCesta = $idCesta";
                $cantidadEnCesta = $conexion->query($sqlcantidadEnCesta)->fetch_assoc()["cantidad"];
                if($cantidad > 0 && $cantidad <= $cantidadTotal){

                    if($cantidadEnCesta == 0){
                        $sqlInsertarCesta = "INSERT INTO productosCestas (idProducto, idCesta, cantidad) VALUES ($idProducto, $idCesta, $cantidad)";
                        $resultado = $conexion->query($sqlInsertarCesta);
                    }else{
                        $cantidadEnCesta += $cantidad;
                        $sqlInsertarCesta = "UPDATE productosCestas SET cantidad = $cantidadEnCesta WHERE idProducto = $idProducto AND idCesta = $idCesta";
                        $resultado = $conexion->query($sqlInsertarCesta);

                    }
                    $acierto ="Producto añadido a la cesta";
                    $sqlAux = "SELECT precio FROM productos WHERE idProducto = '$idProducto'";
                    $res_precio = $conexion->query($sqlAux);
                    $fila_precio =  $res_precio->fetch_assoc();
                    $precio = $fila_precio["precio"];
                    $precioCantidad = $precio * $cantidad;
                    $sqlPrecioTotal = "UPDATE Cestas SET precioTotal = precioTotal + $precioCantidad WHERE idCesta = $idCesta";
                    $conexion-> query($sqlPrecioTotal);
                    $cantidadTotal -= $cantidad;
                    $sqlModCantidad  = "UPDATE productos SET cantidad = $cantidadTotal WHERE idProducto = $idProducto";
                    $conexion->query($sqlModCantidad);
                    header("Location: index.php");
                }else{
                    ?>
                        <div class="alert alert-danger" role="alert">
                            Error no se ha podido introducir el productos debido a que no hay suficiente cantidad.
                        </div>
                    <?php
                }
               
            }
        }
    }
    ?>

    <div class="container">
        <h1>Inicio</h1>
        <?php
        if (isset($_SESSION["usuario"])) {
            echo "<h2>Bienvenido " . $_SESSION["usuario"] . "</h2>";
        }
        ?>
        <header>
            <nav class="navigator">
                <ul>
                    <li><a href="index.php">Inicio</a></li>
                    <?php
                    if (isset($_SESSION["rol"])) {
                        if ($_SESSION["rol"] == "admin"){
                            echo "<li><a href='formularioAnadirProducto.php'>Añadir Productos</a></li>";
                            echo "<li><a href='modificarCantidadProductos.php'>Modicar Cantidad de Productos</a></li>";
                        }
                    }
                    ?>
                    
                    <?php
                    if (!isset($_SESSION["usuario"])){
                        echo "<li><a href='login.php'>Login</a></li>";
                        echo "<li><a href='formularioAnadirUsuario.php'> Añadir Usuario</a></li>";                    
                    }else{
                        echo "<li><a href='cesta.php'>Cesta</a></li>";
                        echo "<li><a href='logout.php'>Logout</a></li>";
                    }
                    ?>
                </ul>
            </nav>
        </header>
        <?php
            if(isset($err_cantidad)){?>
                <div class="alert alert-danger" role="alert">
                    <?php echo $err_cantidad; ?>
                </div>
            <?php
            }
            if(isset($acierto)){?>
                <div class="alert alert-success" role="alert">
                    <?php echo $acierto; ?>
                </div>
            <?php
            }
        ?>
        <table class="table table-secondary table-hover text-center">
            <thead class="table table-striped">
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Precio</th>
                    <th>Descripcion</th>
                    <th>Cantidad</th>
                    <th>Imagen</th>
                    <?php
                        if(isset($_SESSION["usuario"])){
                            echo"<th></th>";
                        }
                    ?>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($productos as $producto) {?>
                    <tr>
                    <td><?php echo $producto->idProducto; ?></td>
                    <td><?php echo $producto->nombreProducto; ?></td>
                    <td><?php echo $producto->precio; ?>€</td>
                    <td class = "text-start"><?php echo $producto->descripcion; ?></td>
                    <td><?php echo $producto->cantidad; ?></td>
                    <td><img src =  "<?php echo $producto->imagen; ?>"  alt ='' width = '50%' heigth = '50%'></td>
                    <?php
                    if(isset($_SESSION["usuario"])){?>
                    <td>
                        <form action = "" method="post">
                            <input type="hidden" name="idProducto" value="<?php echo $producto->idProducto; ?>">
                            <select name = "cantidad" class="form-select">
                                <option selected value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                            </select>
                            <input type="submit" name="Añadir" value="Añadir" class="btn btn-warning">
                        </form>
                    </td>
                    <?php
                    }
                    ?>
                    </tr>
                <?php }
                ?>
            </tbody>
        </table>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>

</html>