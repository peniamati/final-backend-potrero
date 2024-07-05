<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Filtrado de productos">
    <meta name="author" content="Digital Store">
    <title>Digital Store</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <!-- Core theme CSS -->
    <link href="css/styles.css" rel="stylesheet">
</head>
<body>
    <!-- Navigation-->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container px-4 px-lg-5">
            <a class="navbar-brand" href="index.php">Digital Store</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-4">
                    <li class="nav-item"><a class="nav-link" aria-current="page" href="index.php">Inicio</a></li>
                    <li class="nav-item"><a class="nav-link" href="about.php">Sobre Nosotros</a></li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle <?php echo isset($_GET['marca']) ? 'active' : ''; ?>" id="navbarDropdownMarcas" href="#" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false">Marcas</a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdownMarcas">
                            <?php
                            // Conexión a la base de datos
                            $conexion = mysqli_connect("localhost", "id22335600_penamatias", "Pass1234!");
                            mysqli_select_db($conexion, "id22335600_tienda");

                            // Consulta para obtener las marcas disponibles
                            $consultaMarcas = 'SELECT DISTINCT marca FROM productos';

                            // Ejecutar consulta
                            $resultadosMarcas = mysqli_query($conexion, $consultaMarcas);

                            // Generar elementos del dropdown
                            while ($filaMarca = mysqli_fetch_assoc($resultadosMarcas)) {
                                $marcaDropdown = $filaMarca['marca'];
                                $activeClass = (isset($_GET['marca']) && $_GET['marca'] == $marcaDropdown) ? 'active' : '';
                                echo '<li><a class="dropdown-item ' . $activeClass . '" href="filtrar.php?marca=' . urlencode($marcaDropdown) . '">' . ucwords($marcaDropdown) . '</a></li>';
                            }

                            // Liberar resultados
                            mysqli_free_result($resultadosMarcas);
                            ?>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle <?php echo isset($_GET['producto']) ? 'active' : ''; ?>" id="navbarDropdownProductos" href="#" role="button"
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
                                $activeClass = (isset($_GET['producto']) && $_GET['producto'] == $productoDropdown) ? 'active' : '';
                                echo '<li><a class="dropdown-item ' . $activeClass . '" href="filtrar.php?producto=' . urlencode($productoDropdown) . '">' . ucwords($productoDropdown) . '</a></li>';
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

    <!-- Header -->
    <header class="bg-dark py-5">
        <div class="container px-4 px-lg-5 my-5">
            <div class="text-center text-white">
                <h1 class="display-4 fw-bolder">
                    <?php 
                    if (isset($_GET['marca']) && $_GET['marca']) {
                        echo ucwords($_GET['marca']); 
                    } elseif (isset($_GET['producto']) && $_GET['producto']) {
                        echo ucwords($_GET['producto']);
                    } else {
                        echo "Filtrar Productos";
                    }
                    ?>
                </h1>
                <p class="lead fw-normal text-white-50 mb-0">Encuentra los mejores productos según tus preferencias</p>
            </div>
        </div>
    </header>

    <!-- Section-->
    <section class="py-5">
        <div class="container px-4 px-lg-5 mt-5">
            <div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-center">

                <?php
                // Conexión a la base de datos
                $conexion = mysqli_connect("localhost", "id22335600_penamatias", "Pass1234!");
                mysqli_select_db($conexion, "id22335600_tienda");

                // Obtener parámetros
                $marca = isset($_GET['marca']) ? $_GET['marca'] : null;
                $producto = isset($_GET['producto']) ? $_GET['producto'] : null;

                // Construir la consulta SQL
                $consulta = 'SELECT * FROM productos WHERE 1=1';
                if ($marca) {
                    $consulta .= ' AND marca="' . mysqli_real_escape_string($conexion, $marca) . '"';
                }
                if ($producto) {
                    $consulta .= ' AND producto="' . mysqli_real_escape_string($conexion, $producto) . '"';
                }

                // Ejecutar la consulta
                $datos = mysqli_query($conexion, $consulta);

                // Recorrer los registros y generar las tarjetas de productos
                while ($reg = mysqli_fetch_array($datos)) { ?>

                    <div class="col mb-5">
                        <div class="card h-100 border-solid border-dark">
                            <!-- Imagen del producto -->
                            <img class="card-img-top" src="data:image/jpg;base64, <?php echo base64_encode($reg['imagen']) ?>" alt="..." width="100px" height="200px" />
                            <!-- Detalles del producto -->
                            <div class="card-body p-4">
                                <div class="text-center">
                                    <h5 class="fw-bolder"><?php echo ucwords($reg['marca']) ?></h5>
                                    <h5 class="fw-bolder"><?php echo ucwords($reg['modelo']) ?></h5>
                                    <h5>$<?php echo $reg['precio']; ?></h5>
                                </div>
                            </div>
                            <!-- Acciones del producto -->
                            <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
                                <div class="text-center">
                                    <a href="productos.php?id=<?php echo $reg['id']; ?>"> <button type="button" name="button">Ver producto</button></a>
                                </div>
                            </div>
                        </div>
                    </div>

                <?php }

                // Liberar resultados y cerrar conexión
                mysqli_free_result($datos);
                mysqli_close($conexion);
                ?>

            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="py-5 bg-dark">
        <div class="container">
            <p class="m-0 text-center text-white">Copyright &copy; Digital Store 2024</p>
        </div>
    </footer>

    <!-- Bootstrap core JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Core theme JS -->
    <script src="js/scripts.js"></script>
</body>
</html>
