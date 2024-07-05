<?php
$conexion = mysqli_connect("localhost", "id22335600_penamatias", "Pass1234!");
mysqli_select_db($conexion, "id22335600_tienda");

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['guardar_cambios'])) {
    $id = $_POST['id'];
    $producto = $_POST['producto'];
    $marca = $_POST['marca'];
    $modelo = $_POST['modelo'];
    $precio = $_POST['precio'];

    // Verificar si se ha enviado un archivo de imagen
    if(isset($_FILES['imagen']) && $_FILES['imagen']['size'] > 0) {
        $imagen = addslashes(file_get_contents($_FILES['imagen']['tmp_name']));
        $imagen_sql = ", imagen='$imagen'";
    } else {
        $imagen_sql = ""; // Si no se envía ninguna imagen, dejar el campo de imagen en blanco
    }

    $consulta = "UPDATE productos SET producto='$producto', marca='$marca', modelo='$modelo' , precio='$precio' $imagen_sql WHERE id=$id";
    if (mysqli_query($conexion, $consulta)) {
        echo "<script>window.location.href = 'listar.php?status=modified';</script>";
        exit(); // Importante para evitar ejecución adicional de código
    } else {
        echo "Error al actualizar el producto: " . mysqli_error($conexion);
    }
} else {
    echo "Acceso no autorizado.";
}
?>
