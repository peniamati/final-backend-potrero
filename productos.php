<?php
// 1) Conexion
$conexion = mysqli_connect("localhost", "id22335600_penamatias", "Pass1234!");
mysqli_select_db($conexion, "id22335600_tienda");

// 2) Almacenamos los datos del envío GET
$id = $_GET['id'];

// 3) Preparar la SQL
$consulta = "SELECT * FROM productos WHERE id=$id";

// 4) Ejecutar la orden y almacenamos en una variable el resultado
$repuesta = mysqli_query($conexion, $consulta);

// 5) Transformamos el registro obtenido a un array
$datos = mysqli_fetch_array($repuesta);

// Asignamos a diferentes variables los respectivos valores del array $datos.
$producto = $datos["producto"];
$marca = $datos["marca"];
$modelo = $datos["modelo"];
$precio = $datos["precio"];
$imagen = $datos['imagen'];
$pago = $datos['link'];

// Consulta para obtener los clientes
$consultaClientes = "SELECT id, nombre, apellido FROM clientes";
$resultadoClientes = mysqli_query($conexion, $consultaClientes);
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
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>

  <!-- Navigation -->
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container px-4 px-lg-5">
        <a class="navbar-brand" href="index.php">Digital Store</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
            data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
            aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-4">
                <li class="nav-item"><a class="nav-link" aria-current="page" href="index.php">Inicio</a></li>
                <li class="nav-item"><a class="nav-link active" href="about.php">Sobre Nosotros</a></li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" id="navbarDropdownMarcas" href="#" role="button"
                        data-bs-toggle="dropdown" aria-expanded="false">Marcas</a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdownMarcas">
                        <?php
                        // Consulta para obtener las marcas disponibles
                        $consultaMarcas = 'SELECT DISTINCT marca FROM productos';

                        // Ejecutar consulta
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
                <li class="nav-item"><a class="nav-link active" href="contacto.php">Contacto</a></li>
            </ul>
            <form class="d-flex">
                <a class="btn btn-outline-dark" href="login.html">Vendedores</a>
            </form>
        </div>
    </div>
</nav>

  <!-- Header -->
  <header class="bg-dark py-5">
        <div class="container px-4 px-lg-5 my-5">
            <div class="text-center text-white">
                <h1 class="display-4 fw-bolder">Detalle del producto</h1>
            </div>
        </div>
  </header>

  <!-- mostramos los datos de ese único producto en una card-->
  <div class="container mt-5 mb-5">
    <div class="row justify-content-center">
      <div class="card w-50">
        <img class="card-img-top" src="data:image/jpg;base64, <?php echo base64_encode($imagen)?>" alt="..." />

        <div class="card-body">
          <h5 class="card-title">Marca: <?php echo $marca;?></h5>
          <p class="card-text">Modelo: <?php echo $modelo?></p>
          <p class="card-text">Precio: $<?php echo $precio;?></p>

          <!-- Seleccionar cliente -->
          <form method="POST" action="procesar_pago.php" target="_blank">
            <div class="mb-3">
              <label for="cliente" class="form-label">Seleccione un Cliente</label>
              <select id="cliente" name="cliente" class="form-select" required>
                <?php
                while ($cliente = mysqli_fetch_assoc($resultadoClientes)) {
                  echo '<option value="' . $cliente['id'] . '">' . htmlspecialchars($cliente['nombre'] . ' ' . $cliente['apellido']) . '</option>';
                }
                ?>
              </select>
            </div>

            <p>¿No está su cliente?</p>
            <a href="agregarcliente.php?producto_id=<?php echo $id; ?>" class="btn btn-secondary">Agregar Cliente</a>
            <br><br>

            <!-- Enviar datos del producto y cliente a procesar_pago.php -->
            <input type="hidden" name="producto_id" value="<?php echo $id; ?>">
            <input type="hidden" name="producto" value="<?php echo htmlspecialchars($producto); ?>">
            <input type="hidden" name="marca" value="<?php echo htmlspecialchars($marca); ?>">
            <input type="hidden" name="modelo" value="<?php echo htmlspecialchars($modelo); ?>">
            <input type="hidden" name="precio" value="<?php echo htmlspecialchars($precio); ?>">
            <input type="hidden" name="pago_link" value="<?php echo htmlspecialchars($pago); ?>">
            <button type="submit" class="btn btn-primary">Link de Pago</button>
          </form>
        </div>
      </div>
    </div>
  </div>

<!-- Footer -->
<footer class="py-5 bg-dark">
  <div class="container">
      <p class="m-0 text-center text-white">Copyright &copy; Peña Matias 2024</p>
  </div>
</footer>

<!-- Bootstrap core JS-->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
<!-- Core theme JS-->
<script src="js/scripts.js"></script>

</body>
</html>
