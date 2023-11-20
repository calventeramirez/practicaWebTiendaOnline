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
    
    $idProductos = [];
    $cantidades = [];
    while($fila = $resAux -> fetch_assoc()){
        array_push($idProductos, $fila["idProducto"]);
        array_push($cantidades, $fila["cantidad"]);
    }

    for($i = 0; $i < $numeroProductos; $i++){
        $linea = $i + 1;
        $sqlAux2 = "SELECT precio FROM Productos WHERE idProducto = '$idProductos[$i]'";
        $precio = $conexion -> query($sqlAux2) -> fetch_assoc()["precio"];
        $sql4 = "INSERT INTO lineasPedidos VALUES ('$linea', '$idProductos[$i]', '$idPedido', '$precio' , '$cantidades[$i]')";
        $conexion -> query($sql4);
    }
    
    $cont = 0;
    while($cont < $numeroProductos){
        $sql5 = "DELETE FROM productosCestas WHERE idProducto = $idProductos[$cont]";
        $conexion -> query($sql5);
        $cont++;
    }
    $sql6 = "UPDATE Cestas SET precioTotal = '0.0'  WHERE idCesta = '$idCesta'";
    $conexion -> query($sql6);
    header("Location: index.php");
?>