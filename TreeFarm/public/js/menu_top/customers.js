
/******************************************************************

* Attach button handlers

******************************************************************/
attachUpdateHandler('input[name="update"]', customersEditRoute);
attachViewHandler('input[name="view"]', customersShowRoute);


/******************************************************************
* 
* Initialize pagination for both tables if pagination is true
*
******************************************************************/
if (window["customer_table_body_paginate"])
{
    paginateTable("customer_table_body", "customer_table_body");
}

