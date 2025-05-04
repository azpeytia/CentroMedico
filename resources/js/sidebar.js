$(document).ready(function () {
    $('.sidebar .nav-item > .nav-link').on('click', function (e) {
        e.preventDefault(); // Evita el comportamiento predeterminado del enlace
        const parent = $(this).parent('.nav-item');

        // Alternar la clase 'menu-open' en el elemento padre
        if (parent.hasClass('menu-open')) {
            parent.removeClass('menu-open');
            parent.find('.nav-treeview').slideUp(); // Ocultar submenús
        } else {
            parent.addClass('menu-open');
            parent.find('.nav-treeview').slideDown(); // Mostrar submenús
        }
    });
});