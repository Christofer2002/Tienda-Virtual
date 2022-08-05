<?php
require '../config/config.php';
require '../config/database.php';
$db = new Database();
$conn = $db->connect();

$productos = isset($_SESSION['carrito']['productos']) ? $_SESSION['carrito']['productos'] : null;
$lista_carrito = array();


$cambio_dolar = 620;

if ($productos != null) {
    foreach ($productos as $clave => $cantidad) {
        $sql = $conn->prepare("SELECT id, nombre, precio, descuento, $cantidad as cantidad FROM ropa WHERE id=? AND activo = 1");
        $sql->execute([$clave]);
        $lista_carrito[] = $sql->fetch(PDO::FETCH_ASSOC);
    }
} else {
    header("Location: index.php");
    exit;
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
    <script src="https://www.paypal.com/sdk/js?client-id=<?php echo CLIENT_ID ?>&currency=<?php echo CURRENCY ?>"></script>
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
        <div class="row">
            <div class="col-6">
                <h2 class="detalles__pago">Detalles de Pago</h2>
                <br> <br>
                <div id="paypal-button-container"></div>
            </div>
            <div class="col-6">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Producto</th>
                                <th>Subtotal</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if ($lista_carrito == null) {
                                echo '<tr><td colspan="5" class="text-center"><b>Lista vacia</b></td></tr>';
                            } else {
                                $total = 0;
                                $total_dolar = 0;
                                foreach ($lista_carrito as $producto) {
                                    $_id = $producto['id'];
                                    $nombre = $producto['nombre'];
                                    $precio = $producto['precio'];
                                    $descuento = $producto['descuento'];
                                    $cantidad = $producto['cantidad'];
                                    $precio_desc = $precio - (($precio * $descuento) / 100);
                                    $subtotal = $cantidad * $precio_desc;
                                    $total += $subtotal;
                                    $total_dolar = $total / 620?>
                                    <tr>
                                        <td><?php echo $nombre ?></td>
                                        <td>
                                            <div id="subtotal_<?php echo $_id; ?>" name="subtotal[]">
                                                <?php echo MONEDA . ' ' . number_format($subtotal, 2, '.', ',') ?>
                                            </div>
                                        </td>
                                    </tr>
                                <?php } ?>
                                <tr>
                                    <td>
                                        <h4><b>TOTAL - COLONES</h4>
                                    </td>
                                    <td>
                                        <p><?php echo MONEDA . ' ' . number_format($total, 2, '.', ',') ?></p>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <h4><b>TOTAL - USD</h4>
                                    </td>
                                    <td>
                                        <p> <?php echo MONEDA_USD . ' ' . number_format($total_dolar, 2, '.', ',') ?></p>
                                    </td>
                                </tr>
                        </tbody>
                    <?php } ?>
                    </table>
                </div>
                <br> <br>
                <footer class="footer">
                    <p class="footer__texto">Tienda DyD - Todos los derechos reservados 2022</p>
                </footer>
            </div>
        </div>
    </main>
    <script>
        paypal.Buttons({
            style: {
                color: 'blue',
                shape: 'pill',
                label: 'pay',
            },
            // Sets up the transaction when a payment button is clicked
            createOrder: (data, actions) => {
                return actions.order.create({
                    purchase_units: [{
                        amount: {
                            value: <?php echo number_format($total_dolar, 2, '.', ',') ?> // Can also reference a variable or function
                        }
                    }]
                });
            },
            onCancel: function(data) {
                alert("Pago Cancelado");
                console.log(data);
            },
            // Finalize the transaction after payer approval
            onApprove: (data, actions) => {
                let url = '../php/captura.php'
                return actions.order.capture().then(function(orderData) {
                    // Successful capture! For dev/demo purposes:
                    window.location.href = "../html/completado.html"
                    console.log('Capture result', orderData, JSON.stringify(orderData, null, 2));
                    const transaction = orderData.purchase_units[0].payments.captures[0];
                    alert(`Transaction ${transaction.status}: ${transaction.id}\n\nSee console for all available details`);
                    // When ready to go live, remove the alert and show a success message within this page. For example:
                    // const element = document.getElementById('paypal-button-container');
                    // element.innerHTML = '<h3>Thank you for your payment!</h3>';
                    // Or go to another URL:  actions.redirect('thank_you.html');
                });
            }
        }).render('#paypal-button-container');
    </script>
    <script src="../js/compra.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.0.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
</body>

</html>