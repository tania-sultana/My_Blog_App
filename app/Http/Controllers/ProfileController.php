<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\ProfileUpdateRequest;
use Intervention\Image\Laravel\Facades\Image;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
    //     return view('profile.edit', [
    //         'user' => $request->user(),
    //     ]);
    //
    $id =Auth::user()->id;
    $userData = User::find($id);
    return view('frontend.layouts.profile.profile', compact('userData'));
    }


    /**
     * Update the user's profile information.
     */
    // public function update(ProfileUpdateRequest $request, $id): RedirectResponse
    // {
    //     dd($id);
    //     $request->user()->fill($request->validated());

    //     if ($request->user()->isDirty('email')) {
    //         $request->user()->email_verified_at = null;
    //     }

    //     $request->user()->save();

    //     return Redirect::route('profile.edit')->with('status', 'profile-updated');
    // }
 public function update(Request $request, $id)
 {
//    dd($request->all());

   $validateData = $request->validate([
    'name' => 'required',
    'description' => 'required'
   ]);
   $userData = User::findOrFail($id);
   $userData ->name = $request->name;
   $userData ->description = $request->description;
   if($request->hasFile('image')){
    if($userData->image && File::exists(public_path($userData->image))){
        File::delete(public_path($userData->image));
    }

   $image = $request->file('image');
   $filename = time().'.'. $image->getClientOriginalExtension();
   $path = public_path('backend/assets/image. $filename');
   Image::make($image)->fit(300, 300)->save($path);
   $userData->image = 'backend/assets/image/' . $filename;
}
   $userData->save();
   return redirect()->back();

 }
    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
    public function passwordChange()
    {
        return view('backend.admin.password-change');
    }
    public function updatePassword(Request $request)

    {
        dd($request->all());
    }
}
