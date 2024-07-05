<?php
// Datos de la compra (Estos datos pueden ser obtenidos de la base de datos o de una sesión)
$cliente_id = $_GET['cliente'];
$producto_id = $_GET['producto'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Confirmación de Compra</title>
  <!-- Core theme CSS (includes Bootstrap)-->
  <link href="css/styles.css" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
  <div class="container mt-5">
    <h1>Confirmación de Compra</h1>
    <p>Cliente ID: <?php echo htmlspecialchars($cliente_id); ?></p>
    <p>Producto ID: <?php echo htmlspecialchars($producto_id); ?></p>
    <p>Detalles de la compra:</p>
    <!-- Aquí puedes añadir más detalles de la compra -->
  </div>

  <!-- Bootstrap core JS-->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
  <!-- Core theme JS-->
  <script src="js/scripts.js"></script>
</body>
</html>
