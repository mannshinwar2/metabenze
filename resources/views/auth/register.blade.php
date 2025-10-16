<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>Register | Meta Benz</title>

<link rel="shortcut icon" href="{{ asset('main/images/favicon.ico') }}" />
<link rel="stylesheet" href="{{ asset('main/css/core/libs.min.css') }}" />
<link rel="stylesheet" href="{{ asset('main/css/hope-ui.min.css?v=2.0.0') }}" />
<link rel="stylesheet" href="{{ asset('main/css/custom.min.css?v=2.0.0') }}" />
<link rel="stylesheet" href="{{ asset('main/css/dark.min.css') }}" />
<link rel="stylesheet" href="{{ asset('main/css/customizer.min.css') }}" />
<link rel="stylesheet" href="{{ asset('main/css/rtl.min.css') }}" />

<style>
.login-logo { display: block; margin: 0 auto 10px; max-width: 150px; height: auto; }
.error-message { color: #dc3545; font-size: 0.875rem; margin-top: 0.25rem; }
</style>
</head>
<body class=" " data-bs-spy="scroll" data-bs-target="#elements-section" tabindex="0">

<div class="wrapper">
<section class="login-content">
<div class="row m-0 align-items-center bg-white vh-100">
<div class="col-md-6 d-md-block d-none bg-primary p-0 mt-n1 vh-100 overflow-hidden">
<img src="{{ asset('main/images/auth/05.png') }}" class="img-fluid gradient-main animated-scaleX" alt="Registration page background">
</div>
<div class="col-md-6">
<div class="row justify-content-center">
<div class="col-md-10">
<div class="card card-transparent auth-card shadow-none d-flex justify-content-center mb-0">
<div class="card-body">
<a href="{{ url('/') }}" class="navbar-brand d-flex align-items-center mb-3">
<img src="{{ asset('main/images/logo.png') }}" alt="Meta Benz Logo" class="login-logo">
</a>
<h2 class="mb-2 text-center">Get Started with Us</h2>
<p class="text-center">Register a new membership</p>

<!-- Display General Error/Success Messages -->
@if(session('error'))
<script>
document.addEventListener('DOMContentLoaded', () => {
    Swal.fire({
        icon: 'error',
        title: 'Please Fix These Errors',
        html: `{!! session('error') !!}`,
        width: 400,
        showConfirmButton: true,
    });
});
</script>
@endif

@if(session('success') && session('details'))
<script>
document.addEventListener('DOMContentLoaded', () => {
    const details = @json(session('details'));

    // Generate HTML content for popup
    const content = `
        <div id="userInfoForScreenshot" style="padding:20px; font-family:Arial, sans-serif; text-align:center;">
            <div style="display:flex; justify-content:center; margin-bottom:20px;">
                <div style="background:#28a745; width:80px; height:80px; border-radius:50%; display:flex; align-items:center; justify-content:center; box-shadow:0 4px 15px rgba(0,0,0,0.3);">
                    <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" fill="white" class="bi bi-check2" viewBox="0 0 16 16">
                        <path d="M13.854 3.646a.5.5 0 0 0-.708-.708L6 10.086 3.854 7.94a.5.5 0 1 0-.708.708l2.5 2.5a.5.5 0 0 0 .708 0l7-7z"/>
                    </svg>
                </div>
            </div>

            <h3 style="margin-bottom:15px; color:#28a745;">🎉 Congratulations! 🎉</h3>
            <p style="margin-bottom:20px;">You have joined <strong>Meta Benz</strong> successfully.</p>

            <div style="text-align:left; margin-bottom:20px;">
                <table style="width:100%; border-collapse:collapse;">
                    <tr>
                        <td style="padding:5px 0;"><strong>User ID:</strong></td>
                        <td style="padding:5px 0;">${details.username}</td>
                    </tr>
                    <tr>
                        <td style="padding:5px 0;"><strong>Password:</strong></td>
                        <td style="padding:5px 0;">${details.password}</td>
                    </tr>
                    <tr>
                        <td style="padding:5px 0;"><strong>Email:</strong></td>
                        <td style="padding:5px 0;">${details.username}</td>
                    </tr>
                    <tr>
                        <td style="padding:5px 0;"><strong>Wallet Address:</strong></td>
                        <td style="padding:5px 0;">${details.wallet_address}</td>
                    </tr>
                </table>
            </div>

            <div style="display:flex; justify-content:center; gap:10px; flex-wrap:wrap;">
                <button id="downloadScreenshot" style="background:#28a745; color:white; border:none; padding:10px 15px; border-radius:5px; cursor:pointer; font-weight:bold;">
                    📸 Download
                </button>
                <button id="sendWhatsapp" style="background:#25D366; color:white; border:none; padding:10px 15px; border-radius:5px; cursor:pointer; font-weight:bold;">
                    💬 WhatsApp
                </button>
                <button id="closePopup" style="background:#6c757d; color:white; border:none; padding:10px 15px; border-radius:5px; cursor:pointer; font-weight:bold;">
                    ❌ Close
                </button>
            </div>
        </div>
    `;

    Swal.fire({
        html: content,
        showConfirmButton: false,
        width: 450,
        background: '#f9f9f9',
        didOpen: () => {
            // Launch confetti
            confetti({
                particleCount: 200,
                spread: 90,
                origin: { y: 0.6 }
            });
        }
    });

    // Screenshot download
    document.addEventListener('click', function(e){
        if(e.target && e.target.id === 'downloadScreenshot'){
            const element = document.getElementById('userInfoForScreenshot');
            html2canvas(element, { scale:2 }).then(canvas => {
                const link = document.createElement('a');
                link.download = `MetaBenz_Registration_${details.username}.png`;
                link.href = canvas.toDataURL();
                link.click();
            });
        }

        // Send to WhatsApp
        if(e.target && e.target.id === 'sendWhatsapp'){
            const message = `Congrats! 🎉 You joined Meta Benz successfully.\nUser ID: ${details.username}\nEmail: ${details.username}\nPassword: ${details.password}\nWallet: ${details.wallet_address}`;
            const whatsappUrl = `https://api.whatsapp.com/send?text=${encodeURIComponent(message)}`;
            window.open(whatsappUrl, '_blank');
        }

        // Close popup
        if(e.target && e.target.id === 'closePopup'){
            Swal.close();
        }
    });
});
</script>
@endif




<!-- Initial Choice -->
<div id="registerChoice" class="text-center mb-4">
<div class="d-flex justify-content-center gap-3">
<button type="button" id="walletRegisterBtn" class="btn btn-outline-primary w-100">
<img src="{{ asset('main/images/metamask.png') }}" alt="MetaMask" width="25" class="me-2"> Register with Web3 Wallet
</button>
<button type="button" id="emailRegisterBtn" class="btn btn-primary w-100">
Register with Email & Password
</button>
</div>
</div>

<!-- Registration Form -->
<form id="registerForm" style="display: none;" method="POST" action="{{ route('register') }}">
@csrf
<div class="row">

<!-- Wallet Address -->
<div class="col-lg-12" id="walletAddressField" style="display: none;">
<div class="form-group mb-3">
<label for="wallet_address" class="form-label">Wallet Address</label>
<input type="text" class="form-control" id="wallet_address" name="wallet_address" readonly>
@error('wallet_address')
<span class="error-message">{{ $message }}</span>
@enderror
</div>
</div>

<!-- Sponsor ID -->
<div class="col-lg-6">
<div class="form-group mb-3">
<label for="sponsor_id" class="form-label">Sponsor ID *</label>
<input type="text" class="form-control" id="sponsor_id" name="referrer" placeholder="Sponsor ID" value="{{ old('referrer') }}" required>
@error('referrer')
<span class="error-message">{{ $message }}</span>
@enderror
</div>
</div>

<!-- Sponsor Name -->
<div class="col-lg-6">
<div class="form-group mb-3">
<label for="sponsor_name" class="form-label">Sponsor Name *</label>
<input type="text" class="form-control" id="sponsor_name" name="sponsor_name" placeholder="Sponsor Name" value="{{ old('sponsor_name') }}" readonly required>
@error('sponsor_name')
<span class="error-message">{{ $message }}</span>
@enderror
</div>
</div>

<!-- Name -->
<div class="col-lg-6">
<div class="form-group mb-3">
<label for="name" class="form-label">Name *</label>
<input type="text" class="form-control" id="name" name="name" placeholder="Full Name" value="{{ old('name') }}" required>
@error('name')
<span class="error-message">{{ $message }}</span>
@enderror
</div>
</div>

<!-- Email -->
<div class="col-lg-6">
<div class="form-group mb-3">
<label for="email" class="form-label">Email Address *</label>
<input type="email" class="form-control" id="email" name="email" placeholder="Email Address" value="{{ old('email') }}" required>
@error('email')
<span class="error-message">{{ $message }}</span>
@enderror
</div>
</div>

<!-- Mobile -->
<div class="col-lg-6">
<div class="form-group mb-3">
<label for="mobile" class="form-label">Mobile No *</label>
<div class="input-group">
<span class="input-group-text">+91</span>
<input type="text" class="form-control" id="mobile" name="contact" placeholder="Mobile No" value="{{ old('contact') }}" required>
</div>
@error('contact')
<span class="error-message">{{ $message }}</span>
@enderror
</div>
</div>

<!-- Password -->
<div class="col-lg-6">
<div class="form-group mb-3">
<label for="password" class="form-label">Password *</label>
<input type="password" class="form-control" id="password" name="password" placeholder="Enter Password" required>
@error('password')
<span class="error-message">{{ $message }}</span>
@enderror
</div>
</div>

<!-- Confirm Password -->
<div class="col-lg-6">
<div class="form-group mb-3">
<label for="password_confirmation" class="form-label">Confirm Password *</label>
<input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Confirm Password" required>
@error('password_confirmation')
<span class="error-message">{{ $message }}</span>
@enderror
</div>
</div>

<div class="col-lg-12 d-flex justify-content-center">
<div class="form-check mb-3">
<input type="checkbox" class="form-check-input" id="terms" name="terms" {{ old('terms') ? 'checked' : '' }} required>
<label class="form-check-label" for="terms">I agree with the terms of use</label>
@error('terms')
<span class="error-message">{{ $message }}</span>
@enderror
</div>
</div>

</div>

<div class="d-flex justify-content-center">
<button type="submit" id="submitBtn" class="btn btn-primary">Sign Up</button>
</div>
</form>

<p class="mt-3 text-center">
Already have an Account? <a href="{{ route('login') }}" class="text-underline">Sign In</a>
</p>

</div>
</div>
</div>
</div>
</div>
</div>
</section>
</div>

<script src="{{ asset('main/js/core/libs.min.js') }}"></script>
<script src="{{ asset('main/js/core/external.min.js') }}"></script>
<script src="{{ asset('main/js/hope-ui.js') }}" defer></script>
<script src="https://cdn.jsdelivr.net/npm/web3@latest/dist/web3.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
const RPC_URL = 'https://rpc.mwtscan.com';
const CHAIN_ID = 872;

const walletRegisterBtn = document.getElementById('walletRegisterBtn');
const emailRegisterBtn = document.getElementById('emailRegisterBtn');
const registerChoice = document.getElementById('registerChoice');
const registerForm = document.getElementById('registerForm');
const walletAddressField = document.getElementById('walletAddressField');
const walletAddressInput = document.getElementById('wallet_address');
const submitBtn = document.getElementById('submitBtn');
const sponsorIdInput = document.getElementById('sponsor_id');
const sponsorNameInput = document.getElementById('sponsor_name');

emailRegisterBtn.addEventListener('click', () => {
    registerChoice.style.display = 'none';
    registerForm.style.display = 'block';
    walletAddressField.style.display = 'none';
});

walletRegisterBtn.addEventListener('click', async () => {
    const isMobile = /Android|iPhone|iPad|iPod/i.test(navigator.userAgent);

    if (!isMobile && typeof window.ethereum === 'undefined') {
        Swal.fire({ icon: 'warning', title: 'Wallet Extension Missing', html: 'Install <a href="https://metamask.io/download/" target="_blank">MetaMask</a> or Trust Wallet Extension.' });
        return;
    } else if (isMobile) {
        Swal.fire({ icon: 'info', title: 'Use DApp Browser', text: 'Open this page in a DApp browser like MetaMask Mobile App.' });
        return;
    }

    walletRegisterBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span> Connecting...';
    walletRegisterBtn.disabled = true;

    try {
        const web3 = new Web3(window.ethereum);
        const accounts = await window.ethereum.request({ method: 'eth_requestAccounts' });
        const walletAddress = accounts[0];

        const networkId = await web3.eth.getChainId();
        if (Number(networkId) !== CHAIN_ID) {
            try {
                await window.ethereum.request({ method: 'wallet_switchEthereumChain', params: [{ chainId: `0x${CHAIN_ID.toString(16)}` }] });
            } catch (switchError) {
                if (switchError.code === 4902) {
                    await window.ethereum.request({
                        method: 'wallet_addEthereumChain',
                        params: [{ chainId: `0x${CHAIN_ID.toString(16)}`, chainName: 'MWTscan', rpcUrls: [RPC_URL], nativeCurrency: { name: 'MWT', symbol: 'MWT', decimals: 18 }, blockExplorerUrls: ['https://mwtscan.com'] }]
                    });
                } else throw switchError;
            }
        }

        walletAddressInput.value = walletAddress;
        registerChoice.style.display = 'none';
        registerForm.style.display = 'block';
        walletAddressField.style.display = 'block';
    } catch (error) {
        console.error('Wallet connection error:', error);
        Swal.fire({ icon: 'error', title: 'Connection Failed', text: error.message || 'Failed to connect wallet.' });
    } finally {
        walletRegisterBtn.innerHTML = '<img src="{{ asset('main/images/metamask.png') }}" alt="MetaMask" width="25" class="me-2"> Register with Web3 Wallet';
        walletRegisterBtn.disabled = false;
    }
});

sponsorIdInput.addEventListener('blur', async () => {
    const sponsorId = sponsorIdInput.value.trim();
    if (!sponsorId) { sponsorNameInput.value = ''; return; }

    try {
        const response = await fetch(`{{ url('get-sponsor') }}/${sponsorId}`, {
            headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content') }
        });
        const data = await response.json();

        if (data.status === 0) sponsorNameInput.value = data.name;
        else {
            sponsorNameInput.value = '';
            Swal.fire({ icon: 'error', title: 'Invalid Sponsor ID', text: data.message || 'Enter a valid sponsor ID' });
        }
    } catch (err) {
        console.error(err);
        sponsorNameInput.value = '';
        Swal.fire({ icon: 'error', title: 'Error', text: 'Failed to fetch sponsor details.' });
    }
});

registerForm.addEventListener('submit', () => {
    submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span> Signing Up...';
    submitBtn.disabled = true;
});
</script>
<!-- SweetAlert2 already included -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.6.0/dist/confetti.browser.min.js"></script>


</body>
</html>
