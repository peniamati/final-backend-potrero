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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
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
                    <li class="nav-item"><a class="nav-link" aria-current="page" href="index.php">Inicio</a></li>
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
                    <li class="nav-item"><a class="nav-link active" href="#contacto">Contacto</a></li>
                </ul>
                <form class="d-flex">
                    <a class="btn btn-outline-dark" href="login.html">Vendedores</a>
                </form>
            </div>
        </div>
    </nav>
    <!-- Header-->
    <header class="bg-dark py-5">
        <div class="container px-4 px-lg-5 my-5">
            <div class="text-center text-white">
                <h1 class="display-4 fw-bolder">Contacto</h1>
            </div>
        </div>
    </header>

    <!-- Contacto -->
    <section id="contacto" class="py-5 bg-light">
        <div class="container px-4 px-lg-5">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <form id="contactForm">
                        <div class="form-floating mb-3">
                            <input class="form-control" id="nombre" name="nombre" type="text" placeholder="Nombre" required />
                            <label for="nombre">Nombre</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input class="form-control" id="email" name="email" type="email" placeholder="Email" required />
                            <label for="email">Email</label>
                        </div>
                        <div class="form-floating mb-3">
                            <textarea class="form-control" id="mensaje" name="mensaje" placeholder="Mensaje" style="height: 10rem;" required></textarea>
                            <label for="mensaje">Mensaje</label>
                        </div>
                        <div class="d-grid">
                            <button class="btn btn-primary btn-lg" type="submit">Enviar</button>
                        </div>
                    </form>
                </div>
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
    <!-- SweetAlert -->
    <script>
    document.getElementById('contactForm').addEventListener('submit', function (e) {
        e.preventDefault();
        
        // Mostrar alerta de SweetAlert
        Swal.fire({
            icon: 'success',
            title: 'Mensaje enviado',
            text: 'Tu mensaje ha sido enviado correctamente.',
        }).then(() => {
            // Restaurar los campos del formulario
            document.getElementById('contactForm').reset();
        });
    });
    </script>
</body>
</html>
