<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Digital Store</title>
    <!-- Favicon-->
    <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
    <!-- Bootstrap icons-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
    <!-- Core theme CSS (includes Bootstrap)-->
    <link href="css/style.css" rel="stylesheet" />

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
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
                <li class="nav-item"><a class="nav-link active" aria-current="page" href="index.php">Inicio</a></li>
                <li class="nav-item"><a class="nav-link" href="about.php">Sobre Nosotros</a></li>
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
    <!-- Header con botones dinámicos de marcas -->
    <header class="bg-dark py-5">
        <div class="container px-4 px-lg-5 my-5">
            <div class="text-center text-white">
                <h1 class="display-4 fw-bolder">Digital Store</h1>
                <p class="lead fw-normal text-white-50 mb-0">Productos de ultima tecnología!</p>
            </div>

            <!-- Botones de marcas -->
            <div class="d-flex justify-content-center mt-4">
                <?php
                // Conexion a la base de datos
                $conexion = mysqli_connect("localhost", "id22335600_penamatias", "Pass1234!");
                mysqli_select_db($conexion, "id22335600_tienda");

                // Consulta para obtener las marcas disponibles
                $consulta = 'SELECT DISTINCT marca FROM productos';

                // Ejecutar consulta
                $resultados = mysqli_query($conexion, $consulta);

                // Generar botón para cada marca encontrada
                while ($fila = mysqli_fetch_assoc($resultados)) {
                    $marcaBoton = $fila['marca'];
                    echo '<a class="btn btn-outline-light m-1" href="filtrar.php?marca=' . urlencode($marcaBoton) . '">' . ucwords($marcaBoton) . '</a>';
                }

                // Liberar resultados
                mysqli_free_result($resultados);

                // Cerrar conexión
                mysqli_close($conexion);
                ?>
            </div>
        </div>
    </header>
    <!-- Section-->
    <section class="py-5">
        <div class="container px-4 px-lg-5 mt-5">
            <div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-center">

                <?php
                // 1) Conexion
                $conexion = mysqli_connect("localhost", "id22335600_penamatias", "Pass1234!");
                mysqli_select_db($conexion, "id22335600_tienda");

                // 2) Preparar la orden SQL
                // Sintaxis SQL SELECT
                // SELECT * FROM nombre_tabla
                // => Selecciona todos los campos de la siguiente tabla
                // SELECT campos_tabla FROM nombre_tabla
                // => Selecciona los siguientes campos de la siguiente tabla
                $consulta = 'SELECT * FROM productos';

                // 3) Ejecutar la orden y obtenemos los registros
                $datos = mysqli_query($conexion, $consulta);

                //  recorro todos los registros y genero una CARD PARA CADA UNA
                while ($reg = mysqli_fetch_array($datos)) { ?>

                    <div class="col mb-5">
                        <div class="card h-100 border-solid border-dark">
                            <!-- Product image-->
                            <img class="card-img-top" src="data:image/jpg;base64, <?php echo base64_encode($reg['imagen']) ?>" alt="..." width="100px" height="200px" />
                            <!-- Product details-->
                            <div class="card-body p-4">
                                <div class="text-center">
                                    <!-- Product name-->
                                    <h5 class="fw-bolder"><?php echo ucwords($reg['marca']) ?></h5>
                                    <h5 class="fw-bolder"><?php echo ucwords($reg['modelo']) ?></h5>
                                    <!-- Product price-->
                                    <h5>$<?php echo $reg['precio']; ?></h2>
                                </div>
                            </div>
                            <!-- Product actions-->
                            <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">

                                <!--boton con link de pago que hay que cargar primero en la base de datos
                                <div class="text-center"> <?php // echo $reg['link']; 
                                                            ?></div>-->
                                <br>
                                <!--boton que me lleva a la pagina del producto-->
                                <div class="text-center">
                                    <a href="productos.php?id=<?php echo $reg['id']; ?>"> <button type="button" name="button">Ver producto</button></a>
                                </div>
                            </div>
                        </div>
                    </div>

                <?php } ?>

            </div>
        </div>
    </section>
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



</body>

</html>