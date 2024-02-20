const addItemButton = document.getElementById('add-item-button');
const itemForm = document.getElementById('item-form');
const itemsContainer = document.getElementById('items-container');
const itemsHiddenInput = document.getElementById('items-hidden-input');

const currentItems = [];

addItemButton.addEventListener('click', () => {
    const amountInput = itemForm.querySelector('#amount');
    const dateInput = itemForm.querySelector('#date');
    const noteInput = itemForm.querySelector('#note');
    const typeInput = itemForm.querySelector('#type');

    if (amountInput.value === '' || dateInput.value === '' || noteInput.value === '' || typeInput.value === '') {
        alert('Please fill in all fields');
        return
    }

    if (isNaN(amountInput.value)) {
        alert('Price must be number');
        return
    }

    if (amountInput.value <= 0 || dateInput.value <= 0) {
        alert('Price and quantity must be greater than 0');
        return
    }

    const item = {
        note: noteInput.value,
        amount: Number(amountInput.value),
        date: dateInput.value,
        type: typeInput.value,
    };

    currentItems.push(item);

    amountInput.value = 0;
    dateInput.value = (new Date()).toISOString().slice(0, 10);
    noteInput.value = '';
    typeInput.value = '';
    document.getElementById('amount-currency').value = '';

    renderItems();
});

const removeItem = (e) => {
    e.stopPropagation();

    const index = e.target.dataset.index;

    currentItems.splice(index, 1);

    renderItems();
}

const renderItems = () => {
    itemsContainer.innerHTML = '';

    itemsHiddenInput.value = JSON.stringify(currentItems);

    currentItems.forEach((item, index) => {
        const row = document.createElement('tr');
        row.className = 'bg-white border-b dark:bg-gray-800 dark:border-gray-700';

        const numberData = document.createElement('td');
        numberData.className = 'px-6 py-4';
        numberData.innerText = index + 1;

        const noteData = document.createElement('th');
        noteData.className = 'px-6 py-4';
        noteData.innerText = item.note;

        const dateData = document.createElement('td');
        dateData.className = 'px-6 py-4';
        dateData.innerText = item.date;

        const amountData = document.createElement('td');
        amountData.className = 'px-6 py-4';
        amountData.innerText = item.amount;

        const emptyTd = document.createElement('td');

        const actionData = document.createElement('td');
        actionData.className = 'px-6 py-4';

        const removeButton = document.createElement('button');
        removeButton.className = 'remove-item-button focus:outline-none text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg cursor-pointer text-sm px-3 py-2 w-fit';
        removeButton.setAttribute('data-index', index);
        removeButton.addEventListener('click', removeItem);
        removeButton.innerText = 'Remove';

        actionData.appendChild(removeButton);

        row.appendChild(numberData);
        row.appendChild(dateData);
        row.appendChild(noteData);

        if (item.type === 'debit') {
            row.appendChild(amountData);
            row.appendChild(emptyTd);
        } else {
            row.appendChild(emptyTd);
            row.appendChild(amountData);
        }


        row.appendChild(actionData);


        itemsContainer.appendChild(row);
    });
}
