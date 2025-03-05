<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Admin') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <a href="http://127.0.0.1:8000/user/create" class="p-3 btn btn-info">Add new user</a>
                <x-welcome />
                <table class="table">
                    <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Photo</th>
                        <th scope="col">Name</th>
                        <th scope="col">Email</th>
                        <th scope="col">Status</th>
                        <th scope="col">Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($users as $user)
                        <tr>
                            <th scope="row">{{ $user->id }}</th>
                            @if($user->profile_photo_path)
                                <td>
                                    <img src="{{ asset('storage/' . $user->profile_photo_path) }}" alt="profile-image" class="img-thumbnail" width="150px">
                                </td>
                            @else
                                <td>
                                    <img src="{{ $user->profile_photo_url }}" alt="profile-image" class="img-thumbnail" width="150px">
                                </td>
                            @endif
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->status }}</td>
                            <td>
                                <form action="{{ route('admin.user.show', $user->id) }}" method="GET" onsubmit="return confirm('Are you sure you want to edit this user?')">
                                    @csrf
                                    @method('GET')
                                    <button type="submit" class="btn btn-warning">Edit</button>
                                </form>
                                <form action="{{ route('admin.user.delete', $user->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this user?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                {{ $users->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
