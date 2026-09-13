
/******************************************************************

* Attach button handlers

******************************************************************/



/******************************************************************
* 
* Initialize pagination for both tables if pagination is true
*
******************************************************************/
if (window["other_sales_table_body_paginate"])
{
    paginateTable("other_sales_table_body", "other_sales_table_body");
}

if (window["delivered_sales_table_body_paginate"])
{
    paginateTable("delivered_sales_table_body", "delivered_sales_table_body");
}
