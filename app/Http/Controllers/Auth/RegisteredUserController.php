<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\View\View;
use Illuminate\Http\Request;
//use Intervention\Image\Image;
use Illuminate\Validation\Rules;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Storage;
//use Intervention\Image\ImageManagerStatic as Image;
use Intervention\Image\Laravel\Facades\Image;


class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $file = $request->file('image');
        $fileName = hexdec(uniqid()).'.'.$file->getClientOriginalExtension();

        $image = Image::read($file)->resize(150,150);

        $uploadPath = 'users/'.$fileName;
        Storage::put($uploadPath, $image->encodeByExtension($file->getClientOriginalExtension(), quality: 70));

        $user = User::create([
            'name' => $request->name,
             'description' => $request->description,
            'image' => $uploadPath,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('dashboard', absolute: false));
    }
}
