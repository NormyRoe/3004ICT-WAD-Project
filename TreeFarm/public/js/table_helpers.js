
/******************************************************************
* 
* getSelectedRow(name = 'selected_row')
* -------------------------------------
* Returns the ID of the selected radio button row.

******************************************************************/
function getSelectedRow(name = 'selected_row') {
    const selected = document.querySelector(`input[name="${name}"]:checked`);
    return selected ? selected.value : null;
}


/******************************************************************
* 
* attachUpdateHandler(buttonSelector, routeTemplate)
* --------------------------------------------------
* Redirects to the edit page for the selected row.

******************************************************************/
function attachUpdateHandler(buttonSelector, routeTemplate) {

    const button = document.querySelector(buttonSelector);
    if (!button) return;

    button.addEventListener('click', () => {

        const id = getSelectedRow();
        if (!id) {
            alert("Please select a row to update.");
            return;
        }

        window.location.href = routeTemplate.replace(':id', id);
    });
}


/******************************************************************
* 
* attachDeleteHandler(buttonSelector, routeTemplate)
* --------------------------------------------------
* Redirects to the delete confirmation page for the selected row.

******************************************************************/
function attachDeleteHandler(buttonSelector, routeTemplate) {

    const button = document.querySelector(buttonSelector);
    if (!button) return;

    button.addEventListener('click', () => {

        const id = getSelectedRow();
        if (!id) {
            alert("Please select a row to delete.");
            return;
        }

        window.location.href = routeTemplate.replace(':id', id);
    });
}


/******************************************************************
* 
* attachViewHandler(buttonSelector, routeTemplate)
* ------------------------------------------------
* Redirects to the view page for the selected row.

******************************************************************/
function attachViewHandler(buttonSelector, routeTemplate) {

    const button = document.querySelector(buttonSelector);
    if (!button) return;

    button.addEventListener('click', () => {

        const id = getSelectedRow();
        if (!id) {
            alert("Please select a row to view.");
            return;
        }

        window.location.href = routeTemplate.replace(':id', id);
    });
}


/******************************************************************
* 
* paginateTable(pageParam, tbodyId, buildRowCallback)
* ---------------------------------------------------
* Handles client-side pagination for ANY filtering table.
* 
* This function:
*   - Reads the filtered dataset exposed by Blade
*   - Slices the dataset into pages (15 rows per page)
*   - Renders the correct rows into the table <tbody>
*   - Updates the page indicator
*   - Responds to Next / Previous button clicks
*   - Does NOT reload the page
*   - Does NOT modify the URL
*   - Works even when multiple tables exist on the same page
* 
* PARAMETERS:
*   pageParam        - Unique key for this table instance (e.g., "tree_page")
*   tbodyId          - The ID of the <tbody> element to render rows into
*   buildRowCallback - Function(row) that returns HTML for one <tr> row
*
******************************************************************/
function paginateTable(pageParam, tbodyId) {

    // Retrieve the filtered dataset from Blade (array of rows)
    const allRows = window[pageParam + "_data"];

    // Retrieve total number of pages computed by Blade
    const totalPages = window[pageParam + "_totalPages"];

    // Retrieve the columns to hide
    const hideColumns = window[pageParam + "_hideColumns"];

    // Number of rows per page
    const perPage = 15;

    // Track the current page (start at page 1)
    let currentPage = 1;

    console.log("paginateTable called with:", { pageParam, tbodyId });
    console.log("allRows length:", allRows ? allRows.length : "undefined");
    console.log("totalPages:", totalPages);

    /******************************************************************
    * 
    * renderPage()
    * ------------
    * Slices the dataset for the current page and rebuilds the table.
    * 
    ******************************************************************/
    function renderPage() {

        // Calculate slice boundaries
        const start = (currentPage - 1) * perPage;
        const end = start + perPage;

        // Extract only the rows for this page
        const pageRows = allRows.slice(start, end);

        // Get the table body element
        const tbody = document.getElementById(tbodyId);

        // Clear existing rows
        tbody.innerHTML = "";

        // Build each row using the row function
        pageRows.forEach(row => {
            const tr = document.createElement("tr");
            tr.classList.add("hover:bg-amber-200");
            tr.innerHTML = buildRow(row, hideColumns);
            tbody.appendChild(tr);
        });

        // Update the page number display in the pagination footer
        const pagination = tbody.closest('.overflow-x-auto').querySelector('.table-pagination');
        pagination.querySelector('[data-page-display]').textContent = currentPage;
    }

    /******************************************************************
    * 
    * NEXT button handler
    * 
    ******************************************************************/
    document
        .querySelector(`[data-action="next"][data-page-param="${pageParam}"]`)
        .addEventListener('click', () => {

            // Prevent going past the last page
            if (currentPage < totalPages) {
                currentPage++;
                renderPage();
            }
        });

    /******************************************************************
    * 
    * PREVIOUS button handler
    * 
    ******************************************************************/
    document
        .querySelector(`[data-action="prev"][data-page-param="${pageParam}"]`)
        .addEventListener('click', () => {

            // Prevent going below page 1
            if (currentPage > 1) {
                currentPage--;
                renderPage();
            }
        });

    /******************************************************************
    * 
    * Initial render (page 1)
    * 
    ******************************************************************/
    renderPage();

}


/******************************************************************
* 
* buildRow(row)
* ---------------------
* Builds ONE <tr> row for the table.
*
******************************************************************/
function buildRow(row, hideColumns) {

    let html = `
        <td class="px-2 py-1 border border-yellow-800 text-center w-12">
            <input type="radio" name="selected_row" value="${row[0]}" class="select-row">
        </td>
    `;

    row.forEach((cell, index) => {

        // Convert null or undefined to empty string
        const value = (cell === null || cell === undefined) ? "" : cell;

        if (index === 0) {
            html += `<td class="hidden"></td>`;
        } else {
            const hidden = hideColumns.includes(index)
                ? "hidden md:table-cell"
                : "";

            html += `
                <td class="px-4 py-2 border border-yellow-800 whitespace-nowrap text-xs md:text-sm ${hidden}">
                    ${value}
                </td>
            `;
        }
    });

    return html;

}