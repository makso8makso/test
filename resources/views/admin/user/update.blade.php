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

                    <div class="mt-4 mb-4">
                        <x-label for="photo" value="{{ __('Choose photo') }}"/>
                        <x-input id="photo" class="block mt-1 w-full" type="file" name="photo"/>
                    </div>

                    <x-label for="addresses" value="{{ __('Addresses') }}" class="mt-3"/>
                    <div id="address" class="mb-4">
                        @foreach($user->addresses as $address)
                            <div class="mt-4 duplicateAddressDiv">
                                <hr>
                                <div class="mt-4 country">
                                    <x-label for="country" value="{{ __('Country') }}"/>
                                    <x-input id="country" class="block mt-1 w-full" type="text" value="{{ old('country.' . $loop->index, $address->country) }}" name="country[]"/>
                                </div>

                                <div class="mt-4 postal_code">
                                    <x-label for="postal_code" value="{{ __('Postal code') }}"/>
                                    <x-input id="postal_code" class="block mt-1 w-full" type="text" value="{{ old('postal_code' . $loop->index, $address->postal_code) }}" name="postal_code[]"/>
                                </div>

                                <div class="mt-4 city">
                                    <x-label for="city" value="{{ __('City') }}"/>
                                    <x-input id="city" class="block mt-1 w-full" type="text" value="{{ old('city' . $loop->index, $address->city) }}" name="city[]"/>
                                </div>

                                <div class="mt-4 address">
                                    <x-label for="address" value="{{ __('Address') }}"/>
                                    <x-input id="address" class="block mt-1 w-full" type="text" value="{{ old('address' . $loop->index, $address->address) }}" name="address[]"/>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div id="duplicateAddress" style="text-decoration: underline; color: blue; cursor: pointer; padding: 10px; border: lightblue;">
                        Add address
                    </div>
                    <div id="removeAddress" style="text-decoration: underline; color: blue; cursor: pointer; padding: 10px; border: lightblue;">
                        Remove address
                    </div>

                    <button type="submit" class="btn btn-primary">Update</button>
                    <a href="{{ url('/admin') }}" class="btn btn-secondary">Cancel</a>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>

<script>
    document.getElementById("duplicateAddress").addEventListener("click", function () {
        let duplicateAddressDiv = document.querySelector(".duplicateAddressDiv").cloneNode(true);
        document.getElementById("address").appendChild(duplicateAddressDiv);
    });
    document.getElementById("removeAddress").addEventListener("click", function () {
        let elements = document.querySelectorAll('.duplicateAddressDiv');
        if (elements.length > 0) {
            elements[elements.length - 1].remove();
        }
    });
</script>
