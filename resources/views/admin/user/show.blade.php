<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Admin') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <form action="{{ route('admin.user.edit', $user->id) }}" method="POST" class="p-3">
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
                        <label for="status" class="form-label">Status:</label>
                        <select id="status" name="status" class="form-control">
                            <option value="active" {{ $user->status === "active" ? "selected" : "" }}>Active</option>
                            <option value="inactive" {{ $user->status === "inactive" ? "selected" : "" }}>Inactive</option>
                            <option value="banned" {{ $user->status === "banned" ? "selected" : "" }}>Banned</option>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-primary">Update</button>
                    <a href="{{ url('/admin') }}" class="btn btn-secondary">Cancel</a>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
