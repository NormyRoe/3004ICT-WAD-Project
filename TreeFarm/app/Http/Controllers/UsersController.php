<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use App\Models\UsersRole;
use Illuminate\Http\Request;

class UsersController extends Controller
{

    /***************************************************

    index()

    This function displays the information regarding Users.

    ****************************************************/
    public function index()
    {
        // Get the users awaiting approval from the database
        $awaiting_approvals = User::where('status', 'For Approval')
                                ->orderBy('last_name')
                                ->orderBy('first_name')
                                ->get();

        // Get the current users from the database
        $current_users = User::where('status', 'Approved')
                                ->orderBy('last_name')
                                ->orderBy('first_name')
                                ->get();
        
        // Get the deactivated and rejected users from the database
        $deactivated_users = User::whereIn('status', ['Inactive', 'Rejected'])
                                ->orderBy('last_name')
                                ->orderBy('first_name')
                                ->get();

        // Return the index view and pass it the users arrays
        return view('admin.users.index', [
            'awaiting_approvals' => $awaiting_approvals,
            'current_users' => $current_users,
            'deactivated_users' => $deactivated_users,
        ]);

    }


    /***************************************************

    create()

    This function displays the form for creating new Users.

    ****************************************************/
    public function create()
    {
        //
    }


    /***************************************************

    store(Request $request)

    This function validates the new User and 
    adds it to the database if it is valid.

    ****************************************************/
    public function store(Request $request)
    {
        //
    }


    /***************************************************

    show($id)

    This function displays the form for viewing the 
    User's details.

    ****************************************************/
    public function show($id)
    {
        // Get the user object from the database
        $user = User::with('manager')->with('roles')->findOrFail($id);
        
        // Return the show view and pass it the user object
        return view('admin.users.show', [
            'user' => $user,
        ]);

    }


    /***************************************************

    edit($id)

    This function displays the form for updating a User.

    ****************************************************/
    public function edit($id)
    {
        //
    }


    /***************************************************

    update(Request $request, $id)

    This function updates the specified user object.

    ****************************************************/
    public function update(Request $request, $id)
    {
        //
    }


    /***************************************************

    approve(Request $request, $id)

    This function approves the user registration request.

    ****************************************************/
    public function approve(Request $request, $id)
    {
        // Get the user from the database
        $user = User::findOrFail($id);

        // Validate the request
        $validated = $request->validate([
            'manager_id' => 'nullable|exists:users,id',
            'roles' => 'required|array|min:1',
            'roles.*'    => 'exists:roles,id',
        ]);

        // Assign manager (if one was selected)
        $user->manager_id = $request->manager_id ?: null;

        // Update user record fields
        $user->status = 'Approved';
        $user->modified_by = auth()->id();

        // Update the user record in the database
        $user->save();

        // Assign the roles to the user
        // For loop through the selected roles
        foreach ($request->roles as $role_id)
        {
            // Create the User Role record
            UsersRole::create([
                'user_id' => $user->id,
                'role_id' => $role_id,
                'created_by' => auth()->id(),
                'modified_by' => auth()->id(),                
            ]);
            
        }

        // Redirect to the index view and pass it a success message
        return redirect("users")->with('success', 'The User has been successfully approved.');

    }


    /***************************************************

    approval($id)

    This function assigns roles and a manager (if required) 
    to the approved user registration request.

    ****************************************************/
    public function approval($id)
    {
        // Get the user from the database
        $user = User::findOrFail($id);

        // Get all of the other current users
        $current_users = User::where('status', 'Approved')
                                ->orderBy('last_name')
                                ->orderBy('first_name')
                                ->get();

        // Take just the managers out of current_users list
        $managers = $current_users->filter(function ($u) {
                                            return $u->hasAnyRole(['Owner', 'Operational Manager', 'Sales Manager']);
                                        });

        // Get the roles from the database
        $roles = Role::orderBy('name')->get();

        // Return the assign roles view and pass it the user and arrays
        return view('admin.users.approval', [
            'user' => $user,
            'managers' => $managers,
            'roles' => $roles,
        ]);
    }

    /***************************************************

    reject($id)

    This function rejects the user registration request.

    ****************************************************/
    public function reject($id)
    {
        // Get the user from the database
        $user = User::findOrFail($id);
        
        // Update the user in the database
        $user->update([
            'status' => 'Rejected',
            'modified_by' => auth()->id(),
        ]);

        // Redirect to the index view and pass it a success message
        return redirect("users")->with('success', 'The User has been successfully rejected.');

    }


    /***************************************************

    deactivate($id)

    This function deactivates the user object.

    ****************************************************/
    public function deactivate($id)
    {
        // Get the user object
        

    }


    /***************************************************

    reactivate($id)

    This function reactivates the user object.

    ****************************************************/
    public function reactivate($id)
    {
        // Get the user object
        

    }

}
