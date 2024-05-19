document.addEventListener("DOMContentLoaded", function () {
  eventListeners();
  darkMode();
});

function darkMode() {
  const prefieroDarkMode = window.matchMedia("(prefers-color-scheme:dark)");

  //condole.log(prefiereDarkMode.matches);
  if (prefieroDarkMode.matches) {
    document.body.classList.add("dark-mode");
  } else {
    document.body.classList.remove("dark-mode");
  }

  prefieroDarkMode.addEventListener("change", function () {
    if (prefieroDarkMode.matches) {
      document.body.classList.add("dark-mode");
    } else {
      document.body.classList.remove("dark-mode");
    }
  });

  const botonDarkMode = document.querySelector(".dark-mode-boton");

  botonDarkMode.addEventListener("click", function () {
    document.body.classList.toggle("dark-mode");
  });
}

function eventListeners() {
  const mobileMenu = document.querySelector(".mobile-menu");

  mobileMenu.addEventListener("click", navegacionResponsive);

  //Muestra campos condicionales
  const metodoContacto = document.querySelectorAll(
    'input[name="contacto[contacto]" ]'
  );

  metodoContacto.forEach((input) =>
    input.addEventListener("click", mostrarMetodosContacto)
  );
}

function navegacionResponsive() {
  const navegacion = document.querySelector(".navegacion");
  navegacion.classList.toggle("mostrar");
}

function mostrarMetodosContacto(e) {
  const contactoDiv = document.querySelector("#contacto");
  if (e.target.value === "telefono") {
    contactoDiv.innerHTML = `
            <label for= "telefono"> Número Teléfono</label>
             <input type="tel" placeholder="Tu Teléfono" id="telefono"  name="contacto[telefono]">
             <p> Elija la fecha y la hora</p>

             <label for="fecha">Fecha:</label>
            <input  type="date" id="fecha" name="contacto[fecha]">
            <label for="hora">Hora:</label>
            <input type="time" id="hora" name="contacto[hora]">
             
             `;
  } else {
    contactoDiv.innerHTML = ` 
           <label for="email">E-mail</label>
           <input type="email" placeholder="Tu Email" id="email"  name="contacto[email]" required> 

    `;
  }
}
