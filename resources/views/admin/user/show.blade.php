<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Admin') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <form action="{{ route('admin.user.edit', $user->id) }}" method="POST" class="p-3" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="name" class="form-label">Name:</label>
                        <input type="text" id="name" name="name" class="form-control" value="{{ old('name', $user->name) }}" required>
                        @error('name') <div class="text-danger">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Email:</label>
                        <input type="email" id="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required>
                        @error('email') <div class="text-danger">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-3">
                        <label for="phone_number" class="form-label">Phone number:</label>
                        <input type="text" id="phone_number" name="phone_number" class="form-control" value="{{ old('phone_number', $user->phone_number) }}">
                    </div>

                    <div class="mb-3">
                        <label for="status" class="form-label">Status:</label>
                        <select id="status" name="status" class="form-control">
                            <option value="active" {{ $user->status === "active" ? "selected" : "" }}>Active</option>
                            <option value="inactive" {{ $user->status === "inactive" ? "selected" : "" }}>Inactive</option>
                            <option value="banned" {{ $user->status === "banned" ? "selected" : "" }}>Banned</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="photos" class="form-label">Photo:</label>
                        @if($user->profile_photo_path)
                            <td>
                                <img src="{{ asset('storage/' . $user->profile_photo_path) }}" alt="profile-image" class="img-thumbnail" width="150px">
                            </td>
                        @else
                            <td>
                                <img src="{{ $user->profile_photo_url }}" alt="profile-image" class="img-thumbnail" width="150px">
                            </td>
                        @endif
                    </div>

                    <div class="mt-4">
                        <x-label for="password" value="{{ __('Password') }}" />
                        <x-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" />
                    </div>

                    <div class="mt-4">
                        <x-label for="password_confirmation" value="{{ __('Confirm Password') }}" />
                        <x-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required autocomplete="new-password" />
                    </div>

                    <div class="mt-4 mb-4">
                        <x-label for="photo" value="{{ __('Photo') }}"/>
                        <x-input id="photo" class="block mt-1 w-full" type="file" name="photo"/>
                    </div>

                    <button type="submit" class="btn btn-primary">Update</button>
                    <a href="{{ url('/admin') }}" class="btn btn-secondary">Cancel</a>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
