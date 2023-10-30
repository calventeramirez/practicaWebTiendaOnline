<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Añadir Producto</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <?php require "depurar.php" ?>
</head>
<body>
    <?php
        if($_SERVER["REQUEST_METHOD"] == "POST"){
            if(isset($_POST["nombre"])){
                $temp_nombre = depurar($_POST["nombre"]);
            }else{
                $temp_nombre = "";
            }

            if(isset($_POST["precio"])){
                $temp_precio = depurar($_POST["precio"]);
            }else{
                $temp_precio = "";
            }
            
            if(isset($_POST["descripcion"])){
                $temp_descripcion = depurar($_POST["descripcion"]);
            }else{
                $temp_descripcion = "";
            }
            
            if(isset($_POST["cantidad"])){
                $temp_cantidad = depurar($_POST["cantidad"]);
            }else{
                $temp_cantidad = "";
            }
            
            //Validacion y patrón de nombre
            if(!strlen($temp_nombre) > 0){
                $err_nombre = "El nombre es obligatorio";
            }else{
                if(strlen($temp_nombre) > 40){
                    $err_nombre = "No puede contener más de 40 caracteres";
                }else{
                    $patron ="/^[a-zA-Z0-9][a-zA-Z0-9 ]+[a-zA-Z0-9]$/";
                    if(!preg_match($patron,$temp_nombre)){
                        $err_nombre = "El nombre debe tener menos de 40 caracteres";
                    }else{
                        if(strlen($temp_nombre) > 40){
                            $err_nombre = "No puede contener más de 40 caracteres";
                        }else{
                            $nombre = $temp_nombre;
                        }
                    }
                }
            }

            //Validacion de precio
            if(!strlen($temp_precio) > 0){
                $err_precio = "Error. El precio debe existir";
            }else{
                if($temp_precio < 0 || $temp_precio > 99999.99){
                    $err_precio = "Error el precio debe estar entre 0 y 99999.99";
                }else{
                    $precio = $temp_precio;
                }
            }

            //Validacion de descripcion
            
        }
    ?>
    <div class = container>
        <h1>Formulario Añadir Producto</h1>
        <form method = "POST" action="">
            <div clas = "mb-3">
                <label for="nombre" class = "form-label">Nombre:</label>
                <input type="text" name="nombre" id="nombre" placeholder="Nombre del producto" class="form-control">
                <?php
                    if(isset($err_nombre)){
                        echo $err_nombre;
                    }
                ?>
            </div>
            <div clas = "mb-3">
                <label for="precio" class = "form-label">Precio:</label>
                <input type="text" name="precio" id="precio" placeholder="Precio del producto" class="form-control">
                <?php
                    if(isset($err_precio)){
                        echo $err_precio;
                    }
                ?>
            </div>
            <div class = "mb-3">
                <label for="descripcion" class = "form-label">Descripción:</label>
                <input type="text" name="descripcion" id="descripcion" placeholder="Descripción del producto" class="form-control">
            </div>
            <div class = "mb-3">
                <label for= "cantidad"class = "form-label">Cantidad:</label>
                <input type="text" name="cantidad" id="cantidad" placeholder="Cantidad del producto" class="form-control">
            </div>
            <button type="submit" class="btn btn-primary">Añadir</button>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
</html>