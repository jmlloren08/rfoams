@extends('admin.admin_master')
@section('admin')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Profile</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Profile</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <!-- update user profile information -->
            <div class="row">
                <div class="col-xl-12">
                    <div class="card card-primary card-outline">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <h2 class="text-lg font-medium text-gray-900">Update Profile Information</h2>
                                </div>
                                <div class="col-md-12">
                                    <p class="mt-1 text-sm text-gray-600">Update your account's profile information and email address.</p>
                                </div>
                            </div>
                            <form id="send-verification" method="POST" action="{{ route('verification.send') }}">
                                @csrf
                            </form>
                            <form method="POST" action="{{ route('admin.profile.update') }}" class="mt-6 space-y-6">
                                @csrf
                                @method('PATCH')
                                <div class="row mt-3">
                                    <div class="col-md-6">
                                        <label for="name">Name</label>
                                        <input class="form-control @if($errors->has('name')) is-invalid @endif" type="text" id="name" name="name" value="{{ old('name', $user->name) }}" placeholder="Name" required>
                                        @if($errors->has('name'))
                                        <div class="invalid-feedback">
                                            {{ $errors->first('name')}}
                                        </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-md-6">
                                        <label for="email">Email</label>
                                        <input class="form-control @if($errors->has('email')) is-invalid @endif" type="email" id="email" name="email" value="{{ old('email', $user->email) }}" placeholder="Email" required>
                                        @if($errors->has('email'))
                                        <div class="invalid-feedback">
                                            {{ $errors->first('email')}}
                                        </div>
                                        @endif
                                        @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                                        <div>
                                            <p class="text-sm mt-2 text-gray-800">
                                                Your email address is unverified.
                                                <button form="send-verification" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                                    Click here to re-send the verification email.
                                                </button>
                                            </p>
                                            @if (session('status') === 'verification-link-sent')
                                            <p class="mt-2 font-medium text-sm text-green-600">
                                                A new verification link has been sent to your email address.
                                            </p>
                                            @endif
                                        </div>
                                        @endif
                                    </div>
                                    <div class="col-md-6"></div>
                                </div>
                                <div class="form-group text-center row mt-3">
                                    <div class="col-md-3">
                                        <button class="btn btn-info w-100 waves-effect waves-light" type="submit">Save</button>
                                        @if (session('status') === 'profile-updated')
                                        <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)" class="text-sm text-gray-600">Successfully saved.</p>
                                        @endif
                                    </div>
                                    <div class="col-md-3">
                                    </div>
                                    <div class="col-md-3">
                                    </div>
                                    <div class="col-md-3">
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- update user profile password -->
            <div class="row">
                <div class="col-xl-12">
                    <div class="card card-danger card-outline">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <h2 class="text-lg font-medium text-gray-900">Update Password</h2>
                                </div>
                                <div class="col-md-12">
                                    <p class="mt-1 text-sm text-gray-600">Ensure your account is using a long, random password to stay secure.</p>
                                </div>
                            </div>
                            <form method="POST" action="{{ route('password.update') }}" class="mt-6 space-y-6">
                                @csrf
                                @method('PUT')
                                <div class="row mt-3">
                                    <div class="col-md-6">
                                        <label for="current_password">Current Password</label>
                                        <input class="form-control @if($errors->updatePassword->has('current_password')) is-invalid @endif" type="password" id="current_password" name="current_password" value="{{ old('current_password') }}" placeholder="Enter current password here" required>
                                        @if($errors->updatePassword->has('current_password'))
                                        <div class="invalid-feedback">
                                            {{ $errors->updatePassword->first('current_password')}}
                                        </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-md-6">
                                        <label for="password">New Password</label>
                                        <input class="form-control @if($errors->updatePassword->has('password')) is-invalid @endif" type="password" id="password" name="password" value="{{ old('password') }}" placeholder="Enter new password here" required>
                                        @if($errors->updatePassword->has('password'))
                                        <div class="invalid-feedback">
                                            {{ $errors->updatePassword->first('password')}}
                                        </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-md-6">
                                        <label for="password_confirmation">Confirm Password</label>
                                        <input class="form-control @if($errors->updatePassword->has('password_confirmation')) is-invalid @endif" type="password" id="password_confirmation" name="password_confirmation" value="{{ old('password_confirmation') }}" placeholder="Confirm your new password here" required>
                                        @if($errors->updatePassword->has('password_confirmation'))
                                        <div class="invalid-feedback">
                                            {{ $errors->updatePassword->first('password_confirmation')}}
                                        </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group text-center row mt-3">
                                    <div class="col-md-3">
                                        <button class="btn btn-info w-100 waves-effect waves-light" type="submit">Save</button>
                                        @if (session('status') === 'password-updated')
                                        <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)" class="text-sm text-gray-600">Successfully saved.</p>
                                        @endif
                                    </div>
                                    <div class="col-md-3">
                                    </div>
                                    <div class="col-md-3">
                                    </div>
                                    <div class="col-md-3">
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->
@endsection