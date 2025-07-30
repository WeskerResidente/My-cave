document.addEventListener('DOMContentLoaded', function () {
  const paysSelect = document.querySelector('select[name="pays"]');
  const regionSelect = document.querySelector('select[name="region"]');

  const allRegionOptions = Array.from(regionSelect.querySelectorAll('option')).slice(1);
  const regionToPaysMap = {};

  // Crée une map région -> pays
  allRegionOptions.forEach(option => {
    const regionId = option.value;
    const paysId = option.dataset.paysId;
    regionToPaysMap[regionId] = paysId;
  });

  function updateRegionsBasedOnPays() {
    const selectedPaysId = paysSelect.value;
    const selectedRegionId = regionSelect.value;

    // Réinitialise
    regionSelect.innerHTML = '<option value="">Régions</option>';

    // Filtre les options
    const filteredOptions = allRegionOptions.filter(opt => {
      return !selectedPaysId || opt.dataset.paysId === selectedPaysId;
    });

    // Ajoute les options filtrées
    filteredOptions.forEach(opt => regionSelect.appendChild(opt));

    // Réapplique la sélection si toujours valide
    if (
      selectedRegionId &&
      filteredOptions.find(opt => opt.value === selectedRegionId)
    ) {
      regionSelect.value = selectedRegionId;
    } else {
      regionSelect.value = '';
    }
  }

  function updatePaysBasedOnRegion() {
    const selectedRegionId = regionSelect.value;
    const paysId = regionToPaysMap[selectedRegionId];

    if (paysId) {
      if (paysSelect.value !== paysId) {
        paysSelect.value = paysId;
        updateRegionsBasedOnPays();
        regionSelect.value = selectedRegionId;
      }
    }
  }

  // Événements
  paysSelect.addEventListener('change', updateRegionsBasedOnPays);
  regionSelect.addEventListener('change', updatePaysBasedOnRegion);

  // Initialisation
  updateRegionsBasedOnPays();
  updatePaysBasedOnRegion();
});
