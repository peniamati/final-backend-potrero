<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Digital Store - Tu tienda de tecnología con 10 años de trayectoria">
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
                <li class="nav-item"><a class="nav-link active" href="about.php">Sobre Nosotros</a></li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" id="navbarDropdownMarcas" href="#" role="button"
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

    <!-- Page Content -->
    <div class="container">
        <div class="row mt-5">
            <div class="col-lg-12 text-center">
                <h1 class="display-5 fw-bold">Digital Store</h1>
                <p class="lead mt-5">Somos una tienda de productos de tecnología con más de 10 años de experiencia en el
                    mercado. Nos especializamos en ofrecer productos de última generación y un servicio al cliente
                    excepcional.</p>
            </div>
        </div>

        <!-- Imágenes de referencia -->
        <div class="row mt-5">
            <div class="col-md-4 mb-4">
                <div class="card">
                    <img src="images/localtecnologia.jpg" class="card-img-top" alt="Local de tecnologia" width="200" height="200">
                    <div class="card-body">
                        <h5 class="card-title">Nuestra tienda</h5>
                        <p class="card-text">Ubicada en el corazón de la ciudad, ofrecemos un ambiente acogedor y
                            tecnológico.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card">
                    <img src="images/clientesfelices.jpg" class="card-img-top" alt="Clientes felices" width="200" height="200">
                    <div class="card-body">
                        <h5 class="card-title">Nuestros clientes</h5>
                        <p class="card-text">Nos enorgullece tener clientes satisfechos que confían en nuestros
                            productos y servicios.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card">
                    <img src="images/tecnologia.jpg" class="card-img-top" alt="Tecnologia de ultima generacion" width="200" height="200">
                    <div class="card-body">
                        <h5 class="card-title">Tecnología de última generación</h5>
                        <p class="card-text">Trabajamos con las mejores marcas y ofrecemos productos innovadores que
                            marcan la diferencia.</p>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <!-- /.container -->

    <!-- Footer -->
    <footer class="py-5 bg-dark">
        <div class="container">
            <p class="m-0 text-center text-white">Copyright &copy; 2024 Digital Store</p>
        </div>
    </footer>

    <!-- Bootstrap core JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Core theme JS -->
    <script src="js/scripts.js"></script>

</body>

</html>
