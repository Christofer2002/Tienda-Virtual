<?php
require '../config/config.php';
require '../config/database.php';
$db = new Database();
$conn = $db->connect();

$productos = isset($_SESSION['carrito']['productos']) ? $_SESSION['carrito']['productos'] : null;
$lista_carrito = array();

if ($productos != null) {
  foreach ($productos as $clave => $cantidad) {
    $sql = $conn->prepare("SELECT id, nombre, precio, descuento, $cantidad as cantidad FROM ropa WHERE id=? AND activo = 1");
    $sql->execute([$clave]);
    $lista_carrito[] = $sql->fetch(PDO::FETCH_ASSOC);
  }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Ventas_DyD</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Staatliches&display=swap" rel="stylesheet">
  <link rel="preload" href="../css/normalize.css" as="style">
  <link rel="stylesheet" href="../css/normalize.css">
  <link rel="preload" href="../css/style.css" as="style">
  <link rel="stylesheet" href="../css/style.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
</head>

<body>
  <header>
    <section class="titulo">
      <h1 class="titulo__bienvenido">Carrito</h1>
    </section>
    <section>
      <nav class="navbar navbar-expand-lg navbar-light bg-light navbar-dark bg-dark">
        <div class="container-fluid">
          <a class="navbar-brand tienda-marca" href="../index.php">
            <h3>Tienda DyD</h3>
          </a>
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarScroll" aria-controls="navbarScroll" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarScroll">
            <ul class="navbar-nav me-auto my-2 my-lg-0 navbar-nav-scroll" style="--bs-scroll-height: 100px;">
              <li class="nav-item">
                <a class="nav-link" aria-current="page" href="../index.php">Inicio</a>
              </li>
              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle container__fluid--activo" id="navbarScrollingDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                  Catalogo
                </a>
                <ul class="dropdown-menu" aria-labelledby="navbarScrollingDropdown">
                  <li><a class="dropdown-item" href="../php/ropa.php">
                      <h3>Ropa</h3>
                    </a></li>
                  <li><a class="dropdown-item" href="#">
                      <h3>Joyeria</h3>
                    </a></li>
                  <li><a class="dropdown-item" href="#">
                      <h3>Cosas para el hogar</h3>
                    </a></li>
                  <!-- <li>
                    <hr class="dropdown-divider">
                  </li> -->
                  <!-- <li><a class="dropdown-item" href="#">
                      <h3 class="carrito">
                        Ver carrito <span id="num_cart" class="badge btn-success"><?php echo $num_cart ?></span>
                      </h3>
                    </a></li> -->
                </ul>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="../html/sobre nosotros.html">Sobre Nosotros</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="../html/contactanos.html">Contactanos</a>
              </li>
            </ul>
            <li class="d-flex">
              <a class="btn btn-primary" href="../php/carrito_compra.php">
                <h4>
                  Ver carrito <span id="num_cart" class="badge btn-success"><?php echo $num_cart ?></span>
                </h4>
              </a>
            </li>
            <!-- <form class="d-flex">
              <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
              <button class="btn btn-outline-success" type="submit">Search</button>
            </form> -->
          </div>
        </div>
      </nav>
    </section>
  </header>
  <main>
    <div class="table-responsive">
      <table class="table">
        <thead>
          <tr>
            <th>Producto</th>
            <th>Precio</th>
            <th>Cantidad</th>
            <th>Subtotal</th>
            <th></th>
          </tr>
        </thead>
        <tbody>
          <?php if ($lista_carrito == null) {
            echo '<tr><td colspan="5" class="text-center"><b>Lista vacia</b></td></tr>';
          } else {
            $total = 0;
            foreach ($lista_carrito as $producto) {
              $_id = $producto['id'];
              $nombre = $producto['nombre'];
              $precio = $producto['precio'];
              $descuento = $producto['descuento'];
              $cantidad = $producto['cantidad'];
              $precio_desc = $precio - (($precio * $descuento) / 100);
              $subtotal = $cantidad * $precio_desc;
              $total += $subtotal;
          ?>
              <tr>
                <td><?php echo $nombre ?></td>
                <td><?php echo MONEDA . ' ' . number_format($precio_desc, 2, '.', ',') ?></td>
                <td>
                  <input type="number" min="1" max="10" step="1" value="<?php echo $cantidad ?>" value="5" id="cantidad_<?php echo $_id; ?>" onchange="actualizaCantidad(this.value, <?php echo $_id; ?>)">
                </td>
                <td>
                  <div id="subtotal_<?php echo $_id; ?>" name="subtotal[]">
                    <?php echo MONEDA . ' ' . number_format($subtotal, 2, '.', ',') ?>
                  </div>
                </td>
                <td><a id="eliminar" class="btn btn-warning btn-sm" data-bs-id="<?php echo $_id; ?>" data-bs-toggle="modal" data-bs-target="#eliminaModal">Eliminar</a></td>
              </tr>
            <?php } ?>

            <tr>
              <td colspan="3"><h4> <b>TOTAL</h4></td>
              <td colspan="2">
                <p class="h3" id="total"><?php echo MONEDA . ' ' . number_format($total, 2, '.', ',') ?></p>
              </td>
            </tr>
        </tbody>
      <?php } ?>
      </table>
    </div>
    <?php if ($lista_carrito != null) { ?>
    <div class="row">
      <div class="col-md-5 offset-md-7 d-grid gap=2">
        <a href="../php/procesar_pago.php" class="btn btn-outline-primary btn-lg">Realizar Pago</a>
      </div>
    </div>
    <?php } ?>
    <br> <br>
    <footer class="footer">
      <p class="footer__texto">Tienda DyD - Todos los derechos reservados 2022</p>
    </footer>
  </main>
  <!-- Modal -->
  <div class="modal fade" id="eliminaModal" tabindex="-1" aria-labelledby="eliminaModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm">
      <div class="modal-content">
        <div class="modal-header">
          <h3 class="modal-title" id="eliminaModalLabel">Alerta</h3>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <p>¿Estas seguro de eliminar este producto?</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
          <button id="btn-elimina" type="button" class="btn btn-danger" onclick="elimina()">Eliminar</button>
        </div>
      </div>
    </div>
  </div>
  <script>
    let eliminaModal = document.getElementById('eliminaModal');
      eliminaModal.addEventListener('show.bs.modal', function(event) {
      let button = event.relatedTarget
      let id = button.getAttribute('data-bs-id')
      let buttonElimina = eliminaModal.querySelector('.modal-footer #btn-elimina')
      buttonElimina.value = id
    })

    function actualizaCantidad(cantidad, id) {
      let url = '../php/actualizar_carrito.php';
      let formData = new FormData();

      formData.append('action', 'agregar');
      formData.append('id', id);
      formData.append('cantidad', cantidad);

      fetch(url, {
          method: 'POST',
          body: formData,
          mode: 'cors'
        }).then(response => response.json())
        .then(data => {
          if (data.ok) {
            let divSubTotal = document.getElementById('subtotal_' + id);
            divSubTotal.innerHTML = data.sub;

            let total = 0.00
            let list = document.getElementsByName('subtotal[]');

            for (let i = 0; i < list.length; i++) {
              total += parseFloat(list[i].innerHTML.replace(/[¢,]/g, ''))
            }
            total = new Intl.NumberFormat('en-US', {
              minimumFractionDigits: 2
            }).format(total)
            document.getElementById('total').innerHTML = '<?php echo MONEDA; ?>' + total
          }
        })
    }

    function elimina() {
    let botonElimina = document.getElementById('btn-elimina');
    let id = botonElimina.value;


      let url = '../php/actualizar_carrito.php';
      let formData = new FormData();

      formData.append('action', 'eliminar');
      formData.append('id', id);

      fetch(url, {
          method: 'POST',
          body: formData,
          mode: 'cors'
        }).then(response => response.json())
        .then(data => {
          if (data.ok) {
            location.reload();
          }
        })
    }
  </script>
  <script src="../js/compra.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.0.0/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa" crossorigin="anonymous"></script>
  <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
</body>

</html>