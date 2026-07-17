<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Province;
use App\Models\UserAddres;
use App\Models\UserAddress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AddressController extends Controller
{
    public function index()
    {
        $addresses = UserAddress::all();
        // dd($addresses);
        return view('profile.addresses.index', compact('addresses'));
    }

    public function create()
    {
        $provinces = Province::all();
        $cities = City::select('id', 'name', 'province_id')->get();
        return view('profile.addresses.create', compact('cities', 'provinces'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'cellphone' => ['required', 'regex:/^09[0-3]\d{8}$/'],
            'postal_code' => ['required', 'regex:/^\d{5}[ -]?\d{5}$/'],
            'province_id' => 'required|integer',
            'city_id' => 'required|integer',
            'address' => 'required|string',
        ]);
        // dd($request->all());

        UserAddress::create([
            'user_id' => Auth::id(),
            'cellphone' => $request->cellphone,
            'postal_code' => $request->postal_code,
            'province_id' => $request->province_id,
            'city_id' => $request->city_id,
            'address' => $request->address,
        ]);

        return redirect()->route('addresses')->with('success', 'آدرس شما با موفقیت ثبت شد');
    }

    public function edit(UserAddress $address)
    {
        // dd($address);
        $provinces = Province::all();
        $cities = City::select('id', 'name', 'province_id')->get();
        return view('profile.addresses.edit', compact('cities', 'provinces', 'address'));
    }

    public function update(Request $request, UserAddress $address)
    {
        $request->validate([
            'cellphone' => ['required', 'regex:/^09[0-3]\d{8}$/'],
            'postal_code' => ['required', 'regex:/^\d{5}[ -]?\d{5}$/'],
            'province_id' => 'required|integer',
            'city_id' => 'required|integer',
            'address' => 'required|string',
        ]);
        // dd($request->all());

        $address->update([
            'cellphone' => $request->cellphone,
            'postal_code' => $request->postal_code,
            'province_id' => $request->province_id,
            'city_id' => $request->city_id,
            'address' => $request->address,
        ]);
        // dd($address);
        return redirect()->route('addresses')->with('success', 'آدرس شما با موفقیت ویرایش شد');
    }

    public function destroy(UserAddress $address)
    {
        $address->delete();
        return redirect()->route('addresses')->with('warning', 'آدرس با موفقیت حذف شد');
    }
}
