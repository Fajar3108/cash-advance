const saveDraftBtn = document.getElementById('save-draft');

saveDraftBtn.addEventListener('click', () => {
    const form = saveDraftBtn.closest('form');

    const input = document.createElement('input');
    input.type = 'hidden';
    input.name = 'is_draft';
    input.value = '1';

    form.appendChild(input);

    form.submit();
});
