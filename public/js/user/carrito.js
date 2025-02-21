document.addEventListener("DOMContentLoaded", function(event) {

    const carritoBtn = document.getElementsByClassName('carrito');
    

    Array.from(carritoBtn).forEach(btn => {
        btn.addEventListener('click', function(event){
            let producto = JSON.parse(btn.value);
            console.log(producto.id);
            localStorage.setItem('producto'+producto.id, producto) 

            console.log(localStorage)
        });
    });
});
