/***************************************************
*
*  generate_kms.js
*
*  Handles the "Calculate Delivery Kms" workflow:
*      - Sends farm + customer address to Laravel
*      - Receives kms value
*      - Updates delivery_kms field
*      - Triggers delivery fee + total sales update
*
***************************************************/

import { updateDeliveryFee, updateTotalSales } from './form_fields.js';

/***************************************************
* FUNCTION: generateKms()
*
* Sends addresses to backend and updates delivery_kms.
***************************************************/
export async function generateKms() {

    const btn = document.getElementById('btn-calc-kms');
    btn.disabled = true;
    btn.value = 'Calculating…';

    try {
        
        // Read addresses
        const farmAddress = document.getElementById('farm_address').value;
        const customerAddress = document.getElementById('customer_address').value;

        // Build form data
        const formData = new FormData();
        formData.append('farm_address', farmAddress);
        formData.append('customer_address', customerAddress);

        // Send request
        const response = await fetch(window.calcKmsUrl, {
            method: 'POST',
            credentials: 'same-origin',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
            },
            body: formData
        });

        const data = await response.json();

        // Update kms field
        if (data.kms) {
            document.querySelector('input[name="delivery_kms"]').value = data.kms;
            updateDeliveryFee();
            updateTotalSales();
        } else {
            alert(data.error || "Unable to calculate kms.");
        }
    }
    finally {
        btn.disabled = false;
        btn.value = 'Calculate Delivery Kms';
    }
    
}
