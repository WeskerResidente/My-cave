console.log('🎯 Début de ajax-filtre.js');
document.addEventListener('DOMContentLoaded', () => {
  const form       = document.querySelector('.filters-bar');
  const grid       = document.querySelector('.vins-grid');
  const pagination = document.querySelector('.pagination');

  form.addEventListener('submit', e => {
    e.preventDefault();
    // Recrée l’URL GET sans écraser la route
    const params = new URLSearchParams(new FormData(form));
    const url    = form.action || window.location.pathname;
    fetch(url + '?' + params, {
      headers: { 'X-Requested-With': 'XMLHttpRequest' }
    })
    .then(r => r.text())
    .then(html => {
      // Parse le HTML renvoyé
      const doc = new DOMParser().parseFromString(html, 'text/html');
      // Remplace uniquement le contenu de la grille
      const newGrid = doc.querySelector('.vins-grid');
      if (newGrid) grid.innerHTML = newGrid.innerHTML;
      // … et le contenu de la pagination
      const newPag = doc.querySelector('.pagination');
      if (newPag) pagination.innerHTML = newPag.innerHTML;
      // Optionnel : mettre à jour l’URL dans la barre d’adresse
      window.history.replaceState(null, '', url + '?' + params);
    })
    .catch(err => console.error(err));
  });
});

