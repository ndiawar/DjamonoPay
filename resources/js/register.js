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
    const registerButton = document.getElementById('registerButton'); // Remplacez par l'ID de votre bouton de soumission

    // Validation en temps réel
    form.addEventListener('input', function(event) {
        const target = event.target;
        const errorMessageElement = document.getElementById(`${target.name}Error`);
        let isValid = true;
        
        // Réinitialiser le message d'erreur
        errorMessageElement.textContent = '';
        target.classList.remove('valid', 'invalid');

        if (target.name === 'nom' || target.name === 'prenom') {
            const regex = /^[A-Z][a-zA-Z]*(\s[A-Z][a-zA-Z]*)*$/; // Commence par une majuscule, suivi de lettres (plusieurs mots possibles)
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
            const regex = /^\d{9}$/; // Numéro de téléphone doit contenir exactement 9 chiffres
            if (!regex.test(target.value)) {
                isValid = false;
                errorMessageElement.textContent = 'Numéro de téléphone invalide (exactement 9 chiffres).';
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
            const regex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{8,}$/; // Au moins 8 caractères, une majuscule, une minuscule, un chiffre et un caractère spécial
            if (!regex.test(target.value)) {
                isValid = false;
                errorMessageElement.textContent = 'Doit contenir au moins 8 caractères, une majuscule, une minuscule, un chiffre et un caractère spécial.';
            }
        }

        if (target.name === 'numero_identite') {
            const regex = /^\d{9}$/; // Exactement 9 chiffres
            if (!regex.test(target.value)) {
                isValid = false;
                errorMessageElement.textContent = 'Le numéro d\'identité doit contenir exactement 9 chiffres.';
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

        // Vérifier si le formulaire est valide et activer/désactiver le bouton d'enregistrement
        const allInputsValid = Array.from(form.elements).every(input => {
            return input.classList.contains('valid') || input.type === 'submit';
        });

        registerButton.disabled = !allInputsValid; // Activer ou désactiver le bouton d'enregistrement
    });
});
