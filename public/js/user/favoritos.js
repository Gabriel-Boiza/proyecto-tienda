document.addEventListener("DOMContentLoaded", function(event) {
    const favsBtn = document.getElementsByClassName('favoritos');

    
    Array.from(favsBtn).forEach(btn => {
        let producto = JSON.parse(btn.value);
        let productoId = 'productoFavs' + producto.id; //clave para el localstorage 

        if(localStorage.getItem(productoId)){
            btn.innerHTML = '<svg class="w-5 h-5" fill="currentColor" stroke="currentColor" viewBox="0 0 24 24"><path d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>';btn.innerHTML = '<svg class="w-5 h-5" fill="currentColor" stroke="currentColor" viewBox="0 0 24 24"><path d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>';
        }
        btn.addEventListener('click', function(event) {
            
            if (localStorage.getItem(productoId)) {
                localStorage.removeItem(productoId)
                btn.innerHTML = '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>';
            } else {
                localStorage.setItem(productoId, JSON.stringify(producto));
                btn.innerHTML = '<svg class="w-5 h-5" fill="currentColor" stroke="currentColor" viewBox="0 0 24 24"><path d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>';btn.innerHTML = '<svg class="w-5 h-5" fill="currentColor" stroke="currentColor" viewBox="0 0 24 24"><path d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>';
            }
        });
    });
});
