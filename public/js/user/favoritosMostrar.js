document.addEventListener("DOMContentLoaded", function(event) {
    const favsBtn = document.getElementsByClassName('favoritosMostrar');

    
    Array.from(favsBtn).forEach(btn => {
        let producto = JSON.parse(btn.value);
        let productoId = 'productoFavs' + producto.id; //clave para el localstorage 

        if(localStorage.getItem(productoId)){
            btn.textContent = "Quitar de favoritos"        
        }
        btn.addEventListener('click', function(event) {
            
            if (localStorage.getItem(productoId)) {
                localStorage.removeItem(productoId)
                btn.textContent = "Añadir a favoritos"
            } else {
                localStorage.setItem(productoId, JSON.stringify(producto));
                btn.textContent = "Quitar de favoritos"
            }
        });
    });
});
