<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;

class UsersController extends Controller
{
    public function index()
    {
        $users = User::where('is_admin', false)
            ->withCount('orders')
            ->latest()->paginate(20);

        return view('admin.users.index', compact('users'));
    }
}