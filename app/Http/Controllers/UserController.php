<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        return view('profile.index', compact('user'));
    }

    public function update(Request $request, User $user)
    {

        dd(Auth::user());
        $validatedData = $request->validate(User::$rules);

        $validatedData['sellPrice'] = floatval(str_replace(',', '', $validatedData['sellPrice']));
        $validatedData['buyPrice'] = floatval(str_replace(',', '', $validatedData['buyPrice']));

        // Handle image upload
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->storeAs('public/images', $imageName);
            $validatedData['image'] = $imageName;
        }
        User::where('id', request('id'))->update($validatedData);

        return redirect('/profile')->with('success', 'User telah berhasil diubah');
    }
}
