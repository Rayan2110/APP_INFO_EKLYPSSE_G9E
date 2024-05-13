document.addEventListener('DOMContentLoaded', function() {
    // Récupérer les informations de l'utilisateur depuis PHP (pré-remplies dans le HTML)
    const pseudo = document.getElementById('pseudo').value;
    const nom = document.getElementById('nom').value;
    const date_naissance = document.getElementById('date_naissance').value;
    const email = document.getElementById('email').value;
    const mdp = document.getElementById('mdp').value;

    // Remplir les champs du formulaire avec les informations de l'utilisateur
    document.getElementById('pseudo').value = pseudo;
    document.getElementById('nom').value = nom;
    document.getElementById('date_naissance').value = date_naissance;
    document.getElementById('email').value = email;
    document.getElementById('mdp').value = mdp;
});
