
/******************************************************************

* Attach button handlers

******************************************************************/
attachUpdateHandler('input[name="approve_user"]', approveUserRoute);
attachUpdateHandler('input[name="reject_user"]', rejectUserRoute);

attachUpdateHandler('input[name="update_current_user"]', currentUserEditRoute);
attachViewHandler('input[name="view_current_user"]', currentUserShowRoute);
attachDeleteHandler('input[name="deactivate_user"]', deactivateUserRoute);

attachUpdateHandler('input[name="update_old_user"]', oldUserEditRoute);
attachViewHandler('input[name="view_old_user"]', oldUserShowRoute);
attachUpdateHandler('input[name="reactivate_user"]', reactivateUserRoute);


/******************************************************************
* 
* Initialize pagination for both tables if pagination is true
*
******************************************************************/
if (window["for_approval_table_body_paginate"])
{
    paginateTable("for_approval_table_body", "for_approval_table_body");
}

if (window["current_users_table_body_paginate"])
{
    paginateTable("current_users_table_body", "current_users_table_body");
}

if (window["deactivated_users_table_body_paginate"])
{
    paginateTable("deactivated_users_table_body", "deactivated_users_table_body");
}
