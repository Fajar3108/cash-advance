const addItemButton = document.getElementById('add-item-button');
const itemForm = document.getElementById('item-form');
const itemsContainer = document.getElementById('items-container');
const itemsHiddenInput = document.getElementById('items-hidden-input');

const currentItems = [];

addItemButton.addEventListener('click', () => {
    const priceInput = itemForm.querySelector('#price');
    const quantityInput = itemForm.querySelector('#quantity');
    const noteInput = itemForm.querySelector('#note');

    if (priceInput.value === '' || quantityInput.value === '' || noteInput.value === '') {
        alert('Please fill in all fields');
        return
    }

    if (isNaN(priceInput.value) || isNaN(quantityInput.value)) {
        alert('Price and quantity must be numbers');
        return
    }

    if (priceInput.value <= 0 || quantityInput.value <= 0) {
        alert('Price and quantity must be greater than 0');
        return
    }

    const item = {
        note: noteInput.value,
        price: Number(priceInput.value),
        quantity: Number(quantityInput.value),
    };

    currentItems.push(item);

    priceInput.value = '';
    quantityInput.value = 0;
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

        const nameData = document.createElement('th');
        nameData.className = 'px-6 py-4';
        nameData.innerText = item.name;

        const quantityData = document.createElement('td');
        quantityData.className = 'px-6 py-4';
        quantityData.innerText = item.quantity;

        const priceData = document.createElement('td');
        priceData.className = 'px-6 py-4';
        priceData.innerText = item.price;

        const totalData = document.createElement('td');
        totalData.className = 'px-6 py-4';
        totalData.innerText = item.price * item.quantity;

        const actionData = document.createElement('td');
        actionData.className = 'px-6 py-4';

        const removeButton = document.createElement('button');
        removeButton.className = 'remove-item-button focus:outline-none text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg cursor-pointer text-sm px-3 py-2 w-fit';
        removeButton.setAttribute('data-index', index);
        removeButton.addEventListener('click', removeItem);
        removeButton.innerText = 'Remove';

        actionData.appendChild(removeButton);

        row.appendChild(numberData);
        row.appendChild(nameData);
        row.appendChild(quantityData);
        row.appendChild(priceData);
        row.appendChild(totalData);
        row.appendChild(actionData);


        itemsContainer.appendChild(row);
    });
}
