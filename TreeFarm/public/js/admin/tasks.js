
/******************************************************************

* Attach button handlers

******************************************************************/
attachUpdateHandler('input[name="update"]', tasksEditRoute);
attachDeleteHandler('input[name="delete"]', tasksDeleteRoute);


/******************************************************************
* 
* Initialize pagination for both tables if pagination is true
*
******************************************************************/
if (window["task_table_body_paginate"])
{
    paginateTable("task_table_body", "task_table_body");
}
