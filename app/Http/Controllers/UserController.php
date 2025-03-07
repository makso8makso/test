<?php

namespace App\Http\Controllers;

use App\Actions\Fortify\PasswordValidationRules;
use App\Models\Address;
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

        Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'phone_number' => ['nullable', 'string', 'max:255'],
            'profile_photo_path' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048', 'dimensions:max_width=400,max_height=400'],
            'addresses.*.country' => ['required_with:addresses', 'string'],
            'addresses.*.city' => ['required_with:addresses', 'string'],
            'addresses.*.postal_code' => ['required_with:addresses', 'string'],
            'addresses.*.address' => ['required_with:addresses', 'string'],
        ])->validate();

        if ($user->photo && Storage::exists($user->photo)) {
            Storage::delete($user->photo);
        }

        $photoPath = $user->photo;
        if (isset($request->all()['photo'])) {
            $photoPath = $request->all()['photo']->store('photos', 'public');
        }

        if ($user->email !== $request->all()['email'] && !User::where('email', $request->all()['email'])->exists()) {
            $user->email = $request->all()['email'];
        }

        $user->update([
            'name' => $request->all()['name'],
//            'email' => $request->all()['email'],
            'phone_number' => $request->all()['phone_number'],
            'profile_photo_path' => $photoPath,
        ]);

        foreach ($user->addresses as $address) {
            $address->delete();
        }

        $numberAddress = count($request->all()['country']);
        for ($i = 0; $i < $numberAddress; $i++) {
            $user->addresses()->create([
                'country' => $request->all()['country'][$i],
                'city' => $request->all()['city'][$i],
                'postal_code' => $request->all()['postal_code'][$i],
                'address' => $request->all()['address'][$i],
            ]);
        }

        $users = User::paginate(3);

        return redirect()->route('admin')->with('success', 'User updated successfully!')->with('users', $users);
    }

    public function delete($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        $users = User::paginate(3);
        return view('admin.index', compact('users'));
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

        $user = User::create([
            'name' => $request->all()['name'],
            'email' => $request->all()['email'],
            'phone_number' => $request->all()['phone_number'],
            'profile_photo_path' => $photoPath,
            'password' => Hash::make($request->all()['password']),
        ]);

        $numberAddress = count($request->all()['country']);
        for ($i = 0; $i < $numberAddress; $i++) {
            $user->addresses()->create([
                'country' => $request->all()['country'][$i],
                'city' => $request->all()['city'][$i],
                'postal_code' => $request->all()['postal_code'][$i],
                'address' => $request->all()['address'][$i],
            ]);
        }

        $users = User::paginate(3);

        return redirect()->route('admin')->with('success', 'User updated successfully!')->with('users', $users);
    }

    public function bulkUpdate(Request $request)
    {
        $validated = $request->validate([
            'user_ids' => 'array',
            'status' => 'in:active,inactive,banned',
        ]);

        User::whereIn('id', $validated['user_ids'])
            ->update(['status' => $validated['status']]);

        $users = User::paginate(3);

        return redirect()->route('admin')->with('success', 'Users updated successfully.')->with('users', $users);
    }
}
