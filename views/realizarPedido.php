<?php
    require "../util/conecta_bbdd.php";
    session_start();
    if(!isset($_SESSION["usuario"])){
        header("Location: login.php");
    }
    $usuario = $_SESSION["usuario"];
    $precioTotal = $_POST["precioTotal"];
    $idCesta = $_POST["idCesta"];
    $fechaActual = date('Y/m/d');
    $numeroProductos = $_POST["numeroProductos"];
    
    $sql = "INSERT INTO Pedidos (usuario, precioTotal, fechaPedido) VALUES ('$usuario', '$precioTotal', '$fechaActual')";
    $conexion -> query($sql);

    $sql2 = "SELECT idPedido FROM Pedidos WHERE usuario = '$usuario' AND precioTotal = '$precioTotal' AND fechaPedido = '$fechaActual'";
    $idPedido = $conexion -> query($sql2) -> fetch_assoc()["idPedido"]; 

    $sql3 = "SELECT idProducto, cantidad FROM productosCestas WHERE idCesta = '$idCesta'";
    $resAux = $conexion -> query($sql3);


    header("Location: index.php");
?>