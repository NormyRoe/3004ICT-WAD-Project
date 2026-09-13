
/******************************************************************

* Attach button handlers

******************************************************************/
attachUpdateHandler('input[name="update"]', inventoriesEditRoute);
attachDeleteHandler('input[name="delete"]', inventoriesDeleteRoute);
attachViewHandler('input[name="view"]', inventorieShowRoute);


/******************************************************************
* 
* Initialize pagination for both tables if pagination is true
*
******************************************************************/
if (window["inventory_table_body_paginate"])
{
    paginateTable("inventory_table_body", "inventory_table_body");
}


