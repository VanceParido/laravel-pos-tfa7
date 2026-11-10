@extends('layouts.app')

@section('content')
    <h1>Create Customer</h1>

    <form action="{{ route('customers.store') }}" method="POST">
        @csrf

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

        <div>
            <label for="email">Email Address</label><br>
            <input
                type="email"
                id="email"
                name="email"
                value="{{ old('email') }}"
                maxlength="255"
                required
            >

            @error('email')
                <p style="color: #b91c1c;">{{ $message }}</p>
            @enderror
        </div>

        <br>

        <div>
            <label for="phone">Phone Number</label><br>
            <input
                type="tel"
                id="phone"
                name="phone"
                value="{{ old('phone') }}"
                maxlength="20"
                required
            >

            @error('phone')
                <p style="color: #b91c1c;">{{ $message }}</p>
            @enderror
        </div>

        <br>

        <button type="submit">Save Customer</button>
        <a href="{{ route('customers.index') }}">Cancel</a>
    </form>
@endsection