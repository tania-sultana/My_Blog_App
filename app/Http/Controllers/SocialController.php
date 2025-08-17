<?php

namespace App\Http\Controllers;

use App\Models\Social;
use Illuminate\Http\Request;

class SocialController extends Controller
{
    public function view()
    {
        $countSocial = Social::count();
        $allData = Social::all();
        return view('backend.social.view_social', compact('allData','countSocial'));
    }
    public function add()
    {
        return view('backend.social.add_social');
    }
    public function store(Request $request)
    {

        $validateData = $request->validate([
            'facebook' => ' required',
            'linkedin' => ' required',
            'twitter' => ' required',
            'youtube' => ' required',
        ]);
        $data = new Social();
        $data->facebook = $request->facebook;
        $data->linkedin = $request->linkedin;
        $data->twitter = $request->facebook;
        $data->youtube = $request->youtube;
        $data->save();
        return redirect()->route('view.social');
    }
    public function edit($id)
    {
        $updateData = Social::findOrFail($id);
        return view('backend.social.edit_social', compact('updateData'));
    }
    public function update(Request $request, $id)
    {
        $updateData = Social::find($id);
        $updateData->facebook = $request->facebook;
        $updateData->linkedin = $request->linkedin;
        $updateData->twitter = $request->facebook;
        $updateData->youtube = $request->youtube;
        $updateData->update();
        $notification = array(
            'message' => 'Social update successfully.',
                'alert-type' => 'success'
        );
         return redirect()->route('view.social')->with($notification);
    }
    public function delete($id)
    {
         $deleteDAta = Social::find($id);
        $deleteDAta->delete();
        $notification = array(
            'message' => 'Social delete successfully.',
                'alert-type' => 'success'
        );
         return redirect()->back()->with($notification);
    }
}
