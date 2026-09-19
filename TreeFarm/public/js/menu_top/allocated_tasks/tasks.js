
/******************************************************************

* Attach button handlers

******************************************************************/
attachUpdateHandler('input[name="update_current"]', currentEditRoute);
attachViewHandler('input[name="view_current"]', currentShowRoute);

attachUpdateHandler('input[name="update_unallocated"]', unallocatedEditRoute);
attachViewHandler('input[name="view_unallocated"]', unallocatedShowRoute);
attachDeleteHandler('input[name="delete_unallocated"]', unallocatedDeleteRoute);

attachUpdateHandler('input[name="update_allocated"]', allocatedEditRoute);
attachViewHandler('input[name="view_allocated"]', allocatedShowRoute);
attachDeleteHandler('input[name="delete_allocated"]', allocatedDeleteRoute);


/******************************************************************
* 
* Initialize pagination for both tables if pagination is true
*
******************************************************************/
if (window["current_tasks_table_body_paginate"])
{
    paginateTable("current_tasks_table_body", "current_tasks_table_body");
}

if (window["unallocated_tasks_table_body_paginate"])
{
    paginateTable("unallocated_tasks_table_body", "unallocated_tasks_table_body");
}

if (window["allocated_tasks_table_body_paginate"])
{
    paginateTable("allocated_tasks_table_body", "allocated_tasks_table_body");
}

