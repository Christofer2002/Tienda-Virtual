<?php
    define("CLIENT_ID", "AatFhMs7fI1NvC7C3i6H9K_ELVBELaEOolaaVM2CsfV-mnRT4lmMzL3w5LR9DY01Yz7Lu8wbzGrAJSHj");
    define("CURRENCY", "USD");
    define("KEY_TOKEN", "CDC,cdc-2002*");
    define("MONEDA", '¢');
    define("MONEDA_USD", '$');
    session_start();

    $num_cart = 0;
    if(isset($_SESSION['carrito']['productos'])){
        $num_cart = count($_SESSION['carrito']['productos']);
    }
?>