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
  <div class="container">
    <h1 class="mt-5">Digital Store</h1>
    <div class="mt-3">
      <a href="index.php" class="btn btn-primary">Inicio</a>
      <a href="listar.php" class="btn btn-primary active">Listar productos</a>
      <a href="agregar.php" class="btn btn-primary">Agregar productos</a>
    </div>
    <h2 class="mt-4">Lista de productos</h2>
    <p>La siguiente lista muestra los datos de los productos actualmente en stock.</p>
    <table class="table table-bordered">
      <thead>
        <tr>
          <th>ID</th>
          <th>TIPO DE PRODUCTO</th>
          <th>MARCA</th>
          <th>MODELO</th>
          <th>PRECIO</th>
          <th>IMAGEN</th>
          <th>EDITAR</th>
          <th>BORRAR</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $conexion = mysqli_connect("localhost", "id22335600_penamatias", "Pass1234!");
        mysqli_select_db($conexion, "id22335600_tienda");

        $consulta = 'SELECT * FROM productos';

        $datos = mysqli_query($conexion, $consulta);
        while ($reg = mysqli_fetch_array($datos)) { ?>
          <tr>
            <td><?php echo $reg['id']; ?></td>
            <td><?php echo $reg['producto']; ?></td>
            <td><?php echo $reg['marca']; ?></td>
            <td><?php echo $reg['modelo']; ?></td>
            <td>$<?php echo $reg['precio']; ?></td>
            <td class="text-center"><img src="data:image/png;base64, <?php echo base64_encode($reg['imagen']) ?>" alt="" width="100px" height="100px"></td>
            <td><button type="button" class="btn btn-primary btn-edit" data-id="<?php echo $reg['id']; ?>" data-producto="<?php echo $reg['producto']; ?>" data-marca="<?php echo $reg['marca']; ?>" data-modelo="<?php echo $reg['modelo']; ?>" data-precio="<?php echo $reg['precio']; ?>" data-imagen="<?php echo base64_encode($reg['imagen']); ?>" data-toggle="modal" data-target="#exampleModal">Editar</button></td>
            <td><a href="borrar.php?id=<?php echo $reg['id']; ?>" class="btn btn-danger delete-link">Borrar</a></td>
          </tr>
        <?php } ?>
      </tbody>
    </table>
  </div>

  <!-- Modal -->
  <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Editar Producto</h5>
          <button type="button" class="btn-close align-self-end" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form id="editForm" action="modificar.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" id="editId" name="id">
            <div class="form-group">
              <label for="editProducto">Tipo de producto</label>
              <input type="text" class="form-control" id="editProducto" name="producto" required>
            </div>
            <div class="form-group">
              <label for="editMarca">Marca</label>
              <input type="text" class="form-control" id="editMarca" name="marca" required>
            </div>
            <div class="form-group">
              <label for="editModelo">Modelo</label>
              <input type="text" class="form-control" id="editModelo" name="modelo" required>
            </div>
            <div class="form-group">
              <label for="editPrecio">Precio</label>
              <input type="text" class="form-control" id="editPrecio" name="precio" required>
            </div>
            <div class="form-group">
              <label for="editImagen">Imagen Actual</label><br>
              <img id="currentImage" src="" alt="" width="100px" height="100px">
            </div>
            <div class="form-group">
              <label for="editNewImagen">Seleccionar Nueva Imagen</label>
              <input type="file" class="form-control-file" id="editNewImagen" name="imagen">
            </div>
            <div class="modal-footer">
              <button type="submit" class="btn btn-primary" name="guardar_cambios">Guardar Cambios</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>

  <script>
    $(document).ready(function() {
      // Mostrar alerta si el producto se ha modificado exitosamente
      const urlParams = new URLSearchParams(window.location.search);
      const status = urlParams.get('status');
      if (status === 'modified') {
        Swal.fire(
          'Producto Modificado',
          'El producto ha sido modificado exitosamente.',
          'success'
        );
      }

      $('.delete-link').click(function(e) {
        e.preventDefault();
        const href = $(this).attr('href');
        Swal.fire({
          title: '¿Estás seguro?',
          text: "¡No podrás revertir esto!",
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Sí, eliminarlo',
          cancelButtonText: 'Cancelar'
        }).then((result) => {
          if (result.isConfirmed) {
            $.ajax({
              url: href,
              method: 'GET',
              success: function(response) {
                Swal.fire(
                  'Eliminado!',
                  'El producto ha sido eliminado exitosamente.',
                  'success'
                ).then(() => {
                  window.location.reload();
                });
              },
              error: function() {
                Swal.fire(
                  'Error!',
                  'Hubo un problema al eliminar el producto.',
                  'error'
                );
              }
            });
          }
        });
      });

      $('.btn-edit').click(function(e) {
        e.preventDefault();
        var id = $(this).data('id');
        var producto = $(this).data('producto');
        var marca = $(this).data('marca');
        var modelo = $(this).data('modelo');
        var precio = $(this).data('precio');
        var imagen = $(this).data('imagen');

        $('#editId').val(id);
        $('#editProducto').val(producto);
        $('#editMarca').val(marca);
        $('#editModelo').val(modelo);
        $('#editPrecio').val(precio);
        $('#currentImage').attr('src', 'data:image/png;base64, ' + imagen);

        var myModal = new bootstrap.Modal(document.getElementById('exampleModal'));
        myModal.show();
      });
    });
  </script>
</body>
</html>
