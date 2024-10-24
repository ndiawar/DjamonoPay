import './bootstrap';

// Toggle pour afficher/masquer le mot de passe
const togglePassword = document.getElementById('togglePassword');
const passwordInput = document.getElementById('password');

if (togglePassword) {
    togglePassword.addEventListener('click', function () {
        const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
        passwordInput.setAttribute('type', type);

        // Changer l'icône en fonction de l'état
        this.classList.toggle('fa-eye-slash');
    });
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
