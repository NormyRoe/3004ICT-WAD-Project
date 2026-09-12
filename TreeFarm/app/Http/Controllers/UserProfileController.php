<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use App\Models\UsersRole;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules;

class UserProfileController extends Controller
{

    /***************************************************

    show($id)

    This function displays the User's profile.

    ****************************************************/
    public function show($id)
    {
        // Create a blocked message variable
        $blocked = NULL;

        // Check that the id belongs to the logged in user
        if ($id != auth()->id())
        {
            // Set the blocked message
            $blocked = "You are not allowed to view/edit another user's profile.  Therefore, you are only being provided with your profile.";

            // Set the id as being the logged in user's id
            $id = auth()->id();
            
        }

        // Get the user object
        $user = User::with('manager')->with('roles')->findOrFail($id);

        // Return the show view and pass it the user object and the blocked message
        return view('menu_top.profile.show', [
            'user' => $user,
            'blocked' => $blocked,
        ]);

    }


    /***************************************************

    update(Request $request, $id)

    This function updates the specified user object.

    ****************************************************/
    public function update(Request $request, $id)
    {

        // Check that the id belongs to the logged in user
        if ($id != auth()->id())
        {
            // Get the correct id
            $correct_id = auth()->id();

            // Redirect to the show view to and pass it a reject message
            return redirect("user_profile/$correct_id")->with('reject', "You are not allowed to update another user's profile.");
            
        }
        
        // Get the user object
        $user = User::findOrFail($id);

        // Validate the submitted fields
        $validated = $request->validate([
            'username'   => 'nullable|string|min:5|max:45|unique:users,username,' . $user->id,
            'email'      => 'nullable|email|max:100|unique:users,email,' . $user->id,
            'password' => ['nullable', 'confirmed', Rules\Password::min(8)
                                                                    ->mixedCase()
                                                                    ->letters()
                                                                    ->numbers()
                                                                    ->symbols()],
        ]);

        // If validated includes a username
        if (!empty($validated['username'])) {

            // Update the user's username
            $user->username = $validated['username'];

        }

        // If validated includes an email address
        if (!empty($validated['email'])) {

            // Update the user's email address
            $user->email = $validated['email'];
                        
        }

        // If validated includes a password
        if (!empty($validated['password'])) {

            // Update the user's password
            $user->password = bcrypt($validated['password']);

        }

        // Save the user's record to the database
        $user->save();

        // Redirect to the show view to display the updated User profile and pass it a success message
        return redirect("user_profile/$user->id")->with('success', 'Your profile has been successfully updated.');

    }

}
