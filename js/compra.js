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