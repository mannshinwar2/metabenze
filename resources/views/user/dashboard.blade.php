@extends('user.layouts.app')

@section('title', 'Dashboard')

@section('content')
  <style>
/* Morpankh-inspired Gradient for Button */
.btn-primary {
  /* Remove default background color */
  background-color: transparent; 
  
  /* Apply Morpankh-inspired linear gradient */
  background-image: linear-gradient(
    45deg, /* Diagonal angle for a dynamic look */
    #00CED1, /* Dark Turquoise (Teal) */
    #3CB371, /* Medium Sea Green (Green) */
    #20B2AA, /* Light Sea Green */
    #4B0082, /* Indigo (Dark Violet/Blue) */
    #8A2BE2  /* Blue Violet (Purple) */
  );
  
  /* Optional: Adjust text color for better contrast on the gradient */
  color: white; /* White text looks good on these dark colors */
  
  /* Optional: Add a subtle shadow for depth */
  box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
  
  /* Optional: Smooth transition for hover effects */
  transition: all 0.3s ease-in-out;
}

/* Hover effect for the button */
.btn-primary:hover {
  /* Slightly change the background position for a subtle animation on hover */
  background-position: 100% 0%; /* Moves the gradient slightly */
  box-shadow: 0 6px 15px rgba(0, 0, 0, 0.4); /* Deeper shadow on hover */
}

/* Optional: Agar aapke button mein padding ya border radius ki zaroorat hai */
.btn {
    padding: 10px 20px; /* Example padding */
    border-radius: 8px; /* Example border radius */
    border: none; /* Remove default button border */
}
</style>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

<div class="container-fluid content-inner mt-n5 py-0">

    <div class="row">
        <!-- ===== Wallet Cards ===== -->
        <!-- ===== Wallet Cards ===== -->
<div class="col-12">
    <div class="row g-3">

        <!-- Main Wallet Balance -->
        <div class="col-12 col-md-4">
            <div class="card h-100 position-relative overflow-hidden" style="border-radius:15px;">
                <!-- Background -->
                <div style="
                    position: absolute;
                    inset: 0;
                    background-image: url('main/images/head2.png');
                    background-size: cover;
                    background-position: center;
                    opacity: 0.5;
                    z-index: 0;">
                </div>
                <!-- Floating streak -->
                <div class="light-streak" data-depth="25"></div>
                <!-- Card Content -->
                <div class="card-body d-flex align-items-center" style="position: relative; z-index: 2;">
                    <div class="d-flex align-items-center">
                        <div class="p-3 rounded bg-soft-primary me-3" style="color:white!important">
                            <svg xmlns="http://www.w3.org/2000/svg" width="30" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-3d mb-0">₹100</h3>
                            <p class="text-3d mb-0" style="color:white;">Main Wallet Balance</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Income Wallet Balance -->
        <div class="col-12 col-md-4">
            <div class="card h-100 position-relative overflow-hidden" style="border-radius:15px;">
                <div style="
                    position: absolute;
                    inset: 0;
                    background-image: url('main/images/head2.png');
                    background-size: cover;
                    background-position: center;
                    opacity: 0.5;
                    z-index: 0;">
                </div>
                <div class="light-streak" data-depth="25"></div>
                <div class="card-body d-flex align-items-center" style="position: relative; z-index: 2;">
                    <div class="d-flex align-items-center">
                        <div class="p-3 rounded bg-soft-primary me-3" style="color:white!important">
                            <svg xmlns="http://www.w3.org/2000/svg" width="30" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-3d mb-0">₹100</h3>
                            <p class=" text-3d mb-0" style="color:white;">Income Wallet Balance</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Promotional Wallet Balance -->
        <div class="col-12 col-md-4">
            <div class="card h-100 position-relative overflow-hidden" style="border-radius:15px;">
                <div style="
                    position: absolute;
                    inset: 0;
                    background-image: url('main/images/head2.png');
                    background-size: cover;
                    background-position: center;
                    opacity: 0.5;
                    z-index: 0;">
                </div>
                <div class="light-streak" data-depth="25"></div>
                <div class="card-body d-flex align-items-center" style="position: relative; z-index: 2;">
                    <div class="d-flex align-items-center">
                        <div class="p-3 rounded bg-soft-primary me-3" style="color:white!important">
                            <svg xmlns="http://www.w3.org/2000/svg" width="30" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-3d mb-0">₹100</h3>
                            <p class="text-3d mb-0" style="color:white;">Promotional Wallet Balance</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>



        <!-- ===== Referral Section ===== -->
        <div class="col-12 mt-4">
            <div class="card mb-4">
                <div class="card-header">
                    <h4 class="card-title">Invite Friends & Earn</h4>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <!-- Referral Code -->
                        <div class="col-12 col-md-6">
                            <label>Your Referral Code</label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="referralCode" value="MBZ32874783" readonly>
                                <button class="btn btn-primary" onclick="copyReferralCode()">
                                    <i class="fas fa-copy"></i> Copy
                                </button>
                            </div>
                        </div>

                        <!-- Referral Link -->
                        <div class="col-12 col-md-6">
                            <label>Your Referral Link</label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="referralLink" value="tertertret" readonly>
                                <button class="btn btn-success" onclick="copyReferralLink()">
                                    <i class="fas fa-copy"></i> Copy
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="alert alert-info mt-3">
                        <i class="fas fa-info-circle me-2"></i>
                        Share your referral link with friends and earn rewards when they sign up!<br>
                        You'll get 10% of deposited Amount of Your referral
                    </div>

                    <div class="d-flex flex-wrap gap-2">
                        <a href="#" class="btn btn-success flex-grow-1" target="_blank">
                            <i class="fab fa-whatsapp"></i> WhatsApp
                        </a>
                        <a href="#" class="btn btn-primary flex-grow-1" target="_blank">
                            <i class="fab fa-facebook"></i> Facebook
                        </a>
                        <a href="#" class="btn btn-info flex-grow-1" target="_blank">
                            <i class="fab fa-twitter"></i> Twitter
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- ===== Action Buttons ===== -->
        <div class="col-12 mb-4 d-flex flex-wrap justify-content-center gap-2">
            <a href="/User/Deposit" class="btn btn-primary flex-grow-1 flex-md-grow-0">Deposit Balance</a>
            <a href="/User/Deposit" class="btn btn-secondary flex-grow-1 flex-md-grow-0">Withdraw Income</a>
        </div>

        <!-- ===== Additional Wallet Cards (User Wallet / Rewards etc.) ===== -->
        <div class="col-12">
            <div class="row g-3">
                @for($i = 1; $i <= 9; $i++)
                    <div class="col-12 col-md-4">
                        <div class="card h-100">
                            <div class="card-body d-flex align-items-center">
                                <div class="p-3 rounded bg-soft-primary me-3" style="color:white!important">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="30" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                              d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="mb-0">₹100</h3>
                                    <p class="mb-0" style="color:white;">User Wallet Balance</p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endfor
            </div>
        </div>

    </div>
</div>

<!-- ===== Scripts ===== -->
<script>
    $(document).ready(function() {
        $(document).on('click', '.pagination a', function(e) {
            e.preventDefault();
            var url = $(this).attr('href');
            $.ajax({
                url: url,
                type: 'GET',
                success: function(data) {
                    $('#income-table-body').html(data.table);
                    $('#income-pagination').html(data.pagination);
                }
            });
        });
    });

    function copyReferralCode() {
        const code = document.getElementById('referralCode');
        code.select();
        document.execCommand('copy');
        Swal.fire({
            toast: true,
            position: 'top-end',
            icon: 'success',
            title: 'Referral code copied!',
            showConfirmButton: false,
            timer: 1500
        });
    }

    function copyReferralLink() {
        const link = document.getElementById('referralLink');
        const userFullName = "dsdfasdfsa";
        const referralMessage = `Hi, I'm ${userFullName} inviting you to join KreditBridge - a platform for financial growth. Use my referral link to register: ${link.value}`;
        
        const textarea = document.createElement('textarea');
        textarea.value = referralMessage;
        document.body.appendChild(textarea);
        textarea.select();
        document.execCommand('copy');
        document.body.removeChild(textarea);

        Swal.fire({
            toast: true,
            position: 'top-end',
            icon: 'success',
            title: 'Referral message copied!',
            showConfirmButton: false,
            timer: 1500
        });
    }
</script>

@if(session('registration_data'))
<script src="https://html2canvas.hertzen.com/dist/html2canvas.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const successMessage = `{!! session('success') !!}`;
        const userId = `{!! session('registration_data')['user_id'] !!}`;
        const password = `{!! session('registration_data')['password'] !!}`;
        
        Swal.fire({
            title: successMessage,
            html: `
                <div class="text-left mb-4" id="credentialsContainer">
                    <p><strong>User ID:</strong> ${userId}</p>
                    <p><strong>Password:</strong> ${password}</p>
                </div>
                <div class="d-grid gap-2">
                    <button id="screenshotBtn" class="btn btn-warning">
                        <i class="fas fa-camera me-2"></i> Tap to Take Screenshot
                    </button>
                </div>
                <p class="text-danger mt-3"><small>Please save these credentials securely.</small></p>
            `,
            icon: 'success',
            confirmButtonText: 'Continue',
            confirmButtonColor: '#3085d6',
            showCancelButton: false,
            focusConfirm: false,
            allowOutsideClick: false,
            width: '90%',
            backdrop: 'rgba(0,0,0,0.7)'
        });

        document.getElementById('screenshotBtn').addEventListener('click', function() {
            const popup = document.querySelector('.swal2-popup');
            popup.classList.add('screenshot-mode');
            
            html2canvas(popup, {
                scale: 2,
                backgroundColor: '#ffffff'
            }).then(canvas => {
                popup.classList.remove('screenshot-mode');
                const link = document.createElement('a');
                link.download = `credentials-${Date.now()}.png`;
                link.href = canvas.toDataURL('image/png');
                link.click();

                Swal.fire({
                    toast: true,
                    position: 'top-end',
                    icon: 'success',
                    title: 'Screenshot saved!',
                    showConfirmButton: false,
                    timer: 1500
                });
            });
        });
    });

    const style = document.createElement('style');
    style.textContent = `
        .screenshot-mode { box-shadow:0 0 0 10px white !important; border-radius:10px !important; }
        #screenshotBtn { font-weight:600; }
        .swal2-popup { max-width:100% !important; }
    `;
    document.head.appendChild(style);
</script>
@endif

@endsection
