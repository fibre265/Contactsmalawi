
@extends('layouts.generalLayout')
@section('content')
<br><br>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">{{ __('Updating') }}</div>

                                <div class="card-body">
                                <form action="{{ route('tikonzeroutename', $user->id) }}" method="POST" enctype="multipart/form-data" >
                                        @csrf
                                       
                                        <!-- Name -->
                                        <div class="form-group">
                                            <label for="township">Name:</label>
                                            <input type="text" name="name" class="form-control{{ $errors->has('township') ? ' is-invalid' : '' }}" id="township" value="{{ $user->name }}" required>
                                            @if ($errors->has('township'))
                                                <span class="invalid-feedback">
                                                    <strong></strong>
                                                </span>
                                            @endif
                                        </div>
                                        <input type="hidden" name="user_id" value="{{ $user->id }}" required>
                                           

                                        <div class="form-group">
                                            <label for="district">District:</label>
                                            <select name="district_id" class="form-control{{ $errors->has('district_id') ? ' is-invalid' : '' }}" id="district" value="{{ $user->district_id }}">
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
                                            <input type="text" name="township" class="form-control{{ $errors->has('township') ? ' is-invalid' : '' }}" id="township" value="{{ $user->township }}" required>
                                            @if ($errors->has('township'))
                                                <span class="invalid-feedback">
                                                    <strong></strong>
                                                </span>
                                            @endif
                                        </div>

                                        <!-- Phone Number -->
                                        <div class="form-group">
                                            <label for="email">Phone Number:</label>
                                            <input type="text" name="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" id="email" value="{{ $user->email }}" required>
                                            @if ($errors->has('email'))
                                                <span class="invalid-feedback">
                                                    <strong>{{ $errors->first('email') }}</strong>
                                                </span>
                                            @endif
                                        </div>

                                        <!-- Password -->
                                        <div class="form-group">
                                            <label for="password">Password:</label>
                                            <input type="password" name="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" id="password" value="{{ $user->password }}"  required>
                                            @if ($errors->has('password'))
                                                <span class="invalid-feedback">
                                                    <strong>{{ $errors->first('password') }}</strong>
                                                </span>
                                            @endif
                                        </div>

                                        <!-- Confirm Password -->
                                        <div class="form-group">
                                            <label for="password_confirmation">Confirm Password:</label>
                                            <input type="password" name="password_confirmation" class="form-control{{ $errors->has('password_confirmation') ? ' is-invalid' : '' }}" id="password_confirmation"  value="{{ $user->password }}"  required>
                                            @if ($errors->has('password_confirmation'))
                                                <span class="invalid-feedback">
                                                    <strong>{{ $errors->first('password_confirmation') }}</strong>
                                                </span>
                                            @endif
                                        </div>

                                        <!-- Register Button -->
                                        <button type="submit" class="btn btn-primary">Update</button>
                                    </form>


               </div>
            </div>
        </div>
    </div>
</div>
@endsection


