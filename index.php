<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <?php require "conecta_bbdd.php" ?>
    <?php require "Objetos/producto.php" ?>
</head>

<body>
    <?php
    $sql = "SELECT * FROM productos";
    $resultado = $conexion->query($sql);
    $productos = [];
    while($fila = $resultado->fetch_assoc()){
        $nuevo_producto = new Producto($fila["idProducto"], $fila["nombreProducto"], $fila["precio"], $fila["descripcion"], $fila["cantidad"], $fila["imagen"]);
        array_push($productos, $nuevo_producto);
    }
    ?>
    
    <div class="container">
        <h1>Inicio</h1>
        <table class="table table-secondary table-hover">
            <thead class="table table-striped">
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Precio</th>
                    <th>Descripcion</th>
                    <th>Cantidad</th>
                    <th>Imagen</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach($productos as $producto){
                    echo "<tr>";
                    echo "<td>" . $producto->idProducto . "</td>";
                    echo "<td>" . $producto->nombreProducto . "</td>";
                    echo "<td>" . $producto->precio . "</td>";
                    echo "<td>" . $producto->descripcion . "</td>";
                    echo "<td>" . $producto->cantidad . "</td>";
                    echo "<td><img src = '".$producto->imagen."' alt ='' width = '50%' heigth = '50%'></td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>

</html>