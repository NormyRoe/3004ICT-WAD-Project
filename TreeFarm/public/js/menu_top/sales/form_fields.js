/***************************************************
*
*  form_fields.js
*
*  Handles all dynamic form field calculations:
*      - Delivery fee
*      - GST
*      - Total sales
*
***************************************************/

/***************************************************
* FUNCTION: updateTotalSales()
*
* Recalculates total sales based on:
*      - Item totals
*      - Delivery fee
*      - Sale-level discount
*      - GST (if applicable)
***************************************************/
export function updateTotalSales() {

    // Sum item totals
    let itemsTotal = window.itemsArray.reduce((sum, item) => sum + item.total_price, 0);

    // Read delivery fee
    const deliveryFee = parseFloat(document.querySelector('input[name="delivery_fee"]').value || 0);

    // Read sale-level discount
    const saleDiscount = parseFloat(document.querySelector('input[name="discount"]').value || 0);

    // Subtotal before GST
    const subtotal = itemsTotal + deliveryFee - saleDiscount;

    // Apply GST
    let totalSales = subtotal;
    if (window.gstRate > 0) {
        totalSales = subtotal * (1 + window.gstRate / 100);
    }

    // Write back to form
    document.querySelector('input[name="total_sales"]').value = totalSales.toFixed(2);

}

/***************************************************
* FUNCTION: updateDeliveryFee()
*
* Calculates delivery fee based on kms:
*      fee = kms * deliveryRate
*      if fee < deliveryMinimum → use minimum
***************************************************/
export function updateDeliveryFee() {

    // Read kms
    const kms = parseFloat(document.querySelector('input[name="delivery_kms"]').value) || 0;

    // Compute fee
    let fee = kms * window.deliveryRate;

    // Apply minimum rule
    if (fee < window.deliveryMinimum && kms > 0) {
        fee = window.deliveryMinimum;
    }

    // Write fee back
    document.querySelector('input[name="delivery_fee"]').value = fee.toFixed(2);

    // Update total sales
    updateTotalSales();
    
}
