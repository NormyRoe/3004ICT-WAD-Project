
/******************************************************************

* Attach button handlers

******************************************************************/
attachUpdateHandler('input[name="update"]', potSizesEditRoute);
attachDeleteHandler('input[name="delete"]', potSizesDeleteRoute);


/******************************************************************
* 
* Initialize pagination for both tables if pagination is true
*
******************************************************************/
if (window["pot_size_table_body_paginate"])
{
    paginateTable("pot_size_table_body", "pot_size_table_body");
}
