<?php
// 1) Conexion
$conexion = mysqli_connect("localhost", "id22335600_penamatias", "Pass1234!");
mysqli_select_db($conexion, "id22335600_tienda");

// 2) Recibir los datos del formulario
$producto_id = $_POST['producto_id'];
$producto = $_POST['producto'];
$marca = $_POST['marca'];
$modelo = $_POST['modelo'];
$precio = $_POST['precio'];
$cliente_id = $_POST['cliente'];
$pago_link = $_POST['pago_link'];

// 3) Insertar los datos en la tabla compras
$insertarCompra = "INSERT INTO compras (id, producto_id, producto, marca, modelo, precio, cliente_id) VALUES (0, '$producto_id', '$producto', '$marca', '$modelo', '$precio', '$cliente_id')";

if (mysqli_query($conexion, $insertarCompra)) {
    // 4) Redirigir al enlace de pago
    header("Location: $pago_link");
} else {
    echo "Error: " . mysqli_error($conexion);
}

// 5) Cerrar la conexión
mysqli_close($conexion);
?>
