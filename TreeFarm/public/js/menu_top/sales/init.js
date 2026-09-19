
/***************************************************
*
*  init.js
*
*  Handles initialisation for the Sales Edit page:
*      - Loads existing sale items
*      - Binds event listeners
*      - Connects modules together
*      - Prepares form submission
*
***************************************************/

import { renderItemsTable, handleAddItem } from './sales_items.js';
import { updateTotalSales, updateDeliveryFee } from './form_fields.js';
import { generateKms } from './generate_kms.js';


document.addEventListener('DOMContentLoaded', () => {

    /***************************************************
    *  DELIVERY PRICING LOOKUP (computed once)
    ***************************************************/
    const deliveryRateRow = window.prices.find(p => p.name === "Delivery Rate");
    const deliveryMinimumRow = window.prices.find(p => p.name === "Delivery Minimum");

    window.deliveryRate = deliveryRateRow ? parseFloat(deliveryRateRow.rate) : 0;
    window.deliveryMinimum = deliveryMinimumRow ? parseFloat(deliveryMinimumRow.price) : 0;

    /***************************************************
    *  GST LOOKUP (computed once)
    ***************************************************/
    const gstRow = window.prices.find(p => p.name === "GST");
    window.gstRate = gstRow ? parseFloat(gstRow.rate) : 0;

    /***************************************************
    * Load existing sale items into global itemsArray
    ***************************************************/
    window.itemsArray = window.existingSaleItems.map(item => ({
        id: item.id,
        inventory_id: item.inventory_id,
        quantity: item.quantity,
        unit_price: parseFloat(item.unit_price),
        discount: parseFloat(item.discount),
        total_price: parseFloat(item.total_price)
    }));

    // Render table immediately
    renderItemsTable();

    /***************************************************
    * Bind Add Item button
    ***************************************************/
    const addButton = document.querySelector('[data-add-item]');
    if (addButton) {
        addButton.addEventListener('click', handleAddItem);
    }

    /***************************************************
    * Bind delivery fee + discount listeners
    ***************************************************/
    document.querySelector('input[name="delivery_fee"]').addEventListener('input', updateTotalSales);
    document.querySelector('input[name="discount"]').addEventListener('input', updateTotalSales);

    /***************************************************
    * Bind delivery kms listeners
    ***************************************************/
    const deliveryKmsInput = document.querySelector('input[name="delivery_kms"]');
    if (deliveryKmsInput) {
        deliveryKmsInput.addEventListener('input', updateDeliveryFee);
        deliveryKmsInput.addEventListener('change', updateDeliveryFee);
    }

    /***************************************************
    * Before form submission, write items JSON
    ***************************************************/
    const form = document.querySelector('#sale-form');
    form.addEventListener('submit', () => {
        document.getElementById('items_json').value = JSON.stringify(window.itemsArray);
    });

    /***************************************************
    * Bind Calculate Delivery Kms button
    ***************************************************/
    const calcButton = document.getElementById('btn-calc-kms');
    if (calcButton) {
        calcButton.addEventListener('click', generateKms);
    }

});
