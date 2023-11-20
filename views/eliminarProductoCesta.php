<?php
    session_start();
    require "../util/conecta_bbdd.php";
    $id = $_POST["id"];
    $precio = $_POST["precioTotal"];
    $idCesta = $_POST["idCesta"];
    $usuario = $_SESSION["usuario"];
    //Recupero la cantidad del producto
    $sqlcantidad = "SELECT cantidad FROM productosCestas WHERE idProducto = $id";
    $cantidad = $conexion -> query($sqlcantidad) -> fetch_assoc()["cantidad"];
    //Elimino la fila de la cesta
    $sql = "DELETE FROM productosCestas WHERE idProducto = $id";
    $conexion -> query($sql);
    //Actualizo el precio total de la cesta
    $sql2 = "UPDATE Cestas SET precioTotal = '$precio'  WHERE idCesta = '$idCesta'";
    $conexion -> query($sql2);
    //Actualizo la cantidad del producto
    $sql3 = "UPDATE productos SET cantidad = cantidad + $cantidad WHERE idProducto = $id";
    $conexion -> query($sql3);
    header("Location: cesta.php");
?>