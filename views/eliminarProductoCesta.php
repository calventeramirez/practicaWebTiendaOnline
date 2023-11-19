<?php
    session_start();
    require "../util/conecta_bbdd.php";
    $id = $_POST["id"];
    $precio = $_POST["precioTotal"];
    $idCesta = $_POST["idCesta"];
    $usuario = $_SESSION["usuario"];
    $sql = "DELETE FROM productosCestas WHERE idProducto = $id";
    $conexion -> query($sql);
    $sql2 = "UPDATE Cestas SET precioTotal = '$precio'  WHERE idCesta = '$idCesta'";
    $conexion -> query($sql2);
    header("Location: cesta.php");
?>