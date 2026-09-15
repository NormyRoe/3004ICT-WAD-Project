/******************************************************************

* Tree Selection Listener for Inventories create_form

******************************************************************/
document.addEventListener('DOMContentLoaded', () => {

    const plantSelect = document.querySelector('select[name="plant_id"]');
    const commonNameLabel = document.getElementById('common_name_label');

    // Prevent the listener from running if it is not the create form or the update form.
    if (!plantSelect || !commonNameLabel || typeof treeData === 'undefined') {
        return;
    }

    // Pre-populate on page load if old() exists
    if (plantSelect.value) {

        const tree = treeData.find(t => t.id == plantSelect.value);
        commonNameLabel.textContent = tree ? tree.common_name : '';

    }

    // Populate based on selection
    plantSelect.addEventListener('change', () => {

        const selectedId = plantSelect.value;

        const tree = treeData.find(t => t.id == selectedId);

        commonNameLabel.textContent = tree ? tree.common_name : '';
    });

});

console.log("treeData:", treeData);
