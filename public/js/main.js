document.addEventListener('DOMContentLoaded', function () {

    const burgerButton = document.querySelector('.burger-menu');
    const menu = document.querySelector('.menu');

    burgerButton.addEventListener('click', function () {
        menu.classList.toggle('active');
    });
    const deroulantItem = document.querySelector('.deroulant');

deroulantItem.addEventListener('click', function () {
    deroulantItem.classList.toggle('ouvert');
});

//animation page
let loadingSpinner = document.getElementById('chargement');
    let body = document.querySelector('body');

    document.querySelectorAll('a').forEach(function(anchor) {
        anchor.addEventListener('click', function(e) {
            e.preventDefault();

            let targetUrl = this.href;

            loadingSpinner.style.display = 'block'; // Affichez l'effet de chargement au début de la transition
            body.style.opacity = 0; // Réduisez l'opacité de la page

            setTimeout(function() {
                window.location = targetUrl; // Redirigez vers la nouvelle page
            }, 500); // Délai pour l'animation (0.5 seconde dans cet exemple)
        });
    });

});