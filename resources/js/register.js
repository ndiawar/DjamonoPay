document.addEventListener('DOMContentLoaded', function() {
    const togglePassword = document.getElementById('togglePassword');
    const passwordInput = document.getElementById('password');
    
    togglePassword.addEventListener('click', function() {
        const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
        passwordInput.setAttribute('type', type);
        this.classList.toggle('fa-eye');
        this.classList.toggle('fa-eye-slash');
    });

    const form = document.getElementById('registrationForm');
    
    // Validation en temps réel
    form.addEventListener('input', function(event) {
        const target = event.target;
        const errorMessageElement = document.getElementById(`${target.name}Error`);
        let isValid = true;
        
        // Réinitialiser le message d'erreur
        errorMessageElement.textContent = '';
        target.classList.remove('valid', 'invalid');

        if (target.name === 'nom' || target.name === 'prenom') {
            const regex = /^[A-Z][a-zA-Z]*$/; // Commence par une majuscule, suivi de lettres
            if (!regex.test(target.value)) {
                isValid = false;
                errorMessageElement.textContent = 'Doit commencer par une majuscule et ne contenir que des lettres.';
            }
        }

        if (target.name === 'email') {
            const regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/; // Regex pour l'email
            if (!regex.test(target.value)) {
                isValid = false;
                errorMessageElement.textContent = 'Adresse e-mail invalide.';
            }
        }

        if (target.name === 'telephone') {
            const regex = /^\+?[0-9]{10,15}$/; // Numéro de téléphone (ajustez selon vos besoins)
            if (!regex.test(target.value)) {
                isValid = false;
                errorMessageElement.textContent = 'Numéro de téléphone invalide.';
            }
        }

        if (target.name === 'adresse') {
            if (target.value.trim() === '') {
                isValid = false;
                errorMessageElement.textContent = 'L\'adresse ne peut pas être vide.';
            }
        }

        if (target.name === 'date_naissance') {
            const birthDate = new Date(target.value);
            const today = new Date();
            if (birthDate >= today) {
                isValid = false;
                errorMessageElement.textContent = 'La date de naissance doit être dans le passé.';
            }
        }

        if (target.name === 'password') {
            const regex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[A-Za-z\d]{8,}$/; // Au moins 8 caractères, une majuscule, une minuscule et un chiffre
            if (!regex.test(target.value)) {
                isValid = false;
                errorMessageElement.textContent = 'Doit contenir au moins 8 caractères, une majuscule, une minuscule et un chiffre.';
            }
        }

        if (target.name === 'numero_identite') {
            if (target.value.trim() === '') {
                isValid = false;
                errorMessageElement.textContent = 'Le numéro de carte d\'identité ne peut pas être vide.';
            }
        }

        if (target.name === 'role') {
            if (target.value.trim() === '') {
                isValid = false;
                errorMessageElement.textContent = 'Veuillez choisir un rôle.';
            }
        }

        // Ajouter les classes de validation
        if (isValid) {
            target.classList.add('valid');
            target.classList.remove('invalid');
        } else {
            target.classList.add('invalid');
            target.classList.remove('valid');
        }
    });
});
