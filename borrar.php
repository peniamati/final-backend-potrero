<?php
$conexion = mysqli_connect("localhost", "id22335600_penamatias", "Pass1234!");
mysqli_select_db($conexion, "id22335600_tienda");

$id = $_GET["id"];

$consulta = "DELETE FROM productos WHERE id=$id";

if (mysqli_query($conexion, $consulta)) {
    echo "<script>window.location.href = 'listar.php?status=deleted';</script>";
} else {
    echo "Error al eliminar el producto: " . mysqli_error($conexion);
}
?>
