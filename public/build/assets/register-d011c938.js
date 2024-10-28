document.addEventListener("DOMContentLoaded",function(){document.getElementById("registrationForm");const d=document.querySelector("input[name='nom']"),a=document.querySelector("input[name='prenom']"),c=document.querySelector("input[name='email']"),i=document.querySelector("input[name='telephone']"),u=document.querySelector("input[name='adresse']"),l=document.querySelector("input[name='date_naissance']"),n=document.querySelector("input[name='password']"),m=document.querySelector("input[name='numero_identite']"),p=document.getElementById("nomError"),y=document.getElementById("prenomError"),E=document.getElementById("emailError"),g=document.getElementById("telephoneError"),I=document.getElementById("adresseError"),r=document.getElementById("dateNaissanceError"),L=document.getElementById("passwordError"),f=document.getElementById("numeroIdentiteError");function t(e,s,o){e.validity.valid?o.style.display="none":(o.textContent=s,o.style.display="block")}document.addEventListener("DOMContentLoaded",function(){const e=document.getElementById("successModal"),s=document.querySelector(".modal-content .close");s.onclick=function(){e.style.display="none"},window.onclick=function(v){v.target===e&&(e.style.display="none")},new URLSearchParams(window.location.search).get("success")==="true"&&(e.style.display="flex")}),d.addEventListener("input",()=>{t(d,"Le nom doit contenir uniquement des lettres sans espaces ni chiffres.",p)}),a.addEventListener("input",()=>{t(a,"Le prénom peut contenir jusqu'à trois mots avec des lettres uniquement, séparés par des espaces.",y)}),c.addEventListener("input",()=>{t(c,"Veuillez entrer une adresse e-mail valide.",E)}),i.addEventListener("input",()=>{t(i,"Le numéro de téléphone doit être un numéro valide de 9 chiffres.",g)}),u.addEventListener("input",()=>{t(u,"L'adresse est requise.",I)}),l.addEventListener("input",()=>{l.validity.valid?r.style.display="none":(r.textContent="La date de naissance est requise.",r.style.display="block")}),n.addEventListener("input",()=>{t(n,"Le mot de passe doit comporter au moins 8 caractères, incluant une majuscule, un chiffre, et un caractère spécial.",L)}),m.addEventListener("input",()=>{t(m,"Le numéro de carte d'identité doit contenir exactement 14 chiffres.",f)}),document.getElementById("togglePassword").addEventListener("click",()=>{const e=n.getAttribute("type")==="password"?"text":"password";n.setAttribute("type",e),this.classList.toggle("fa-eye-slash")})});
