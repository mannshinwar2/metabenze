@extends('user.layouts.app')

@section('title', 'Edit Profile')

@section('content')
<div class="container-fluid content-inner mt-n5 py-0">
    <div class="row">

        <!-- Left Sidebar: Minimal Profile -->
        <div class="col-xl-3 col-lg-4">
            <div class="card">
                <div class="card-body text-center">
                    <div class="profile-img-edit position-relative mb-3">
                        <img src="{{ asset('main/images/logoicon.png') }}" alt="profile-pic" class="profile-pic rounded avatar-100">
                    </div>
                    <h5>{{ $profile->usersname ?? 'N/A' }}</h5>
                    <p>{{ $profile->email ?? 'N/A' }}</p>
                    <p>Date of Joining : {{ $profile->doj ?? 'N/A' }}</p>
                </div>
            </div>
        </div>

        <!-- Right Sidebar: Edit Profile Form -->
        <div class="col-xl-9 col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title mb-0">Edit Profile</h4>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @elseif(session('warning'))
                        <div class="alert alert-warning">{{ session('warning') }}</div>
                    @endif

                    <form method="POST" action="{{ url('/User/EditProfile') }}">
                        @csrf

                        <!-- Personal Info -->
                        <h5 class="mb-3">Personal Info</h5>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label>Name</label>
                                <input type="text" class="form-control" value="{{ $profile->usersname ?? '' }}" disabled>
                            </div>
                            <div class="col-md-6">
                                <label>Email</label>
                                <input type="email" class="form-control" value="{{ $profile->email ?? '' }}" disabled>
                            </div>
                        </div>

                        <!-- Contact Info -->
                        <h5 class="mb-3">Contact Info</h5>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label>Contact</label>
                                <input type="text" class="form-control" value="+{{ $profile->ccode ?? '' }} {{ $profile->contact ?? '' }}" disabled>
                            </div>
                            <div class="col-md-6">
                                <label>Sponsor</label>
                                <input type="text" class="form-control" value="{{ $profile->guidername ?? '' }} ({{ $profile->guiderid ?? '' }})" disabled>
                            </div>
                        </div>

                        <!-- Wallet Addresses -->
                        <h5 class="mb-3">Wallet Addresses</h5>
                        <div class="row mb-3">
                           
                            <div class="col-md-6">
                                <label>USDT (TRC20)</label>
                                <input type="text" name="usdtaddress" class="form-control" value="{{ $profile->usdttrc20address ?? '' }}" placeholder="T...">
                            </div>
                            <div class="col-md-6">
                                <label>USDT (BEP20)</label>
                                <input type="text" name="usdtbep20address" class="form-control" value="{{ $profile->usdtbep20address ?? '' }}" placeholder="0x...">
                            </div>
                        </div>

                        <!-- OTP Verification if pending changes -->
                        @if($changeasset)
                            <h5 class="mb-3">OTP Verification</h5>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <input type="text" name="otp" class="form-control" placeholder="Enter OTP">
                                </div>
                                <div class="col-md-6">
                                    <a href="{{ url('/User/resendProfileOtp') }}" class="btn btn-outline-primary">Resend OTP</a>
                                </div>
                            </div>
                        @endif

                        <button type="submit" class="btn btn-primary">
                            @if($changeasset) Verify OTP @else Save Changes @endif
                        </button>
                    </form>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
