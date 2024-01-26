const addItemButton = document.getElementById('add-item-button');
const itemForm = document.getElementById('item-form');
const itemsContainer = document.getElementById('items-container');
const itemsHiddenInput = document.getElementById('items-hidden-input');

const currentItems = [];

addItemButton.addEventListener('click', () => {
    const priceInput = itemForm.querySelector('#price');
    const dateInput = itemForm.querySelector('#date');
    const noteInput = itemForm.querySelector('#note');

    if (priceInput.value === '' || dateInput.value === '' || noteInput.value === '') {
        alert('Please fill in all fields');
        return
    }

    if (isNaN(priceInput.value)) {
        alert('Price must be numbers');
        return
    }

    if (priceInput.value <= 0) {
        alert('Price and date must be greater than 0');
        return
    }

    const item = {
        note: noteInput.value,
        price: Number(priceInput.value),
        date: dateInput.value,
    };

    currentItems.push(item);

    priceInput.value = '';
    dateInput.value = (new Date()).toISOString().slice(0, 10);
    noteInput.value = '';

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

        const priceData = document.createElement('td');
        priceData.className = 'px-6 py-4';
        priceData.innerText = item.price;

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
        row.appendChild(priceData);
        row.appendChild(actionData);


        itemsContainer.appendChild(row);
    });
}
