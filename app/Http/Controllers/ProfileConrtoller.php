<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileConrtoller extends Controller
{
    public function index()
    {
        $user = Auth::user();
        return view('profile.index', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'nullable|string',
            'email' => 'nullable|email|unique:users,email,' . $user->id,
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        return redirect()->route('index_profile')->with('success', 'اطلاعات با موفقیت ویرایش شد');
    }

    public function orders()
    {
        $orders = Auth::user()
            ->orders()
            ->with(['address.city', 'orderItems.product'])
            ->latest()
            ->paginate(2);

        return view('profile.order', compact('orders'));
    }

    public function transaction()
    {
        $transactions = Auth::user()->transactions()->latest()->paginate(3);

        return view('profile.transactions', compact('transactions'));
    }
}
