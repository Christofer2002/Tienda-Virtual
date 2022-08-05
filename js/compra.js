function addProducto(id, token) {
    let url = '../php/carrito.php';
    let formData = new FormData();

    formData.append('id', id);
    formData.append('token', token);

    fetch(url, {
        method: 'POST',
        body: formData,
        mode: 'cors'
    }).then(Response => Response.json())

    .then(data => {
        if (data.ok) {
            let elemento = document.getElementById("num_cart");
            elemento.innerHTML = data.numero;
    }
    });
}

/* function actualizaCantidad(cantidad, id) {
    let url = '../php/actualizar_carrito.php';
    let formData = new FormData();

    formData.append('action', 'agregar');
    formData.append('id', id);
    formData.append('cantidad', cantidad);

    fetch(url, {
        method: 'POST',
        body: formData,
        mode: 'cors'
    }).then(Response => Response.json())

    .then(data => {
        if (data.ok) {
            let divSubTotal = document.getElementById("subtotal_" + id);
            divSubTotal.innerHTML = data.sub;
    }
    });
} */


