document.addEventListener('DOMContentLoaded', () => {
  const nameBtn = document.getElementById('edit-name-btn');
  const descBtn = document.getElementById('edit-desc-btn');
  const nameField = document.getElementById('cave-name');
  const descField = document.getElementById('cave-description');
  const imageInput = document.getElementById('image-input');
  const changeImageBtn = document.getElementById('change-image-btn');
  const imageDisplay = document.getElementById('cave-image');

  let nameEditing = false;
  let descEditing = false;

  nameBtn?.addEventListener('click', () => {
    nameEditing = !nameEditing;
    nameField.contentEditable = nameEditing;
    nameBtn.textContent = nameEditing ? '💾 Enregistrer' : '✏️ Nom';

    if (!nameEditing) saveChanges();
  });

  descBtn?.addEventListener('click', () => {
    descEditing = !descEditing;
    descField.contentEditable = descEditing;
    descBtn.textContent = descEditing ? '💾 Enregistrer' : '📝 Description';

    if (!descEditing) saveChanges();
  });

  function saveChanges() {
    fetch(saveUrl, {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'X-Requested-With': 'XMLHttpRequest'
      },
      body: JSON.stringify({
        nom: nameField.textContent.trim(),
        description: descField.textContent.trim()
      })
    }).then(res => {
      if (!res.ok) alert("Erreur lors de la sauvegarde.");
    });
  }

  changeImageBtn?.addEventListener('click', () => {
    imageInput.click();
  });

  imageInput?.addEventListener('change', () => {
    const file = imageInput.files[0];
    if (file) {
      const formData = new FormData();
      formData.append('image', file);

      fetch(imageUploadUrl, {
        method: 'POST',
        headers: {
          'X-Requested-With': 'XMLHttpRequest'
        },
        body: formData
      })
      .then(res => res.json())
      .then(data => {
        if (data.success && data.newImagePath) {
          imageDisplay.src = data.newImagePath;
        } else {
          alert('Erreur lors du téléversement de l’image : ' + (data.error || ''));
        }
      });
    }
  });
});