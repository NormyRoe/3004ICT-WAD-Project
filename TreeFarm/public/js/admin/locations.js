/******************************************************************

* Attach button handlers

******************************************************************/
attachUpdateHandler('input[name="update_area"]', areasEditRoute);
attachDeleteHandler('input[name="delete_area"]', areasDeleteRoute);
attachUpdateHandler('input[name="update_block"]', blocksEditRoute);
attachDeleteHandler('input[name="delete_block"]', blocksDeleteRoute);
attachUpdateHandler('input[name="update_aisle"]', aislesEditRoute);
attachDeleteHandler('input[name="delete_aisle"]', aislesDeleteRoute);
attachUpdateHandler('input[name="update_location"]', locationsEditRoute);
attachDeleteHandler('input[name="delete_location"]', locationsDeleteRoute);


/******************************************************************
* 
* Initialize pagination for tables if pagination is true
*
******************************************************************/
if (window["area_table_body_paginate"])
{
    paginateTable("area_table_body", "area_table_body");
}

if (window["block_table_body_paginate"])
{
    paginateTable("block_table_body", "block_table_body");
}

if (window["aisle_table_body_paginate"])
{
    paginateTable("aisle_table_body", "aisle_table_body");
}

if (window["location_table_body_paginate"])
{
    paginateTable("location_table_body", "location_table_body");
}

