@extends('frontend.dashboard.index')
@section('profile')
@php
    $id = Auth::user()->id;
    $profileData = App\Models\User::find($id);
@endphp
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<div class="breadcrumb-content d-flex flex-wrap align-items-center justify-content-between mb-5">
    <div class="media media-card align-items-center">
        <div class="media-img media--img media-img-md rounded-full">
            <img id="showImage" class="rounded-full" src="{{ (!empty($profileData->photo)) ? url('images/user/'. $profileData->photo) : url('images/user/img-profile.jpg') }}" alt="Student thumbnail image">
        </div>
        <div class="media-body">
            <h2 class="section__title fs-30">Howdy, {{ $profileData->name }}</h2>
            <div class="rating-wrap d-flex align-items-center pt-2">
                <div class="review-stars">
                    <span class="rating-number">4.4</span>
                    <span class="la la-star"></span>
                    <span class="la la-star"></span>
                    <span class="la la-star"></span>
                    <span class="la la-star"></span>
                    <span class="la la-star-o"></span>
                </div>
                <span class="rating-total pl-1">(20,230)</span>
            </div><!-- end rating-wrap -->
        </div><!-- end media-body -->
    </div><!-- end media -->
    <div class="file-upload-wrap file-upload-wrap-2 file--upload-wrap">
        <!-- Notice the form="profileForm" attribute here. This links this input to the form below! -->
        <input type="file" name="photo" class="multi file-upload-input" id="photo" form="profileForm">
        <span class="file-upload-text"><i class="la la-upload mr-2"></i>Upload an Avatar</span>
    </div><!-- file-upload-wrap -->
</div><!-- end breadcrumb-content -->

<div class="section-block mb-5"></div>
<div class="dashboard-heading mb-5">
    <h3 class="fs-22 font-weight-semi-bold" id="dynamic-tab-heading">Profile</h3>
</div>

<ul class="nav nav-tabs generic-tab pb-30px" id="myTab" role="tablist">
    <li class="nav-item">
        <a class="nav-link active" id="edit-profile-tab" data-toggle="tab" href="#edit-profile" role="tab" aria-controls="edit-profile" aria-selected="true" data-heading="Profile">
            Profile
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" id="password-tab" data-toggle="tab" href="#password" role="tab" aria-controls="password" aria-selected="false" data-heading="Change Password">
            Password
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" id="change-email-tab" data-toggle="tab" href="#change-email" role="tab" aria-controls="change-email" aria-selected="false" data-heading="Change Email">
            Change Email
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" id="withdraw-tab" data-toggle="tab" href="#withdraw" role="tab" aria-controls="withdraw" aria-selected="false" data-heading="Withdraw Options">
            Withdraw
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" id="account-tab" data-toggle="tab" href="#account" role="tab" aria-controls="account" aria-selected="false" data-heading="Account">
            Account
        </a>
    </li>
</ul>

<div class="tab-content" id="myTabContent">

    <!-- Profile Tab -->
    <div class="tab-pane fade show active" id="edit-profile" role="tabpanel" aria-labelledby="edit-profile-tab">
        <div class="setting-body">
            <!-- Added id="profileForm". The avatar upload at the top is linked to this form via the form="" attribute -->
            <form id="profileForm" action="{{ route('user.profile.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="profile-detail mb-5">
                    <ul class="generic-list-item generic-list-item-flash">
                        <li>
                            <span class="profile-name">Registration Date:</span>
                            <span class="profile-desc">
                                <input type="text" id="created_at" name="created_at" class="form-control" value="{{ $profileData->created_at->format('D d M Y, h:i:s A') }}" readonly>
                            </span>
                        </li>
                        <li>
                            <span class="profile-name">Name:</span>
                            <span class="profile-desc">
                                <input type="text" id="name" name="name" class="form-control" value="{{ $profileData->name }}" placeholder="Enter your name">
                            </span>
                        </li>
                        <li>
                            <span class="profile-name">Email:</span>
                            <span class="profile-desc">
                                <input type="email" id="email" name="email" class="form-control" value="{{ $profileData->email }}" placeholder="Enter your email">
                            </span>
                        </li>
                        <li>
                            <span class="profile-name">Phone Number:</span>
                            <span class="profile-desc">
                                <input type="text" id="phone" name="phone" class="form-control" value="{{ $profileData->phone }}" placeholder="Enter your phone number">
                            </span>
                        </li>
                        <li>
                            <span class="profile-name">Address:</span>
                            <span class="profile-desc">
                                <input type="text" id="address" name="address" class="form-control" value="{{ $profileData->address }}" placeholder="Enter your address">
                            </span>
                        </li>
                    </ul>
                    <div class="mt-4">
                        <button type="submit" class="btn theme-btn">Save Changes</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Password Tab -->
        <div class="tab-pane fade" id="password" role="tabpanel" aria-labelledby="password-tab">
            <div class="setting-body">
                <h3 class="fs-17 font-weight-semi-bold pb-4">Change Password</h3>
                <form action="{{ route('user.update.password') }}" method="POST" class="row">
                    @csrf
                    <div class="input-box col-lg-4">
                        <label class="label-text">Old Password</label>
                        <div class="form-group">
                            <input type="password" name="old_password" class="form-control @error('old_password') is-invalid @enderror" id="old_password" placeholder="Enter old password" />
                                @error('old_password')
                                    <span class="text-danger">{{ $message }}</span>
                                 @enderror
                            <span class="la la-lock input-icon"></span>
                        </div>
                    </div><!-- end input-box -->
                    <div class="input-box col-lg-4">
                        <label class="label-text">New Password</label>
                        <div class="form-group">
                            <input type="password" name="new_password" class="form-control @error('new_password') is-invalid @enderror" id="new_password" placeholder="Enter new password" />
                                @error('new_password')
                                    <span class="text-danger">{{ $message }}</span>
                                 @enderror
                            <span class="la la-lock input-icon"></span>
                        </div>
                    </div><!-- end input-box -->
                    <div class="input-box col-lg-4">
                        <label class="label-text">Confirm New Password</label>
                        <div class="form-group">
                            <input type="password" name="new_password_confirmation" class="form-control form--control" id="new_password_confirmation" placeholder="Confirm password" />
                            <span class="la la-lock input-icon"></span>
                        </div>
                    </div><!-- end input-box -->
                    <div class="input-box col-lg-12 py-2">
                        <button type="submit" class="btn theme-btn">Change Password</button>
                    </div><!-- end input-box -->
                </form>
            </div>
        </div>


    <!-- Change Email Tab -->
    <div class="tab-pane fade" id="change-email" role="tabpanel" aria-labelledby="change-email-tab">
        <div class="setting-body">
            <h3 class="fs-17 font-weight-semi-bold pb-4">Change Email</h3>
            <form method="post" class="row">
                @csrf
                <div class="input-box col-lg-4">
                    <label class="label-text">Old Email</label>
                    <div class="form-group">
                        <input class="form-control form--control" type="email" name="old_email" placeholder="Old Email">
                        <span class="la la-envelope input-icon"></span>
                    </div>
                </div><!-- end input-box -->
                <div class="input-box col-lg-4">
                    <label class="label-text">New Email</label>
                    <div class="form-group">
                        <input class="form-control form--control" type="email" name="new_email" placeholder="New Email">
                        <span class="la la-envelope input-icon"></span>
                    </div>
                </div><!-- end input-box -->
                <div class="input-box col-lg-4">
                    <label class="label-text">Confirm New Email</label>
                    <div class="form-group">
                        <input class="form-control form--control" type="email" name="new_email_confirmation" placeholder="Confirm New Email">
                        <span class="la la-envelope input-icon"></span>
                    </div>
                </div><!-- end input-box -->
                <div class="input-box col-lg-12 py-2">
                    <button type="submit" class="btn theme-btn">Change Email</button>
                </div><!-- end input-box -->
            </form>
        </div>
    </div>

    <!-- Withdraw Tab -->
    <div class="tab-pane fade" id="withdraw" role="tabpanel" aria-labelledby="withdraw-tab">
        <div class="setting-body">
            <h3 class="fs-17 font-weight-semi-bold pb-4">Select a Withdraw Method</h3>
            <form method="post" class="row mb-40px">
                @csrf
                <div class="col-lg-2 responsive-column-half">
                    <div class="custom-control custom-radio mb-3 pl-0">
                        <input type="radio" class="custom-control-input" id="bankTransfer" name="withdrawal_method" required>
                        <label class="custom-control-label custom--control-label custom--control-label-boxed" for="bankTransfer">
                            <span class="font-weight-semi-bold text-black d-block">Bank Transfer</span>
                            <span class="d-block fs-14 lh-18">Min withdraw $50.00</span>
                        </label>
                    </div>
                </div><!-- end col-lg-2 -->
                <!-- Other payment modes here... Add Paypal, Stripe, etc as needed -->
                <div class="col-lg-2 responsive-column-half">
                    <div class="custom-control custom-radio mb-3 pl-0">
                        <input type="radio" class="custom-control-input" id="PayPal" name="withdrawal_method" required>
                        <label class="custom-control-label custom--control-label custom--control-label-boxed" for="PayPal">
                            <span class="font-weight-semi-bold text-black d-block">PayPal</span>
                            <span class="d-block fs-14 lh-18">Min withdraw $50.00</span>
                        </label>
                    </div>
                </div>
            </form>

            <form method="post" class="row">
                @csrf
                <h3 class="fs-17 font-weight-semi-bold pb-4 col-lg-12">Account info</h3>
                <div class="input-box col-lg-4">
                    <label class="label-text">Account Name</label>
                    <div class="form-group">
                        <input class="form-control form--control" type="text" name="account_name" value="Alex Smith">
                        <span class="la la-user input-icon"></span>
                    </div>
                </div><!-- end input-box -->
                <div class="input-box col-lg-4">
                    <label class="label-text">Account Number</label>
                    <div class="form-group">
                        <input class="form-control form--control" type="text" name="account_number" value="3275476222500">
                        <span class="la la-pencil input-icon"></span>
                    </div>
                </div><!-- end input-box -->
                <div class="input-box col-lg-4">
                    <label class="label-text">Bank Name</label>
                    <div class="form-group">
                        <input class="form-control form--control" type="text" name="bank_name" value="South State Bank">
                        <span class="la la-bank input-icon"></span>
                    </div>
                </div><!-- end input-box -->
                <div class="input-box col-lg-12 py-2">
                    <button type="submit" class="btn theme-btn">Save withdraw account</button>
                </div><!-- end input-box -->
            </form>
        </div>
    </div>

    <!-- Account Tab -->
    <div class="tab-pane fade" id="account" role="tabpanel" aria-labelledby="account-tab">
        <div class="setting-body">
            <h3 class="fs-17 font-weight-semi-bold pb-4">My Account</h3>
            <div class="danger-zone pt-40px mt-4 border-top border-top-gray">
                <h4 class="fs-17 font-weight-semi-bold text-danger">Delete Account Permanently</h4>
                <p class="pt-1 pb-4"><span class="text-warning">Warning: </span>Once you delete your account, there is no going back. Please be certain.</p>
                <button class="btn theme-btn" data-toggle="modal" data-target="#deleteModal">Delete my account</button>
            </div>
        </div>
    </div>

</div><!-- end tab-content -->

<script type="text/javascript">
    $(document).ready(function(){

        // 1. Show Image Before Upload
        $('#photo').change(function(e){
            var reader = new FileReader();
            reader.onload = function(e){
                $('#showImage').attr('src', e.target.result);
            }
            reader.readAsDataURL(e.target.files[0]);
        });

        // 2. Dynamic Heading Changes when switching tabs (Bootstrap 4 method)
        $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
            var incomingHeading = $(e.target).data('heading'); // Get the data-heading of the clicked tab
            $('#dynamic-tab-heading').text(incomingHeading);   // Change the main <h3 id="dynamic-tab-heading"> text
        });

    });
</script>
@endsection
