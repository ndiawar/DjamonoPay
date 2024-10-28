document.addEventListener("DOMContentLoaded", function () {
    const form = document.getElementById("registrationForm");
    const nomInput = document.querySelector("input[name='nom']");
    const prenomInput = document.querySelector("input[name='prenom']");
    const emailInput = document.querySelector("input[name='email']");
    const telephoneInput = document.querySelector("input[name='telephone']");
    const adresseInput = document.querySelector("input[name='adresse']");
    const dateNaissanceInput = document.querySelector("input[name='date_naissance']");
    const passwordInput = document.querySelector("input[name='password']");
    const numeroIdentiteInput = document.querySelector("input[name='numero_identite']");

    const nomError = document.getElementById("nomError");
    const prenomError = document.getElementById("prenomError");
    const emailError = document.getElementById("emailError");
    const telephoneError = document.getElementById("telephoneError");
    const adresseError = document.getElementById("adresseError");
    const dateNaissanceError = document.getElementById("dateNaissanceError");
    const passwordError = document.getElementById("passwordError");
    const numeroIdentiteError = document.getElementById("numeroIdentiteError");

    // Fonction pour afficher les messages d'erreur
    function showError(input, errorMessage, errorElement) {
        if (!input.validity.valid) {
            errorElement.textContent = errorMessage;
            errorElement.style.display = 'block';
        } else {
            errorElement.style.display = 'none';
        }
    }

    document.addEventListener('DOMContentLoaded', function () {
        const modal = document.getElementById('successModal');
        const closeButton = document.querySelector('.modal-content .close');
    
        // Fermer le modal au clic sur la croix
        closeButton.onclick = function () {
            modal.style.display = 'none';
        };
    
        // Fermer le modal si on clique en dehors de celui-ci
        window.onclick = function (event) {
            if (event.target === modal) {
                modal.style.display = 'none';
            }
        };
    
        // Vérifier si l'inscription a réussi (simuler ici avec un paramètre de requête)
        const urlParams = new URLSearchParams(window.location.search);
        if (urlParams.get('success') === 'true') {
            modal.style.display = 'flex'; // Afficher le modal
        }
    });
    

    // Validation en temps réel
    nomInput.addEventListener("input", () => {
        showError(nomInput, "Le nom doit contenir uniquement des lettres sans espaces ni chiffres.", nomError);
    });

    prenomInput.addEventListener("input", () => {
        showError(prenomInput, "Le prénom peut contenir jusqu'à trois mots avec des lettres uniquement, séparés par des espaces.", prenomError);
    });

    emailInput.addEventListener("input", () => {
        showError(emailInput, "Veuillez entrer une adresse e-mail valide.", emailError);
    });

    telephoneInput.addEventListener("input", () => {
        showError(telephoneInput, "Le numéro de téléphone doit être un numéro valide de 9 chiffres.", telephoneError);
    });

    adresseInput.addEventListener("input", () => {
        showError(adresseInput, "L'adresse est requise.", adresseError);
    });

    dateNaissanceInput.addEventListener("input", () => {
        if (!dateNaissanceInput.validity.valid) {
            dateNaissanceError.textContent = "La date de naissance est requise.";
            dateNaissanceError.style.display = 'block';
        } else {
            dateNaissanceError.style.display = 'none';
        }
    });

    passwordInput.addEventListener("input", () => {
        showError(passwordInput, "Le mot de passe doit comporter au moins 8 caractères, incluant une majuscule, un chiffre, et un caractère spécial.", passwordError);
    });

    numeroIdentiteInput.addEventListener("input", () => {
        showError(numeroIdentiteInput, "Le numéro de carte d'identité doit contenir exactement 14 chiffres.", numeroIdentiteError);
    });

    // Affichage/Masquage du mot de passe
    const togglePassword = document.getElementById("togglePassword");
    togglePassword.addEventListener("click", () => {
        const type = passwordInput.getAttribute("type") === "password" ? "text" : "password";
        passwordInput.setAttribute("type", type);
        this.classList.toggle("fa-eye-slash");
    });
});