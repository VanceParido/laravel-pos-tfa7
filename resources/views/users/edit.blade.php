@extends('layouts.app')

@section('content')
    <h1>Edit User</h1>

    <form
        action="{{ route('users.update', $user) }}"
        method="POST"
        enctype="multipart/form-data"
    >
        @csrf
        @method('PUT')

        <div>
            <label for="username">Username</label><br>
            <input
                type="text"
                id="username"
                name="username"
                value="{{ old('username', $user->username) }}"
                maxlength="255"
                required
            >

            @error('username')
                <p style="color: #b91c1c;">{{ $message }}</p>
            @enderror
        </div>

        <br>

        <div>
            <label for="full_name">Full Name</label><br>
            <input
                type="text"
                id="full_name"
                name="full_name"
                value="{{ old('full_name', $user->full_name) }}"
                maxlength="255"
                required
            >

            @error('full_name')
                <p style="color: #b91c1c;">{{ $message }}</p>
            @enderror
        </div>

        <br>

        @if ($user->avatar)
            <div>
                <p>Current Profile Picture</p>
                <img
                    src="{{ asset('storage/' . $user->avatar) }}"
                    alt="Profile picture of {{ $user->full_name }}"
                    width="100"
                    height="100"
                    style="object-fit: cover; border-radius: 8px;"
                >
            </div>

            <br>
        @endif

        <div>
            <label for="avatar">Profile Picture</label><br>
            <input
                type="file"
                id="avatar"
                name="avatar"
                accept="image/jpeg,image/png,image/webp"
                aria-describedby="avatar-help"
            >

            <p id="avatar-help">
                JPG, PNG, or WebP. Maximum 2 MB and 4096 × 4096 pixels.
                Leave empty to keep your current picture.
            </p>

            @error('avatar')
                <p style="color: #b91c1c;">{{ $message }}</p>
            @enderror
        </div>

        <br>

        <button type="submit">Update User</button>
        <a href="{{ route('users.index') }}">Cancel</a>
    </form>
@endsection