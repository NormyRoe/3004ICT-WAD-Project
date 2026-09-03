
/******************************************************************

* Attach button handlers

******************************************************************/
attachUpdateHandler('input[name="update_type"]', treeTypesEditRoute);
attachDeleteHandler('input[name="delete_type"]', treeTypesDeleteRoute);
attachViewHandler('input[name="view_tree"]', treesShowRoute);
attachUpdateHandler('input[name="update_tree"]', treesEditRoute);
attachDeleteHandler('input[name="delete_tree"]', treesDeleteRoute);


/******************************************************************
* 
* Initialize pagination for both tables if pagination is true
*
******************************************************************/
if (window["tree_type_table_body_paginate"])
{
    paginateTable("tree_type_table_body", "tree_type_table_body");
}

if (window["tree_table_body_paginate"])
{
    paginateTable("tree_table_body", "tree_table_body");
}

