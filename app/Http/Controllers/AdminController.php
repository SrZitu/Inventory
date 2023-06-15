<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use App\Providers\RouteServiceProvider;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;

class AdminController extends Controller
{
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();
        $notification = [
            'message' => 'Successfully Logged Out',
            'alert-type' => 'success',
        ];
        return redirect('/login')->with($notification);
    }

    public function profile()
    {
        $id = Auth::user()->id;
        $adminData = User::find($id);
        return view('admin.admin_profile_view', compact('adminData'));
    }

    public function editProfile()
    {
        $id = Auth::user()->id;
        $editData = User::find($id);
        return view('admin.admin_profile_edit', compact('editData'));
    }

    public function storeProfile(Request $request)
    {
        $id = Auth::user()->id;
        $data = User::find($id);
        $data->name = $request->name;
        $data->email = $request->email;
        $data->username = $request->username;

        if ($request->file('profile_image')) {
            $img = $request->file('profile_image');
            $imgName = date('YmdHi') . $img->getClientOriginalName();
            $img->move(public_path('upload/admin_images'), $imgName);
            $data['profile_image'] = $imgName;
        }
        $data->save();
        $notification = [
            'message' => 'Admin profile Updated Successfully',
            'alert-type' => 'success',
        ];
        return redirect()
            ->route('admin.profile')
            ->with($notification);
    }
}
