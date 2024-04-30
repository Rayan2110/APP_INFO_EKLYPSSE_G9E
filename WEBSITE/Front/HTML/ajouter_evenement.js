document.addEventListener("DOMContentLoaded", function() {
    const form = document.querySelector("form");
    
    form.addEventListener("submit", function(event) {
        event.preventDefault();
        
        const nom = document.getElementById('nom').value.trim();
        const localisation = document.getElementById('localisation').value.trim();
        const date_debut = new Date(document.getElementById('date_debut').value);
        const date_fin = new Date(document.getElementById('date_fin').value);
        const prix = document.getElementById('prix').value;

        let errorMessage = '';

        if (!nom || !localisation || !date_debut || !date_fin || !prix) {
            errorMessage += 'Tous les champs doivent être remplis.\n';
        }

        if (date_debut > date_fin) {
            errorMessage += 'La date de début doit être avant la date de fin.\n';
        }

        if (prix <= 0) {
            errorMessage += 'Le prix doit être un nombre positif.\n';
        }

        if (errorMessage) {
            alert(errorMessage);
        } else {
            form.submit();
        }
    });
});
