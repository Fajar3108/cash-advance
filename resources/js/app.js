import './bootstrap';
import 'flowbite';

const formConfirmations = document.querySelectorAll('form[data-confirmation="true"]')

formConfirmations.forEach((form) => {
    form.addEventListener('submit', (e) => {
        const ok = confirm('Are you sure?')

        if (!ok) {
            e.preventDefault();
        }
    })
})
