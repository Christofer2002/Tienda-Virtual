<?php
  require '../config/database.php';
  $db = new Database();
  $conn = $db->connect();

  $sql = $conn->prepare("SELECT id, nombre, precio FROM productos WHERE activo = 1");
  $sql->execute();
  $resultado = $sql->fetchAll(PDO::FETCH_ASSOC);
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
    <link rel="preload" href="../css/modal.css" as = "style">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
</head>
<body>
    <header>
        <section class="titulo">
            <h1 class="titulo__bienvenido">Ropa</h1>
        </section>
        <section>
            <nav class="navbar navbar-expand-lg navbar-light bg-light navbar-dark bg-dark">
                <div class="container-fluid">
                  <a class="navbar-brand tienda-marca" href="../index.php"><h3>Tienda DyD</h3></a>
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
                          <li><a class="dropdown-item" href="/php/ropa.php"><h3>Ropa</h3></a></li>
                          <li><a class="dropdown-item" href="#"><h3>Joyeria</h3></a></li>
                          <li><a class="dropdown-item" href="#"><h3>Cosas para el hogar</h3></a></li>
                          <li><hr class="dropdown-divider"></li>
                          <li><a class="dropdown-item" href="#"><h3>Ver carrito</h3></a></li>
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
    <main class="contenedor">
      <section class="subtitulo"><h1 class="subtitulo__productos">Nuestros Productos</h1></section>
      <div class="grid">
        <?php foreach($resultado as $row){?>
        <div class="shadow">
          <a href="producto.html">
            <?php
              $id = $row['id'];
              $imagen = "../img/productos/" .$id. "/camisa.jpg";

              if(!file_exists($imagen)){
                $imagen = "../img/no-photo.jpg";
              }
              ?>
              <img src="<?php echo $imagen; ?>">
            <!-- <img class="producto__imagen" src="../img/1.jpg" alt="imagen camisa"> -->
            <div class="producto__informacion">
              <p class="producto__descripcion"><?php echo $row['nombre']; ?></p>
              <p class="producto__precio">$ <?php echo number_format($row['precio'], 2, '.', ','); ?></p>
            </div>
          </a>
          <div class="d-flex justify-content-between">
            <div class="btn-group">
              <a href="" class="btn btn-primary" >Detalles</a>
            </div>
              <a href="" class="btn btn-success" >Agregar al Carrito</a>
          </div>   
        </div>
        <?php } ?>
      </div>
        <footer class="footer">
        <p class="footer__texto">Tienda DyD - Todos los derechos reservados 2022</p>
        </footer>
    </main>
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>
</html>