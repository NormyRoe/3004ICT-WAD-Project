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
        
        // Return the create view and pass it the arrays
        return view('admin.users.create_form', [
            'managers' => $managers,
            'roles' => $roles,
        ]);

    }


    /***************************************************

    store(Request $request)

    This function validates the new User and 
    adds it to the database if it is valid.

    ****************************************************/
    public function store(Request $request)
    {
        // Validate the request
        $validated = $request->validate([
            'first_name' => 'required|string|max:50',
            'surname' => 'required|string|max:50',
            'job_title' => 'required|string|max:100',
            'username' => 'required|string|min:5|max:45|unique:users,username',
            'email' => 'required|email|max:100|unique:users,email',
            'manager_id' => 'nullable|exists:users,id',
            'roles' => 'required|array|min:1',
            'roles.*'    => 'exists:roles,id',
            'password' => 'required|min:5',
        ]);

        // Create the new validated User and add it to the database
        $user = User::create([
            'status' => 'Approved',
            'first_name' => $validated['first_name'],
            'last_name' => $validated['surname'],
            'job_title' => $validated['job_title'],
            'username' => $validated['username'],
            'email' => $validated['email'],
            'manager_id' => $validated['manager_id'],
            'password' => bcrypt($validated['password']),
            'created_by' => auth()->id(),
            'modified_by' => auth()->id(),
        ]);

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

        // Redirect to the show view to display the new User object and pass it a success message
        return redirect("users/$user->id")->with('success', 'The new User has been successfully added.');

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
        // Get the user object from the database
        $user = User::with('manager')->with('roles')->findOrFail($id);

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
        
        // Return the edit view and pass it the user object and arrays
        return view('admin.users.edit_form', [
            'user' => $user,
            'managers' => $managers,
            'roles' => $roles,
        ]);

    }


    /***************************************************

    update(Request $request, $id)

    This function updates the specified user object.

    ****************************************************/
    public function update(Request $request, $id)
    {
        // Get the user object
        $user = User::findOrFail($id);

        // Validate the request
        $validated = $request->validate([
            'first_name' => 'required|string|max:50',
            'surname' => 'required|string|max:50',
            'job_title' => 'required|string|max:100',
            'email' => 'required|email|max:100|unique:users,email,' . $user->id,
            'manager_id' => 'nullable|exists:users,id',
            'roles' => 'required|array|min:1',
            'roles.*'    => 'exists:roles,id',
        ]);

        // Update the validated User in the database for everything except password and roles
        $user->update([
            'first_name' => $validated['first_name'],
            'last_name' => $validated['surname'],
            'job_title' => $validated['job_title'],
            'email' => $validated['email'],
            'manager_id' => $validated['manager_id'],
            'modified_by' => auth()->id(),
        ]);

        // If the request includes a password
        if ($request->filled('password')) {

            // Validate the password
            $request->validate([
                'password' => 'required|min:5',
            ]);

            // Update the user's password
            $user->password = bcrypt($request->password);

            // Save the user's record to the database
            $user->save();
        }

        // Clear the existing roles from the user
        UsersRole::where('user_id', $user->id)->delete();

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

        // Redirect to the show view to display the updated User object and pass it a success message
        return redirect("users/$user->id")->with('success', 'The User has been successfully updated.');

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
            'job_title' => 'required|string|max:100',
            'manager_id' => 'nullable|exists:users,id',
            'roles' => 'required|array|min:1',
            'roles.*'    => 'exists:roles,id',
        ]);

        // Assign manager (if one was selected)
        $user->manager_id = $request->manager_id ?: null;

        // Update user record fields
        $user->status = 'Approved';
        $user->job_title = $validated['job_title'];
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
        // Get the user from the database
        $user = User::findOrFail($id);
        
        // Update the user in the database
        $user->update([
            'status' => 'Inactive',
            'modified_by' => auth()->id(),
        ]);

        // Redirect to the show view to display the updated User object and pass it a success message
        return redirect("users/$user->id")->with('success', 'The User has been successfully deactivated.');

    }


    /***************************************************

    reactivate($id)

    This function reactivates the user object.

    ****************************************************/
    public function reactivate($id)
    {
        // Get the user from the database
        $user = User::findOrFail($id);
        
        // Update the user in the database
        $user->update([
            'status' => 'Approved',
            'modified_by' => auth()->id(),
        ]);

        // Redirect to the show view to display the updated User object and pass it a success message
        return redirect("users/$user->id")->with('success', 'The User has been successfully Reactivated.');        

    }

}
