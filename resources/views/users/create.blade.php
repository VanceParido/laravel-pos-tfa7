@extends('layouts.app')

@section('content')
    <h1>Create User</h1>

    <form action="{{ route('users.store') }}" method="POST">
        @csrf

        <div>
            <label for="username">Username</label><br>
            <input
                type="text"
                id="username"
                name="username"
                value="{{ old('username') }}"
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
                value="{{ old('full_name') }}"
                maxlength="255"
                required
            >

            @error('full_name')
                <p style="color: #b91c1c;">{{ $message }}</p>
            @enderror
        </div>

        <br>

        <button type="submit">Save User</button>
        <a href="{{ route('users.index') }}">Cancel</a>
    </form>
@endsection