function scrollToTop() {
  window.scrollTo({
    top: 0,
    behavior: "smooth" // Pour un défilement en douceur
  });
}

// Affiche/masque le bouton en fonction de la position de défilement
window.addEventListener("scroll", function () {
  var backToTopBtn = document.getElementById("back-to-top-btn");

  if (window.pageYOffset > 100) { // Vous pouvez ajuster cette valeur selon votre préférence
    backToTopBtn.style.display = "block";
  } else {
    backToTopBtn.style.display = "none";
  }
});
// Affiche la barre de recherche
function showSearchBar() {
    var searchBar = document.getElementById('search-bar-container');
    searchBar.style.display = 'flex';
    window.addEventListener('click', closeSearchBar, true);
  }
  
  // Ferme la barre de recherche si on clique en dehors
  function closeSearchBar(event) {
    var searchBar = document.getElementById('search-bar-container');
    // Vérifie si le clic est en dehors de la barre de recherche
    if (!searchBar.contains(event.target)) {
      searchBar.style.display = 'none';
      window.removeEventListener('click', closeSearchBar, true); // Nettoie l'écouteur
    }
  }
  
  // Empêche la propagation du clic à l'intérieur de la barre de recherche au document
  document.getElementById('search-bar-container').addEventListener('click', function(event) {
    event.stopPropagation();
  });
  
  // Gère la soumission de la recherche
  function submitSearch() {
    var searchQuery = document.getElementById('search-input').value;
    console.log('Recherche pour:', searchQuery); // Remplacer par votre logique de recherche
    document.getElementById('search-bar-container').style.display = 'none';
  }
  

  document.addEventListener('DOMContentLoaded', function() {
    var menuIcon = document.querySelector('.menu-icon');
    var navContent = document.querySelector('nav');
  
    menuIcon.addEventListener('click', function() {
      navContent.classList.toggle('active');
    });
  });
  

  const loader = document.querySelector('.loarder');

  window.addEventListener('load', () => {
    loader.classList.add('fondu-out')
  } );
