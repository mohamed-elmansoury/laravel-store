@extends('layout.dashboard')
@section('title', 'profile')

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">Edit Profile</li>
@endsection


@section('content')

    <div class="container mt-4">

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <form action="{{ route('dashboard.profile.update') }}" method="POST"  enctype="multipart/form-data">
            @csrf
            @method('patch')

            <div class="mb-3">
                <label for="first_name" class="form-label">First Name</label>
                <input type="text" name="first_name" class="form-control @error('first_name') is-invalid @enderror"
                    value="{{ old('first_name', $user->profile->first_name) }}">
                @error('first_name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="last_name" class="form-label">Last Name</label>
                <input type="text" name="last_name" class="form-control @error('last_name') is-invalid @enderror"
                    value="{{ old('last_name', $user->profile->last_name) }}">
                @error('last_name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="birthday" class="form-label">Birthday</label>
                <input type="date" name="birthday" class="form-control @error('birthday') is-invalid @enderror"
                    value="{{ old('birthday', $user->profile->birthday) }}">
                @error('birthday')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label class="form-label">Gender</label>
                <div>
                    <input type="radio" name="gender" value="male"
                        {{ old('gender', $user->profile->gender ?? '') == 'male' ? 'checked' : '' }}> Male
                    <input type="radio" name="gender" value="female"
                        {{ old('gender', $user->profile->gender ?? '') == 'female' ? 'checked' : '' }}> Female
                </div>
                @error('gender')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>


            <div class="mb-3">
                <label for="country" class="form-label">Country</label>
                <select name="country" class="form-select @error('country') is-invalid @enderror">
                    @foreach ($countries as $code => $name)
                        <option value="{{ $code }}"
                            {{ old('country', $user->profile->country) == $code ? 'selected' : '' }}>{{ $name }}
                        </option>
                    @endforeach
                </select>
                @error('country')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="city" class="form-label">City</label>
                <input type="text"" name="city" class="form-control @error('city') is-invalid @enderror"
                    value="{{ old('city', $user->profile->city) }}">
                @error('city')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="postal_code" class="form-label">Postel Code</label>
                <input type="text" id="postal_code" name="postal_code"
                    class="form-control @error('postal_code') is-invalid @enderror"
                    value="{{ old('postal_code', $user->profile->postal_code) }}">
                @error('postal_code')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="street_address" class="form-label">street_address</label>
                <input type="text" id="street_address" name="street_address"
                    class="form-control @error('street_address') is-invalid @enderror"
                    value="{{ old('street_address', $user->profile->street_address) }}">
                @error('street_address')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="locale" class="form-label">language</label>
                <select id="locale" name="locale" class="form-select @error('locale') is-invalid @enderror">
                    @foreach ($locales as $code => $name)
                        <option value="{{ $code }}"
                            {{ old('locale', $user->profile->locale) == $code ? 'selected' : '' }}>{{ $name }}
                        </option>
                    @endforeach
                </select>
                @error('locale')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary"> save </button>
        </form>


    </div>

@endsection
