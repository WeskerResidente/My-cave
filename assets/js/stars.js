console.log('🎯 Début du stars.js');

document.addEventListener('DOMContentLoaded', function () {
    console.log('🔍 DOM prêt');
    console.log('🔍 Étoiles détectées :', document.querySelectorAll('#star-widget .star').length);
    console.log('🔍 Champ caché :', document.getElementById('notation_note_hidden'));
    console.log('✨ stars.js DOM loaded');

    const stars = document.querySelectorAll('#star-widget .star');
    const input = document.getElementById('notation_type_form_note');
    const form = input?.form;

    const alreadyRated = document.querySelector('#star-widget')?.dataset.alreadyRated === "1";

    if (!input || !form || stars.length === 0) {
        console.warn('⛔ Le champ ou les étoiles ne sont pas disponibles.');
        return;
    }

    stars.forEach((star, index) => {
        star.addEventListener('click', () => {
            console.log('⭐ Click sur étoile', index + 1);
            const newValue = index + 1;

            if (alreadyRated) {
                const confirmed = confirm('Vous avez déjà noté ce vin. Voulez-vous modifier votre note ?');
                if (!confirmed) return;
            }

            input.value = newValue;
            highlightStars(index);
            form.submit();
        });

        star.addEventListener('mouseover', () => highlightStars(index));
        star.addEventListener('mouseout', () => {
            const val = parseInt(input.value);
            highlightStars(val ? val - 1 : -1);
        });
    });

    function highlightStars(index) {
        stars.forEach((star, i) => {
            star.style.color = i <= index ? '#88002D' : '#ccc';
        });
    }

    // Surligne la note si déjà définie
    if (input.value) {
        highlightStars(parseInt(input.value) - 1);
    }
});
