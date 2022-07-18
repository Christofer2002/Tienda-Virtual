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
  <link rel="preload" href="./css/normalize.css" as="style">
  <link rel="stylesheet" href="/css/normalize.css">
  <link rel="preload" href="./css/style.css" as="style">
  <link rel="stylesheet" type="text/css" href="./css/style.css">
  <link rel="stylesheet" href="./css/bootstrap-min.css" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>

<body class="body__img">
  <header>
    <section class="titulo">
      <h1 class="titulo__bienvenido">Bienvenido a tienda virtual DyD</h1>
    </section>
    <section>
      <nav class="navbar navbar-expand-lg navbar-light bg-light navbar-dark bg-dark">
        <div class="container-fluid">
          <a class="navbar-brand tienda-marca" href="index.php">
            <h3>Tienda DyD</h3>
          </a>
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarScroll" aria-controls="navbarScroll" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarScroll">
            <ul class="navbar-nav me-auto my-2 my-lg-0 navbar-nav-scroll" style="--bs-scroll-height: 100px;">
              <li class="nav-item">
                <a class="nav-link container__fluid--activo" aria-current="page" href="../index.php">Inicio</a>
              </li>
              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarScrollingDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                  Comprar
                </a>
                <ul class="dropdown-menu" aria-labelledby="navbarScrollingDropdown">
                  <li><a class="dropdown-item" href="./php/ropa.php">
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
                      <h3>Ver carrito</h3>
                    </a></li>
                </ul>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="./html/sobre nosotros.html">Sobre Nosotros</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="./html/contactanos.html">Contactanos</a>
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
    <footer class="footer">
      <p class="footer__texto">Tienda DyD - Todos los derechos reservados 2022</p>
    </footer>
  </main>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
</body>

</html>