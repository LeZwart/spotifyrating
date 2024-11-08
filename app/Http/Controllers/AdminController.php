<?php

namespace App\Http\Controllers;

use App\Http\Requests\AdminUserEditRequest;
use App\Models\User;
use App\Models\Artist;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard() {
        return view('admin.dashboard');
    }

    public function users() {
        $users = User::all();
        $userCount = $users->count();
        return view('admin.users', compact('users'))->with('status', "$userCount users returned");
    }

    public function destroyUser(User $user) {
        if ($user->delete()) {
            return redirect()->route('admin.users')->with('success', 'User deleted successfully');
        } else {
            return redirect()->route('admin.users')->with('error', 'Failed to delete user');
        }
    }

    public function editUser(User $user) {
        return view('admin.edit-user', compact('user'));
    }

    public function updateUser(AdminUserEditRequest $request, User $user) {
        $request = $request->validated();

        if (isset($request['is_admin'])) {
            $user->role = 'admin';
        }

        $user->update($request);
        return redirect()->route('admin.users')->with('success', 'User updated successfully');
    }

    public function artists() {
        $artists = Artist::all()->sortByDesc('followers');
        return view('admin.artists', compact('artists'));
    }
}
