document.addEventListener("DOMContentLoaded", () => {
    const form = document.getElementById("loginForm");
    const correo = document.getElementById("correo");
    const contrasena = document.getElementById("contrasena");
    const toggleBtn = document.getElementById("togglePassword");
    const alertContainer = document.getElementById("alertContainer");

    const mostrarAlerta = (mensaje, tipo = "danger") => {
        alertContainer.innerHTML = `
            <div class="alert alert-${tipo} alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-circle me-2"></i> ${mensaje}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
            </div>
        `;
    };

    form.addEventListener("submit", function (e) {
        const correoVal = correo.value.trim();
        const contrasenaVal = contrasena.value.trim();
        alertContainer.innerHTML = ""; // Limpiar alertas previas

        // Validar correo institucional
        const regex = /^[a-zA-Z0-9._%+-]+@(alumno\.)?uaemex\.mx$/;
        if (!regex.test(correoVal)) {
            mostrarAlerta("El correo debe ser institucional (@uaemex.mx o @alumno.uaemex.mx)");
            correo.focus();
            e.preventDefault();
            return;
        }

        // Validar longitud de contraseña
        if (contrasenaVal.length < 6) {
            mostrarAlerta("La contraseña debe tener al menos 6 caracteres.");
            contrasena.focus();
            e.preventDefault();
        }
    });

    // Mostrar/ocultar contraseña
    if (toggleBtn && contrasena) {
        toggleBtn.addEventListener("click", () => {
            const type = contrasena.type === "password" ? "text" : "password";
            contrasena.type = type;
            const icon = toggleBtn.querySelector("i");

            icon.classList.toggle("bi-eye-fill");
            icon.classList.toggle("bi-eye-slash-fill");
        });
    }
});
