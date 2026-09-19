/***************************************************
*
*  sales_items.js
*
*  Handles all sale item table behaviour:
*      - Adding items
*      - Removing items
*      - Rendering table rows
*      - Price lookup logic
*
***************************************************/

import { updateTotalSales } from './form_fields.js';

/***************************************************
* FUNCTION: generateTempId()
*
* Generates a temporary negative ID for new items.
***************************************************/
export function generateTempId() {
    return -Math.floor(Math.random() * 1000000000);
}

/***************************************************
* FUNCTION: renderItemsTable()
*
* Rebuilds the sale items table <tbody> based on
* the current itemsArray.
***************************************************/
export function renderItemsTable() {

    const tbody = document.querySelector('table tbody');
    tbody.innerHTML = ""; // Clear existing rows

    // If no items, show placeholder row
    if (window.itemsArray.length === 0) {
        tbody.innerHTML = `
            <tr>
                <td colspan="6" class="text-center text-stone-500 py-2">
                    No items yet
                </td>
            </tr>`;
        return;
    }

    // Build rows for each item
    window.itemsArray.forEach(item => {

        // Lookup inventory name
        const inv = window.inventoryLookup[item.inventory_id];
        const invName = `${inv.pot_size}, ${inv.tree_name}`;

        const row = document.createElement('tr');
        row.classList.add('hover:bg-amber-200');

        row.innerHTML = `
            <td class="px-4 py-2 border border-yellow-800">${invName}</td>
            <td class="px-4 py-2 border border-yellow-800">${item.quantity}</td>
            <td class="px-4 py-2 border border-yellow-800">$${item.unit_price.toFixed(2)}</td>
            <td class="px-4 py-2 border border-yellow-800">$${item.discount}</td>
            <td class="px-4 py-2 border border-yellow-800">$${item.total_price.toFixed(2)}</td>
            ${window.saleStatus === "In Progress" ? `
                <td class="px-4 py-2 border border-yellow-800">
                    <button type="button" class="text-red-600 font-bold"
                        onclick="removeSaleItem(${item.id})">X</button>
                </td>
            ` : `
                <td class="px-4 py-2 border border-yellow-800"></td>
            `}
        `;

        tbody.appendChild(row);

    });
}

/***************************************************
* FUNCTION: handleAddItem()
*
* Reads inputs, determines pricing, adds item to
* itemsArray, and re-renders the table.
***************************************************/
export function handleAddItem() {

    // Read inventory ID
    const inventoryId = document.querySelector('[x-ref="inventorySelect"]').value;
    if (!inventoryId) return alert("Please select an inventory item.");

    // Prevent duplicate inventory items
    const alreadyExists = window.itemsArray.some(i => i.inventory_id == inventoryId);
    if (alreadyExists) {
        return alert("This inventory item has already been added to the sale.");
    }

    // Lookup inventory details
    const inventory = window.inventoryLookup[inventoryId];
    const treeId = inventory.tree_id;
    const potSizeId = inventory.pot_size_id;
    const inventory_quantity = inventory.quantity;

    // Read quantity
    const quantity = parseInt(document.querySelector('input[name="quantity"]').value);
    if (!quantity || quantity <= 0 || quantity > inventory_quantity) return alert("Please enter a valid quantity.");

    // Read discount
    const discount = parseFloat(document.querySelector('input[name="item_discount"]').value || 0);

    // Determine unit price
    let unitPrice = null;

    // Check exception prices
    for (const ep of window.exceptionPrices) {
        if (ep.tree_id == treeId && ep.pot_size_id == potSizeId) {
            unitPrice = parseFloat(ep.price);
            break;
        }
    }

    // If no exception price, use normal price
    if (unitPrice === null) {
        for (const p of window.prices) {
            if (p.pot_size_id == potSizeId) {
                unitPrice = parseFloat(p.price);
                break;
            }
        }
    }

    if (unitPrice === null) return alert("Unable to determine unit price.");

    // Calculate total price
    const totalPrice = (unitPrice * quantity) - discount;

    // Add item to array
    window.itemsArray.push({
        id: generateTempId(),
        inventory_id: inventoryId,
        quantity,
        unit_price: unitPrice,
        discount,
        total_price: totalPrice
    });

    // Re-render + update totals
    renderItemsTable();
    updateTotalSales();

    /***************************************************
    * Clear input fields after adding an item
    ***************************************************/
    const quantityInput = document.querySelector('input[name="quantity"]');
    const discountInput = document.querySelector('input[name="item_discount"]');
    const inventorySelect = document.querySelector('[x-ref="inventorySelect"]');
    const searchInput = document.querySelector('[x-model="search"]');

    // Reset quantity
    if (quantityInput) quantityInput.value = "";

    // Reset discount
    if (discountInput) discountInput.value = "";

    // Reset hidden Alpine select
    if (inventorySelect) inventorySelect.value = "";

    // Reset visible Alpine search box
    if (searchInput) {
        searchInput.value = "";
        searchInput.dispatchEvent(new Event('input')); // forces Alpine to update
    }

}

/***************************************************
* FUNCTION: removeSaleItem(id)
*
* Removes an item from itemsArray and re-renders.
***************************************************/
export function removeSaleItem(id) {
    window.itemsArray = window.itemsArray.filter(item => item.id !== id);
    renderItemsTable();
    updateTotalSales();
}

window.removeSaleItem = removeSaleItem;
