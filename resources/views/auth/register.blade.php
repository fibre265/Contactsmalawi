
@extends('layouts.generalLayout')
@section('content')
<br><br>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">{{ __('Login') }}</div>

                                <div class="card-body">
                                <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data">
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


    <div class="form-group">
        <label for="district">Category:</label>
        <select name="category_id" class="form-control{{ $errors->has('category_id') ? ' is-invalid' : '' }}" id="category" required>
            <option disabled selected>-Select-</option>
            @foreach ($categories as $category)
                <option value="{{ $category->id }}">{{ $category->category }}</option>
            @endforeach
        </select>
        @if ($errors->has('category_id'))
            <span class="invalid-feedback">
                <strong>{{ $errors->first('category_id') }}</strong>
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
    @if($pro)
        <!-- Picture Upload -->
        <div class="form-group">
        <label for="picture">Upload Picture:</label>
        <input type="file" name="picture" class="form-control{{ $errors->has('picture') ? ' is-invalid' : '' }}" id="picture" required>
        @if ($errors->has('picture'))
            <span class="invalid-feedback">
                <strong>{{ $errors->first('picture') }}</strong>
            </span>
        @endif
    </div>
    @endif
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


