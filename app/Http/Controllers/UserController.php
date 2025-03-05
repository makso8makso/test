<?php

namespace App\Http\Controllers;

use App\Actions\Fortify\PasswordValidationRules;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Jetstream\Jetstream;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    use PasswordValidationRules;

    public function index()
    {
        $users = User::paginate(3);

        return view('admin.index', compact('users'));
    }

    public function show($id)
    {
        $user = User::findOrFail($id);
        return view('admin.user.show', compact('user'));
    }

    public function edit(Request $request, $id)
    {
        $user = User::findOrFail($id);
        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        $user->update($request->all());

        $users = User::paginate(3);

        return view('admin.index', compact('users'));
    }

    public function delete($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('admin')
        ->with('success', 'User deleted successfully.');
    }

    public function create()
    {
        return view('admin.user.create');
    }

    public function store(Request $request)
    {
        Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'phone_number' => ['nullable', 'string', 'max:255'],
            'profile_photo_path' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048', 'dimensions:max_width=400,max_height=400'],
            'password' => $this->passwordRules(),
            'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['accepted', 'required'] : '',
        ])->validate();

        $photoPath = null;
        if (isset($request->all()['photo'])) {
            $photoPath = $request->all()['photo']->store('photos', 'public');
        }

        User::create([
            'name' => $request->all()['name'],
            'email' => $request->all()['email'],
            'phone_number' => $request->all()['phone_number'],
            'profile_photo_path' => $photoPath,
            'password' => Hash::make($request->all()['password']),
        ]);

        $users = User::paginate(3);

        return view('admin.index', compact('users'));
    }
}
