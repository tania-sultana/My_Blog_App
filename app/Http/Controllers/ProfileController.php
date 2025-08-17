<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\ImageManager;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\ProfileUpdateRequest;
use Intervention\Image\Laravel\Facades\Image;

class ProfileController extends Controller
{

    public function edit(Request $request): View
    {

        $id = Auth::user()->id;
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
        $userData->name = $request->name;
        $userData->description = $request->description;
        if ($request->hasFile('image')) {
            if ($userData->image && Storage::exists($userData->image)) {
               Storage::delete($userData->image);
            }

            $file = $request->file('image');
            $fileName = time() . '.' . $file->getClientOriginalExtension();
            $image = Image::read($file)->resize(150,150);

            $uploadPath = 'users/'.$fileName;
            Storage::put($uploadPath, $image->encodeByExtension($file->getClientOriginalExtension(), quality: 70));

            $userData->image = $uploadPath;
        }
        $userData->save();
        return redirect()->back();
    }




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
        $request->validate([
            'oldpassword' => 'required',
            'new_password' => 'required',
            'confirm_password' => 'required|same:new_password',
        ]);
        $hashPassword = Auth::user()->password;
        if (Hash::check($request->oldpassword, $hashPassword)) {
            /**@var App\Models\User $user */
            $user = Auth::user();
            $user->password = bcrypt($request->new_password);
            $user->save();
            Auth::logout();
            $notification = array(
                'message' => 'Password changed successfully! Please login again.',
                'alert-type' => 'success'

            );
            return redirect()->route('login')->with($notification);
        } else {
            return back()->with([
                'message' => 'Opps! The current password is incorrect.',
                'alert-type' => 'error'
            ]);
        }
    }
    
}
