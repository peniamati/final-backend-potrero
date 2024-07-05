<?php
// 1) Conexion
$conexion = mysqli_connect("localhost", "id22335600_penamatias", "Pass1234!");
mysqli_select_db($conexion, "id22335600_tienda");

$alertScript = '';

if (isset($_POST['guardar_cliente'])) {
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $mail = $_POST['mail'];
    $telefono = $_POST['telefono'];
    $producto_id = isset($_POST['producto_id']) ? $_POST['producto_id'] : '';

    // Verificar si el correo ya existe
    $consulta_existencia = "SELECT COUNT(*) as total FROM clientes WHERE mail = '$mail'";
    $resultado_existencia = mysqli_query($conexion, $consulta_existencia);
    $row = mysqli_fetch_assoc($resultado_existencia);

    if ($row['total'] > 0) {
        $alertScript = "Swal.fire({
            icon: 'error',
            title: 'El correo ingresado ya está registrado. Intente con otro correo.',
            showConfirmButton: true,
            allowOutsideClick: false
        });";
    } else {
        // Insertar nuevo cliente
        $consulta = "INSERT INTO clientes (nombre, apellido, mail, telefono) VALUES ('$nombre', '$apellido', '$mail', '$telefono')";
        if (mysqli_query($conexion, $consulta)) {
            $alertScript = "Swal.fire({
                icon: 'success',
                title: 'Cliente agregado exitosamente',
                showCancelButton: true,
                confirmButtonText: 'Agregar otro cliente',
                cancelButtonText: 'Volver a la página',
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = 'agregarcliente.php?producto_id=$producto_id';
                } else {
                    window.location.href = 'productos.php?id=$producto_id';
                }
            });";
        } else {
            $alertScript = "Swal.fire({
                icon: 'error',
                title: 'Error al agregar cliente. Intente nuevamente.',
                showConfirmButton: true,
                allowOutsideClick: false
            });";
        }
    }

    // Liberar resultados
    mysqli_free_result($resultado_existencia);
}

mysqli_close($conexion);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Digital Store</title>
    <!-- Core theme CSS (includes Bootstrap)-->
    <link href="css/styles.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
<!-- Navigation-->
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container px-4 px-lg-5">
        <a class="navbar-brand" href="index.php">Digital Store</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span
                    class="navbar-toggler-icon"></span></button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-4">
                <li class="nav-item"><a class="nav-link active" aria-current="page" href="index.php">Inicio</a></li>
                <li class="nav-item"><a class="nav-link" href="about.php">Sobre Nosotros</a></li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" id="navbarDropdownMarcas" href="#" role="button"
                       data-bs-toggle="dropdown" aria-expanded="false">Marcas</a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdownMarcas">
                        <?php
                        // Consulta para obtener las marcas disponibles
                        $consultaMarcas = 'SELECT DISTINCT marca FROM productos';

                        // Ejecutar consulta
                        $conexion = mysqli_connect("localhost", "id22335600_penamatias", "Pass1234!");
                        mysqli_select_db($conexion, "id22335600_tienda");
                        $resultadosMarcas = mysqli_query($conexion, $consultaMarcas);

                        // Generar elementos del dropdown
                        while ($filaMarca = mysqli_fetch_assoc($resultadosMarcas)) {
                            $marcaDropdown = $filaMarca['marca'];
                            echo '<li><a class="dropdown-item" href="filtrar.php?marca=' . urlencode($marcaDropdown) . '">' . ucwords($marcaDropdown) . '</a></li>';
                        }

                        // Liberar resultados
                        mysqli_free_result($resultadosMarcas);
                        ?>
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" id="navbarDropdownProductos" href="#" role="button"
                       data-bs-toggle="dropdown" aria-expanded="false">Productos</a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdownProductos">
                        <?php
                        // Consulta para obtener los productos disponibles
                        $consultaProductos = 'SELECT DISTINCT producto FROM productos';

                        // Ejecutar consulta
                        $resultadosProductos = mysqli_query($conexion, $consultaProductos);

                        // Generar elementos del dropdown
                        while ($filaProducto = mysqli_fetch_assoc($resultadosProductos)) {
                            $productoDropdown = $filaProducto['producto'];
                            echo '<li><a class="dropdown-item" href="filtrar.php?producto=' . urlencode($productoDropdown) . '">' . ucwords($productoDropdown) . '</a></li>';
                        }

                        // Liberar resultados y cerrar conexión
                        mysqli_free_result($resultadosProductos);
                        mysqli_close($conexion);
                        ?>
                    </ul>
                </li>
                <li class="nav-item"><a class="nav-link" href="contacto.php">Contacto</a></li>

            </ul>
            <form class="d-flex">
                <a class="btn btn-outline-dark" href="login.html">Vendedores</a>
            </form>
        </div>
    </div>
</nav>

<!-- Header con título -->
<header class="bg-dark py-5">
    <div class="container px-4 px-lg-5 my-5">
        <div class="text-center text-white">
            <h1 class="display-4 fw-bolder">Agregar Cliente</h1>
        </div>
    </div>
</header>

<!-- Content Body -->
<div class="container mt-5 mb-5">
    <form id="formAgregarCliente" method="POST">
        <input type="hidden" name="producto_id"
               value="<?php echo isset($_GET['producto_id']) ? $_GET['producto_id'] : ''; ?>">
        <div class="mb-3">
            <label for="nombre" class="form-label">Nombre</label>
            <input type="text" class="form-control" id="nombre" name="nombre" required>
        </div>
        <div class="mb-3">
            <label for="apellido" class="form-label">Apellido</label>
            <input type="text" class="form-control" id="apellido" name="apellido" required>
        </div>
        <div class="mb-3">
            <label for="mail" class="form-label">Mail</label>
            <input type="email" class="form-control" id="mail" name="mail" required>
        </div>
        <div class="mb-3">
            <label for="telefono" class="form-label">Teléfono</label>
            <input type="text" class="form-control" id="telefono" name="telefono" required>
        </div>
        <button type="submit" class="btn btn-primary" name="guardar_cliente">Agregar Cliente</button>
    </form>
</div>

<!-- Footer-->
<footer class="py-5 bg-dark">
    <div class="container">
        <p class="m-0 text-center text-white">Copyright &copy; Peña Matias 2024</p>
    </div>
</footer>

<!-- Bootstrap core JS-->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
<!-- Core theme JS-->
<script src="js/scripts.js"></script>
<script>
    // Mostrar alerta según el resultado obtenido en PHP
    <?php echo $alertScript; ?>
</script>

</body>
</html>
