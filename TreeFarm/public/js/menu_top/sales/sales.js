
/******************************************************************

* Attach button handlers

******************************************************************/
attachUpdateHandler('input[name="update"]', salesEditRoute);
attachViewHandler('input[name="view"]', salesShowRoute);


/******************************************************************
* 
* Initialize pagination for both tables if pagination is true
*
******************************************************************/
if (window["current_sales_table_body_paginate"])
{
    paginateTable("current_sales_table_body", "current_sales_table_body");
}

if (window["completed_sales_table_body_paginate"])
{
    paginateTable("completed_sales_table_body", "completed_sales_table_body");
}
