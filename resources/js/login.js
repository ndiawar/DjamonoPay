import './bootstrap';

// Toggle pour afficher/masquer le mot de passe
function togglePasswordVisibility() {
    const passwordInput = document.querySelector('input[name="password"]');
    const passwordIcon = document.querySelector('.toggle-password');
    if (passwordInput.type === "password") {
        passwordInput.type = "text";
        passwordIcon.classList.remove('bi-eye');
        passwordIcon.classList.add('bi-eye-slash');
    } else {
        passwordInput.type = "password";
        passwordIcon.classList.remove('bi-eye-slash');
        passwordIcon.classList.add('bi-eye');
    }
}

// Validation en temps réel
document.addEventListener('DOMContentLoaded', function () {
    const emailInput = document.querySelector('input[name="email"]');
    const passwordInput = document.querySelector('input[name="password"]'); // Modification ici

    const emailMessage = document.createElement('div');
    const passwordMessage = document.createElement('div');

    emailInput.parentElement.appendChild(emailMessage);
    passwordInput.parentElement.appendChild(passwordMessage);

    emailInput.addEventListener('input', function () {
        const emailValue = emailInput.value;
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/; // Regex pour valider l'email

        if (emailRegex.test(emailValue)) {
            emailMessage.textContent = 'Email valide';
            emailMessage.className = 'text-green-500'; // Classe pour le message de succès
        } else {
            emailMessage.textContent = 'Email invalide';
            emailMessage.className = 'text-red-500'; // Classe pour le message d'erreur
        }
    });

    passwordInput.addEventListener('input', function () {
        const passwordValue = passwordInput.value;

        if (passwordValue.length >= 6) {
            passwordMessage.textContent = 'Mot de passe valide';
            passwordMessage.className = 'text-green-500'; // Classe pour le message de succès
        } else {
            passwordMessage.textContent = 'Le mot de passe doit contenir au moins 6 caractères';
            passwordMessage.className = 'text-red-500'; // Classe pour le message d'erreur
        }
    });
});
