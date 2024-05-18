document.addEventListener('DOMContentLoaded', function () {
    eventListeners();
    darkMode();

});

function darkMode() { 

    const prefieroDarkMode = window.matchMedia("(prefers-color-scheme:dark)");

    //condole.log(prefiereDarkMode.matches);
    if (prefieroDarkMode.matches) { 
        document.body.classList.add('dark-mode');
    } else {
        document.body.classList.remove("dark-mode");
    }

    prefieroDarkMode.addEventListener('change', function () {
        if (prefieroDarkMode.matches) {
            document.body.classList.add("dark-mode");
        } else {
            document.body.classList.remove("dark-mode");
        }

    });

    const botonDarkMode = document.querySelector('.dark-mode-boton');

    botonDarkMode.addEventListener('click', function () {
        document.body.classList.toggle('dark-mode');

    });

}

function eventListeners() {
    const mobileMenu = document.querySelector('.mobile-menu');

    mobileMenu.addEventListener('click', navegacionResponsive);
}

function navegacionResponsive() {
    const navegacion = document.querySelector('.navegacion');
    navegacion.classList.toggle('mostrar')
   
}