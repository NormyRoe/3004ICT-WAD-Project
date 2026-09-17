
/***************************************************
*
*  edit.js
*
*  This file controls all dynamic behaviour for the
*  Sales Edit page, including:
*      - Managing the sale items array
*      - Adding new sale items
*      - Removing existing sale items
*      - Re-rendering the sale items table
*      - Writing items_json before form submission
*
***************************************************/


/***************************************************
*  GLOBAL VARIABLES
***************************************************/

// The itemsArray will hold ALL sale items (existing + new)
let itemsArray = [];

/***************************************************
*  DELIVERY PRICING LOOKUP (computed once)
***************************************************/
const deliveryRateRow = window.prices.find(p => p.name === "Delivery Rate");
const deliveryMinimumRow = window.prices.find(p => p.name === "Delivery Minimum");

const deliveryRate = deliveryRateRow ? parseFloat(deliveryRateRow.rate) : 0;
const deliveryMinimum = deliveryMinimumRow ? parseFloat(deliveryMinimumRow.price) : 0;

/***************************************************
 *  GST LOOKUP (computed once)
 ***************************************************/
const gstRow = window.prices.find(p => p.name === "GST");
const gstRate = gstRow ? parseFloat(gstRow.rate) : 0;

// These will be injected from Blade into the window object
// via <script> tags in edit_form.blade.php
// window.existingSaleItems
// window.prices
// window.exceptionPrices
// window.inventoryLookup


/***************************************************
*  INITIALISATION
***************************************************/
document.addEventListener('DOMContentLoaded', () => {

    // -----------------------------------------------
    // Load existing sale items into itemsArray
    // -----------------------------------------------
    itemsArray = window.existingSaleItems.map(item => ({
        id: item.id,
        inventory_id: item.inventory_id,
        quantity: item.quantity,
        unit_price: parseFloat(item.unit_price),
        discount: parseFloat(item.discount),
        total_price: parseFloat(item.total_price)
    }));

    // Render the table immediately
    renderItemsTable();


    // -----------------------------------------------
    // Attach Add Item button handler
    // -----------------------------------------------
    const addButton = document.querySelector('[data-add-item]');
    if (addButton) {
        addButton.addEventListener('click', handleAddItem);
    }

    // -----------------------------------------------
    // Add Listener for Delivery Fee changes
    // -----------------------------------------------
    document.querySelector('input[name="delivery_fee"]').addEventListener('input', updateTotalSales);

    // -----------------------------------------------
    // Add Listener for Sale Discount changes
    // -----------------------------------------------
    document.querySelector('input[name="discount"]').addEventListener('input', updateTotalSales);


    // -----------------------------------------------
    // Before form submission, write JSON into hidden field
    // -----------------------------------------------
    const form = document.querySelector('#sale-form');
    form.addEventListener('submit', () => {
        document.getElementById('items_json').value = JSON.stringify(itemsArray);
    });

    // -----------------------------------------------
    // Add Listener for Delivery Kms changes
    // -----------------------------------------------
    const deliveryKmsInput = document.querySelector('input[name="delivery_kms"]');
    if (deliveryKmsInput) {
        deliveryKmsInput.addEventListener('input', updateDeliveryFee);
        deliveryKmsInput.addEventListener('change', updateDeliveryFee);
    }


    /*
    // -----------------------------------------------
    // Add Listener for Calculate Delivery Kms button
    // -----------------------------------------------
    const calcButton = document.querySelector('[value="Calculate Delivery Kms"]');

    if (calcButton) {
        calcButton.addEventListener('click', async () => {

            const farmAddress = document.getElementById('farm_address').value;
            const customerAddress = document.getElementById('customer_address').value;

            const formData = new FormData();

            const response = await fetch(window.calcKmsUrl, {
                method: 'POST',
                credentials: 'same-origin',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
                },
                body: formData

            });

            //const text = await response.text();
            //console.log('RAW RESPONSE:', text);

            const data = await response.json();

            if (data.kms) {
                document.querySelector('input[name="delivery_kms"]').value = data.kms;
                updateTotalSales();
            } else {
                alert(data.error || "Unable to calculate kms.");
            }
        });
    }
    */

});


/***************************************************
*  FUNCTION: generateTempId()
*
*  Generates a tempory id for new sale item entries.
***************************************************/
function generateTempId() {

    // Negative IDs ensure no collision with real DB IDs
    return -Math.floor(Math.random() * 1000000000);

}

/***************************************************
*  FUNCTION: handleAddItem()
*
*  Reads user inputs, calculates pricing, adds item
*  to itemsArray, and re-renders the table.
***************************************************/
function handleAddItem() {

    // -----------------------------------------------
    // Read inventory ID from hidden Alpine select
    // -----------------------------------------------
    const inventoryId = document.querySelector('[x-ref="inventorySelect"]').value;
    if (!inventoryId) {
        alert("Please select an inventory item.");
        return;
    }

    // -----------------------------------------------
    // Read quantity
    // -----------------------------------------------
    const quantityInput = document.querySelector('input[name="quantity"]');
    const quantity = parseInt(quantityInput.value);
    if (!quantity || quantity <= 0) {
        alert("Please enter a valid quantity.");
        return;
    }

    // -----------------------------------------------
    // Read discount
    // -----------------------------------------------
    const discountInput = document.querySelector('input[name="item_discount"]');
    const discount = parseFloat(discountInput.value || 0);


    // -----------------------------------------------
    // Determine unit price
    // -----------------------------------------------
    let unitPrice = null;

    // Get inventory details (tree_id and pot_size_id)
    const inventory = window.inventoryLookup[inventoryId];
    const treeId = inventory.tree_id;
    const potSizeId = inventory.pot_size_id;

    // First check exception prices: match BOTH tree_id and pot_size_id
    for (const ep of window.exceptionPrices) {
        if (ep.tree_id == treeId && ep.pot_size_id == potSizeId) {
            unitPrice = parseFloat(ep.price);
            break;
        }
    }

    // If no exception price, use normal price by pot_size_id
    if (unitPrice === null) {
        for (const p of window.prices) {
            if (p.pot_size_id == potSizeId) {
                unitPrice = parseFloat(p.price);
                break;
            }
        }
    }

    if (unitPrice === null) {
        alert("Unable to determine unit price.");
        return;
    }


    // -----------------------------------------------
    // Calculate total price
    // -----------------------------------------------
    const totalPrice = (unitPrice * quantity) - discount;


    /***************************************************
     * Add new item to itemsArray
     ***************************************************/
    itemsArray.push({
        id: generateTempId(),            // unique temporary ID
        inventory_id: inventoryId,
        quantity: quantity,
        unit_price: unitPrice,
        discount: discount,
        total_price: totalPrice
    });


    // -----------------------------------------------
    // Re-render table
    // -----------------------------------------------
    renderItemsTable();

    // -----------------------------------------------
    // Update Total Sales
    // -----------------------------------------------

    updateTotalSales();

    // -----------------------------------------------
    // Clear inputs
    // -----------------------------------------------
    quantityInput.value = "";
    discountInput.value = "";
    document.querySelector('[x-ref="inventorySelect"]').value = "";
    const searchInput = document.querySelector('[x-model="search"]');
    searchInput.value = "";
    searchInput.dispatchEvent(new Event('input'));

}



/***************************************************
*  FUNCTION: removeSaleItem(id)
*
*  Removes an item from itemsArray and re-renders.
***************************************************/
function removeSaleItem(id) {

    // Filter out the item with the matching ID
    itemsArray = itemsArray.filter(item => item.id !== id);

    // Re-render table
    renderItemsTable();

    // Update Total Sales
    updateTotalSales();

}



/***************************************************
*  FUNCTION: renderItemsTable()
*
*  Rebuilds the <tbody> of the sale items table
*  based on the current itemsArray.
***************************************************/
function renderItemsTable() {

    const tbody = document.querySelector('table tbody');
    tbody.innerHTML = ""; // Clear existing rows

    // -----------------------------------------------
    // If no items, show placeholder row
    // -----------------------------------------------
    if (itemsArray.length === 0) {
        tbody.innerHTML = `
            <tr>
                <td colspan="6" class="text-center text-stone-500 py-2">
                    No items yet
                </td>
            </tr>
        `;
        return;
    }

    // -----------------------------------------------
    // Build rows for each item
    // -----------------------------------------------
    itemsArray.forEach(item => {

        // Lookup inventory name for display
        const inv = window.inventoryLookup[item.inventory_id];
        const invName = `${inv.pot_size}, ${inv.tree_name}`;

        const row = document.createElement('tr');
        row.classList.add('hover:bg-amber-200');

        row.innerHTML = `
            <td class="px-4 py-2 border border-yellow-800 text-xs md:text-sm">
                ${invName}
            </td>

            <td class="px-4 py-2 border border-yellow-800 text-xs md:text-sm">
                ${item.quantity}
            </td>

            <td class="px-4 py-2 border border-yellow-800 text-xs md:text-sm">
                $${item.unit_price.toFixed(2)}
            </td>

            <td class="px-4 py-2 border border-yellow-800 text-xs md:text-sm">
                $${item.discount}
            </td>

            <td class="px-4 py-2 border border-yellow-800 text-xs md:text-sm">
                $${item.total_price.toFixed(2)}
            </td>

            <td class="px-4 py-2 border border-yellow-800 text-xs md:text-sm">
                <button 
                    type="button" 
                    class="text-red-600 font-bold"
                    onclick="removeSaleItem(${item.id})"
                >
                    X
                </button>
            </td>
        `;

        tbody.appendChild(row);
    });

}

/***************************************************
*  FUNCTION: updateTotalSales()
*
*  Recalculates the Total Sales field based on:
*      - Sum of item total_price values
*      - Delivery fee (form-level)
*      - Sale-level discount
***************************************************/
function updateTotalSales() {

    // -----------------------------------------------
    // 1. Sum all item total_price values
    // -----------------------------------------------
    let itemsTotal = 0;
    itemsArray.forEach(item => {
        itemsTotal += item.total_price;
    });

    // -----------------------------------------------
    // 2. Read delivery fee
    // -----------------------------------------------
    const deliveryFeeInput = document.querySelector('input[name="delivery_fee"]');
    const deliveryFee = parseFloat(deliveryFeeInput.value || 0);

    // -----------------------------------------------
    // 3. Read sale-level discount
    // -----------------------------------------------
    const saleDiscountInput = document.querySelector('input[name="discount"]');
    const saleDiscount = parseFloat(saleDiscountInput.value || 0);

    // -----------------------------------------------
    // 4. Calculate subtotal (before GST)
    // -----------------------------------------------
    const subtotal = itemsTotal + deliveryFee - saleDiscount;

    // -----------------------------------------------
    // 5. Apply GST
    // -----------------------------------------------
    let totalSales;

    if (gstRate > 0)
    {
        totalSales = subtotal * (1 + gstRate / 100);
    }
    else
    {
        totalSales = subtotal;
    }
    

    // -----------------------------------------------
    // 5. Write value into form field
    // -----------------------------------------------
    const totalSalesInput = document.querySelector('input[name="total_sales"]');
    totalSalesInput.value = totalSales.toFixed(2);

}

/***************************************************
*  FUNCTION: updateDeliveryFee()
*
*  Calculates delivery fee based on kms:
*      fee = kms * deliveryRate
*      if fee < deliveryMinimum → use minimum
***************************************************/
function updateDeliveryFee() {
    
    // Get the inputs
    const kmsInput = document.querySelector('input[name="delivery_kms"]');
    const feeInput = document.querySelector('input[name="delivery_fee"]');

    if (!kmsInput || !feeInput) return;

    // Parse kms
    const kms = parseFloat(kmsInput.value) || 0;

    // Compute fee
    let fee = kms * deliveryRate;

    // Apply minimum rule
    if (fee < deliveryMinimum && kms > 0) {
        fee = deliveryMinimum;
    }

    // Write fee back to form
    feeInput.value = fee.toFixed(2);

    // Recalculate total sales
    updateTotalSales();

}
