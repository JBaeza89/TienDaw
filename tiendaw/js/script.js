function verDescripcion(id) {
    fetch(url_path +"/api/descripcion/" + id)
      .then((res) => res.json())
      .then((res) => {
        var nombre = document.getElementById("nombre");
        nombre.innerHTML = res.nombre;
        var descripcion = document.getElementById("descripcion");
        descripcion.innerHTML = res.descripcion;
        // Esto es jquery, copiado de la documentación de bootstrap.
        $('#articuloModal').modal('show'); // mostrar div oculto de manera modal. 
      });
  }

  function annadirCarrito(id, user) {
    fetch(url_path + "/api/carrito/" + user + "/" + id)
      .then((res) => res.json())
      .then((res) => {
        var carrito = document.getElementById("narticulos");
        carrito.innerText = res.cuenta;
        if (res.estabaAnnadido) {
          window.alert("Ya se encuentra en el carrito");
        } else {
          window.alert("Articulo añadido al carrito");
        }
    });
  }