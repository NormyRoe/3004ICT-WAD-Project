<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        //return view('auth.register');
        return view('registration');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        // Validate the submitted fields
        $request->validate([
            'first_name' => ['required', 'string', 'max:50'],
            'surname'    => ['required', 'string', 'max:50'],
            'username'   => ['required', 'string', 'min:5', 'max:45', 'unique:users,username'],
            'email'      => ['required', 'string', 'email', 'max:100', 'unique:users,email'],
            'password' => ['required', 'confirmed', Rules\Password::min(8)
                                                                    ->mixedCase()
                                                                    ->letters()
                                                                    ->numbers()
                                                                    ->symbols()],
        ]);

        $user = User::create([
            'first_name'  => $request->first_name,
            'last_name'   => $request->surname,
            'username'    => $request->username,
            'email'       => $request->email,
            'password' => Hash::make($request->password),
            'status'      => 'For Approval',
            'created_by'  => null,
            'modified_by' => null,
        ]);

        event(new Registered($user));

        // This is to automatically log in a user
        // Not needed in this application
        //Auth::login($user);

        // Redirect the user to the signin page
        return redirect()
                ->route('signin')
                ->with('status', 'Your account has been created and is awaiting approval.');

    }
}
