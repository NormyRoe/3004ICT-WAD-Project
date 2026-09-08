/******************************************************************

* Attach button handlers

******************************************************************/
attachUpdateHandler('input[name="update_price"]', pricesEditRoute);
attachDeleteHandler('input[name="delete_price"]', pricesDeleteRoute);
attachUpdateHandler('input[name="update_exception"]', exceptionsEditRoute);
attachDeleteHandler('input[name="delete_exception"]', exceptionsDeleteRoute);

/******************************************************************
* 
* Initialize pagination for tables if pagination is true
*
******************************************************************/
if (window["price_table_body_paginate"])
{
    paginateTable("price_table_body", "price_table_body");
}

if (window["exception_price_table_body_paginate"])
{
    paginateTable("exception_price_table_body", "exception_price_table_body");
}


