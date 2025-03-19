document.addEventListener('DOMContentLoaded', function() {
    const updateForm = document.getElementById('updateForm');
  
    updateForm.addEventListener('submit', function(event) {
      event.preventDefault(); // Empêche le formulaire de soumettre normalement
  
      // Récupère les valeurs du formulaire
      const nom = document.getElementById('nom').value;
      const prenom = document.getElementById('prenom').value;
      const email = document.getElementById('email').value;
      const matiere = document.getElementById('matiere').value;
      const dateNaissance = document.getElementById('dateNaissance').value;
      const adresse = document.getElementById('adresse').value;
  
      // Effectuer ici la logique de mise à jour du profil, par exemple :
      // Envoyer les données à un serveur via une requête AJAX ou effectuer une mise à jour locale
      
      // Affiche une confirmation à l'utilisateur
      alert('Profil mis à jour avec succès !');
      
      // Réinitialise le formulaire
      updateForm.reset();
    });
  });
  