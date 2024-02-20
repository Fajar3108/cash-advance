const currencyInputs = document.querySelectorAll('input[data-format="currency"]');

currencyInputs.forEach(input => {
    input.addEventListener('keyup', e => {
        let value = input.value.replace(/\D/g, '');
        value = value.replace(/\B(?=(\d{3})+(?!\d))/g, '.');
        input.value = value;

        const hiddenPriceInput = document.getElementById(input.dataset.target);
        hiddenPriceInput.value = Number(value.replace(/\./g, ''));
    });
});
