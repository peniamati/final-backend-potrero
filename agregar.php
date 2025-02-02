<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Digital Store</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
    <div class="container mt-5">
        <h1 class="mb-4">Digital Store</h1>
        <div class="mb-3">
            <a href="index.php" class="btn btn-primary">Inicio</a>
            <a href="listar.php" class="btn btn-primary">Listar productos</a>
            <a href="agregar.php" class="btn btn-primary active">Agregar producto</a>
        </div>
        <h2 class="mb-3">Agregar producto</h2>
        <p>Ingrese los datos del producto.</p>

        <form method="POST" action="agregar.php" enctype="multipart/form-data" class="needs-validation" novalidate>
            <div class="mb-3">
                <label for="producto" class="form-label">Producto</label>
                <input type="text" class="form-control" id="producto" name="producto" placeholder="Producto" required>
                <div class="invalid-feedback">Por favor, ingrese el tipo de prenda.</div>
            </div>
            <div class="mb-3">
                <label for="marca" class="form-label">Marca</label>
                <input type="text" class="form-control" id="marca" name="marca" placeholder="Marca" required>
                <div class="invalid-feedback">Por favor, ingrese la marca.</div>
            </div>
            <div class="mb-3">
                <label for="modelo" class="form-label">Modelo</label>
                <input type="text" class="form-control" id="modelo" name="modelo" placeholder="Modelo" required>
                <div class="invalid-feedback">Por favor, ingrese el modelo.</div>
            </div>
            <div class="mb-3">
                <label for="precio" class="form-label">Precio</label>
                <input type="text" class="form-control" id="precio" name="precio" placeholder="Precio" required>
                <div class="invalid-feedback">Por favor, ingrese el precio.</div>
            </div>
            <div class="mb-3">
                <label for="imagen" class="form-label">Imagen</label>
                <input type="file" class="form-control" id="imagen" name="imagen" required>
                <div class="invalid-feedback">Por favor, ingrese una imagen.</div>
            </div>
            <button type="submit" class="btn btn-primary">Ingresar</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXlZJ9g/c7g4WnyKhOg/t+dWFa/JdZZim97mBlm60YUh24rUh+8nK4CJDaKk" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-QwtYqOjNm/8JQzEr6fGfA5hPpDQSDgebrz1mTYspR2n/qMKNMX4oWgnNaeW1I3ul" crossorigin="anonymous"></script>
    <script>
        (function () {
            'use strict'

            var forms = document.querySelectorAll('.needs-validation')

            Array.prototype.slice.call(forms)
                .forEach(function (form) {
                    form.addEventListener('submit', function (event) {
                        if (!form.checkValidity()) {
                            event.preventDefault()
                            event.stopPropagation()
                        }

                        form.classList.add('was-validated')
                    }, false)
                })
        })();

        <?php if (isset($_GET['status'])): ?>
            <?php if ($_GET['status'] === 'success'): ?>
                Swal.fire(
                    '¡Éxito!',
                    'Producto agregado correctamente.',
                    'success'
                );
            <?php else: ?>
                Swal.fire(
                    '¡Error!',
                    'Hubo un error al agregar el producto.',
                    'error'
                );
            <?php endif; ?>
        <?php endif; ?>
    </script>
</body>
</html>

<?php
$conexion = mysqli_connect("localhost", "id22335600_penamatias", "Pass1234!");
mysqli_select_db($conexion, "id22335600_tienda");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $producto = $_POST['producto'];
    $marca = $_POST['marca'];
    $modelo = $_POST['modelo'];
    $precio = $_POST['precio'];
    $imagen = addslashes(file_get_contents($_FILES['imagen']['tmp_name']));

    $consulta = "INSERT INTO productos (id,producto,marca,modelo,precio,imagen) VALUES (0,'$producto','$marca','$modelo','$precio','$imagen')";
    
    if (mysqli_query($conexion, $consulta)) {
        echo "<script>window.location.href = 'agregar.php?status=success';</script>";
    } else {
        echo "<script>window.location.href = 'agregar.php?status=error';</script>";
    }
}
?>
