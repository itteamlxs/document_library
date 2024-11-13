// disable_keys.js

// Deshabilitar la tecla F12
document.addEventListener("keydown", function (event) {
    if (event.key === "F12") {
        event.preventDefault();
    }
});

// Deshabilitar el clic derecho
document.addEventListener("contextmenu", function (event) {
    event.preventDefault();
});
