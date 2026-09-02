<?php

namespace App\Http\Requests\Auth;

use Illuminate\Auth\Events\Lockout;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class LoginRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'login' => ['required', 'string'],
            'password' => ['required', 'string'],
        ];
    }

    /**
     * Attempt to authenticate the request's credentials.
     *
     * @throws ValidationException
     */
    public function authenticate(): void
    {
        // Before attempting login, check if the user has exceeded the allowed number of attempts.
        // Breeze uses rate limiting to prevent brute-force attacks.
        $this->ensureIsNotRateLimited();

        /***************************************************

         Determine whether the user typed an email or a username

         The 'login' field is whatever the user typed into the custom
         "Username or Email" input box.
     
         We check if the value is a valid email format.
         - If yes → use the 'email' column in the database.
         - If no → use the 'username' column in the database.

        ****************************************************/
        $field = filter_var($this->input('login'), FILTER_VALIDATE_EMAIL)
            ? 'email'      // If the input looks like an email, authenticate using the email column
            : 'username';  // Otherwise authenticate using the username column


        /***************************************************

         Build the credentials array dynamically

         Example:
         If the user typed "ella@example.com":
            $field = 'email'
            $credentials = ['email' => 'ella@example.com', 'password' => '...']
     
         If the user typed "ella99":
            $field = 'username'
            $credentials = ['username' => 'ella99', 'password' => '...']
        
         Auth::attempt() will automatically check the correct column.

        ****************************************************/
        $credentials = [
            $field => $this->input('login'),
            'password' => $this->input('password'),
            'status' => 'Approved',
        ];


        /***************************************************

         Attempt authentication using the correct field

         Auth::attempt() checks the database for:
            WHERE $field = login_value AND password = hashed_password
     
         So if $field = 'username', it checks the username column.
         If $field = 'email', it checks the email column.

        ****************************************************/
        if (! Auth::attempt($credentials, $this->boolean('remember'))) {

            // If authentication fails, increase the rate limit counter.
            RateLimiter::hit($this->throttleKey());

            // Throw a validation error back to the login page.
            throw ValidationException::withMessages([
                'login' => trans('auth.failed'),
            ]);
        }

        // If authentication succeeds, clear the rate limit counter.
        RateLimiter::clear($this->throttleKey());
    }

    /**
     * Ensure the login request is not rate limited.
     *
     * @throws ValidationException
     */
    public function ensureIsNotRateLimited(): void
    {
        if (! RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return;
        }

        event(new Lockout($this));

        $seconds = RateLimiter::availableIn($this->throttleKey());

        throw ValidationException::withMessages([
            'login' => trans('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }

    /**
     * Get the rate limiting throttle key for the request.
     */
    public function throttleKey(): string
    {
        return Str::transliterate(Str::lower($this->string('login')).'|'.$this->ip());
    }
}
