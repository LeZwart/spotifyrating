<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index() {
        return view('admin.dashboard');
    }

    public function users() {
        $users = User::all();
        return view('admin.users', compact('users'));
    }

    public function destroyUser(User $user) {
        if ($user->delete()) {
            return redirect()->route('admin.users')->with('success', 'User deleted successfully');
        } else {
            return redirect()->route('admin.users')->with('error', 'Failed to delete user');
        }
    }
}