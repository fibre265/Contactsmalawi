
@extends('layouts.generalLayout')
@section('content')
<br><br>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">{{ __('Login') }}</div>

                                <div class="card-body">
                                <form method="POST" action="{{ route('register') }}">
    @csrf

    <!-- Name -->
    <div class="form-group">
        <label for="name">Name:</label>
        <input type="text" name="name" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" id="name" value="{{ old('name') }}" required autofocus>
        @if ($errors->has('name'))
            <span class="invalid-feedback">
                <strong>{{ $errors->first('name') }}</strong>
            </span>
        @endif
    </div>

    <!-- Region -->
    <!-- <div class="form-group">
        <label for="region">Region:</label>
        <select name="region_id" class="form-control{{ $errors->has('region_id') ? ' is-invalid' : '' }}" id="region" required>
            <option disabled selected>-Select-</option>
            @foreach ($regions as $region)
                <option value="{{ $region->id }}">{{ $region->region }}</option>
            @endforeach
        </select>
        @if ($errors->has('region_id'))
            <span class="invalid-feedback">
                <strong>{{ $errors->first('region_id') }}</strong>
            </span>
        @endif
    </div> -->

    <!-- District -->
    <div class="form-group">
        <label for="district">District:</label>
        <select name="district_id" class="form-control{{ $errors->has('district_id') ? ' is-invalid' : '' }}" id="district" required>
            <option disabled selected>-Select-</option>
            @foreach ($districts as $district)
                <option value="{{ $district->id }}">{{ $district->district }}</option>
            @endforeach
        </select>
        @if ($errors->has('district_id'))
            <span class="invalid-feedback">
                <strong>{{ $errors->first('district_id') }}</strong>
            </span>
        @endif
    </div>

    <!-- Township -->
    <div class="form-group">
        <label for="township">Township:</label>
        <input type="text" name="township" class="form-control{{ $errors->has('township') ? ' is-invalid' : '' }}" id="township" value="{{ old('township') }}" required>
        @if ($errors->has('township'))
            <span class="invalid-feedback">
                <strong>{{ $errors->first('township') }}</strong>
            </span>
        @endif
    </div>

    <!-- Phone Number -->
    <div class="form-group">
        <label for="email">Phone Number:</label>
        <input type="text" name="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" id="email" required>
        @if ($errors->has('email'))
            <span class="invalid-feedback">
                <strong>{{ $errors->first('email') }}</strong>
            </span>
        @endif
    </div>

    <!-- Password -->
    <div class="form-group">
        <label for="password">Password:</label>
        <input type="password" name="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" id="password" required>
        @if ($errors->has('password'))
            <span class="invalid-feedback">
                <strong>{{ $errors->first('password') }}</strong>
            </span>
        @endif
    </div>

    <!-- Confirm Password -->
    <div class="form-group">
        <label for="password_confirmation">Confirm Password:</label>
        <input type="password" name="password_confirmation" class="form-control{{ $errors->has('password_confirmation') ? ' is-invalid' : '' }}" id="password_confirmation" required>
        @if ($errors->has('password_confirmation'))
            <span class="invalid-feedback">
                <strong>{{ $errors->first('password_confirmation') }}</strong>
            </span>
        @endif
    </div>

    <!-- Register Button -->
    <button type="submit" class="btn btn-primary">Register</button>
</form>


               </div>
            </div>
        </div>
    </div>
</div>
@endsection


