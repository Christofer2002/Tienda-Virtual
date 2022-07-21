<?php
require '../config/config.php';
require '../config/database.php';
$db = new Database();
$conn = $db->connect();

$id = isset($_GET['id']) ? $_GET['id'] : '';
$token = isset($_GET['token']) ? $_GET['token'] : '';
if ($id == '' || $token == '') {
  echo 'Error al procesar la petición';
  exit;
} else {
  $token_tmp = hash_hmac('sha1', $id, KEY_TOKEN);

  if ($token == $token_tmp) {
    $sql = $conn->prepare("SELECT count(id) FROM productos WHERE id = ? AND activo = 1 LIMIT 1");
    $sql->execute([$id]);
    if ($sql->fetchColumn() > 0) {
      $sql = $conn->prepare("SELECT nombre, descripcion, precio, descuento FROM productos WHERE id = ? AND activo = 1");
      $sql->execute([$id]);
      $row = $sql->fetch(PDO::FETCH_ASSOC);
      $nombre = $row['nombre'];
      $descripcion = $row['descripcion'];
      $precio = $row['precio'];
      $descuento = $row['descuento'];
      $precio_descuento = $precio - (($precio * $descuento) / 100);
      $dir_img = '../img/productos/' . $id . '/';

      $rutaImg = $dir_img . 'camisa.jpg';

      if (!file_exists($rutaImg)) {
        $rutaImg = '../img/no-photo.jpg';
      }

      $imagenes = array();
      if (file_exists($dir_img)) {
        $dir = dir($dir_img);

        while (($archivo = $dir->read()) != false) {
          if ($archivo != 'camisa.jpg' && (strpos($archivo, '.jpg') || strpos($archivo, 'jpeg'))) {
            $imagenes[] = $dir_img . $archivo;
          }
        }
        $dir->close();
      }
    }
  } else {
    echo 'Error al procesar la petición';
    exit;
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
  <link rel="preload" href="../css/modal.css" as="style">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.css" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
</head>

<body>
  <header>
    <section class="titulo">
      <h1 class="titulo__bienvenido">Detalles del producto</h1>
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
                <a class="nav-link dropdown-toggle container__fluid--activo" href="#" id="navbarScrollingDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                  Comprar
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
                  <li>
                    <hr class="dropdown-divider">
                  </li>
                  <li><a class="dropdown-item" href="#">
                      <h3 class="carrito">
                        Ver carrito <span id="num_cart" class="badge btn-success"><?php echo $num_cart ?></span>
                      </h3>
                    </a></li>
                </ul>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="../html/sobre nosotros.html">Sobre Nosotros</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="../html/contactanos.html">Contactanos</a>
              </li>
            </ul>
            <form class="d-flex">
              <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
              <button class="btn btn-outline-success" type="submit">Search</button>
            </form>
          </div>
        </div>
      </nav>
    </section>
  </header>
  <main>
    <div class="container mx-auto">
      <div class="row">
        <div class="col-md-6 order-md-1 centrar">
          <div id="carouselImages" class="carousel carousel-dark slide" data-bs-ride="carousel">
            <div class="carousel-inner">
              <div class="carousel-item active" data-bs-interval="10000">
                <section class="section__detalle"><img src="<?php echo $rutaImg ?>" alt="imagen producto"></section>
              </div>
              <?php foreach ($imagenes as $img) { ?>
                <div class="carousel-item" data-bs-interval="10000">
                  <section class="section__detalle"><img src="<?php echo $img ?>" alt="imagen producto"></section>
                </div>
              <?php } ?>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselImages" data-bs-slide="prev">
              <span class="carousel-control-prev-icon" aria-hidden="true"></span>
              <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselImages" data-bs-slide="next">
              <span class="carousel-control-next-icon" aria-hidden="true"></span>
              <span class="visually-hidden">Next</span>
            </button>
          </div>
        </div>
        <div class="col-md-6 order-md-2">
          <section class="subtitulo">
            <h1 class="subtitulo__productos"><?php echo $nombre ?></h1>
          </section>

          <?php if ($descuento > 0) { ?>
            <section class="precio__sub">
              <p><?php echo MONEDA . ' ' . number_format($precio, 2, '.', ','); ?></p>
            </section>
            <p class="precio">
              <?php echo MONEDA . ' ' . number_format($precio_descuento, 2, '.', ','); ?>
              <small class="text-success"><?php echo $descuento ?>% descuento</small>
            </p>
          <?php } else { ?>
            <p class="precio"><?php echo MONEDA . ' ' . number_format($precio, 2, '.', ','); ?></p>
          <?php } ?>
          <p class="lead">
            <?php echo $descripcion ?>
          </p>
          <div class="d-grid gap-3 col-10 mx-auto">
            <button class="btn btn-primary" type="button">Comprar ahora</button>
            <button class="btn btn-outline-success" type="button" onclick="addProducto(<?php echo $id; ?>, '<?php echo $token_tmp; ?>')">Agregar al carrito</button>
          </div>
          <br><br>
        </div>
      </div>
    </div>
    <footer class="footer">
      <p class="footer__texto">Tienda DyD - Todos los derechos reservados 2022</p>
    </footer>
  </main>
  <script src="../js/compra.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>

</html>