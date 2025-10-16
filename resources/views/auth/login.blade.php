<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login | Meta Benz</title>

    <!-- Favicon -->
    <link rel="shortcut icon" href="{{ asset('main/images/favicon.ico') }}" />

    <!-- Library / Plugin CSS -->
    <link rel="stylesheet" href="{{ asset('main/css/core/libs.min.css') }}" />

    <!-- Hope UI Design System CSS -->
    <link rel="stylesheet" href="{{ asset('main/css/hope-ui.min.css?v=2.0.0') }}" />

    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('main/css/custom.min.css?v=2.0.0') }}" />

    <!-- Dark CSS -->
    <link rel="stylesheet" href="{{ asset('main/css/dark.min.css') }}" />

    <!-- Customizer CSS -->
    <link rel="stylesheet" href="{{ asset('main/css/customizer.min.css') }}" />

    <!-- RTL CSS -->
    <link rel="stylesheet" href="{{ asset('main/css/rtl.min.css') }}" />

    <style>
        .wrapper {
            background: url('{{ asset('main/images/loginbg.jpg') }}') no-repeat center center fixed;
            background-size: cover;
            padding: 20px;
            min-height: 100vh; /* Ensure full viewport height */
            overflow: hidden; /* Prevent scrollbars */
        }

        .login-content {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            position: relative;
            z-index: 1;
        }

        /* Logo styling */
        .login-logo {
            display: block;
            margin: 0 auto 10px; /* Center logo and add spacing below */
            max-width: 150px; /* Adjust size as needed */
            height: auto;
        }
    </style>
</head>
<body data-bs-spy="scroll" data-bs-target="#elements-section" tabindex="0">
    <div id="loading" style="display: none;">
        <div class="loader simple-loader">
            <div class="loader-body"></div>
        </div>
    </div>

    <div class="wrapper">
        <section class="login-content">
            <div class="row m-0 align-items-center bg-white vh-100">
                <div class="col-md-6">
                    <div class="row justify-content-center">
                        <div class="col-md-10">
                            <div class="card card-transparent shadow-none mb-0 auth-card">
                                <div class="card-body">

                                    <!-- Add Logo Here -->
                                    <img src="{{ asset('main/images/logo.png') }}" alt="Meta Benz Logo" class="login-logo">

                                    <h2 class="mb-2 text-center">Sign In</h2>

                                    <!-- Traditional Login -->
                                    <form method="POST" action="/login">
                                        @csrf
                                        <div class="form-group mb-3">
                                            <label for="email" class="form-label">Email</label>
                                            <input type="email" class="form-control" placeholder="Email Address" id="email" name="email"
                                                value="{{ old('email') }}" required autofocus aria-describedby="emailHelp">
                                            @error('email')
                                                <span class="text-danger" id="emailHelp">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="form-group mb-3">
                                            <label for="password" class="form-label">Password</label>
                                            <input type="password" class="form-control" placeholder="Password" id="password" name="password" required aria-describedby="passwordHelp">
                                            @error('password')
                                                <span class="text-danger" id="passwordHelp">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="d-flex justify-content-between mb-3">
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" id="remember" name="remember" aria-label="Remember Me">
                                                <label class="form-check-label" for="remember">Remember Me</label>
                                            </div>
                                            <a href="{{ route('password.request') }}">Forgot Password?</a>
                                        </div>
                                        <div class="d-flex justify-content-center mb-3">
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

<button type="submit" class="btn btn-primary w-100">Sign In</button>
                                        </div>
                                    </form>

                                    <div class="text-center my-4">
                                        <h5 class="mb-3">OR</h5>
                                        <button type="button" id="walletLoginBtn" class="btn btn-outline-primary w-100 d-flex align-items-center justify-content-center" aria-label="Login with MetaMask Wallet">
                                            <img src="{{ asset('main/images/metamask.png') }}" alt="MetaMask" width="25" class="me-2">
                                            Login with Wallet
                                        </button>
                                    </div>
                                    <div class="text-center mt-3" id="walletInfo" style="display:none;">
                                        <p>Address: <span id="walletAddress"></span></p>
                                    </div>

                                    <p class="text-center mt-3">
                                        Don’t have an account?
                                        <a href="{{ route('register') }}" class="text-underline">Click here to Register</a>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="sign-bg">
                        <svg width="280" height="230" viewBox="0 0 431 398" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <g opacity="0.05">
                                <rect x="-157.085" y="193.773" width="543" height="77.5714" rx="38.7857"
                                    transform="rotate(-45 -157.085 193.773)" fill="#3B8AFF" />
                                <rect x="7.46875" y="358.327" width="543" height="77.5714" rx="38.7857"
                                    transform="rotate(-45 7.46875 358.327)" fill="#3B8AFF" />
                                <rect x="61.9355" y="138.545" width="310.286" height="77.5714" rx="38.7857"
                                    transform="rotate(45 61.9355 138.545)" fill="#3B8AFF" />
                                <rect x="62.3154" y="-190.173" width="543" height="77.5714" rx="38.7857"
                                    transform="rotate(45 62.3154 -190.173)" fill="#3B8AFF" />
                            </g>
                        </svg>
                    </div>
                </div>

                <div class="col-md-6 d-md-block d-none bg-primary p-0 mt-n1 vh-100 overflow-hidden">
                    <img src="{{ asset('main/images/auth/01.png') }}" class="img-fluid gradient-main animated-scaleX"
                        alt="Login page background">
                </div>
            </div>
        </section>
    </div>

    <!-- JS -->
    <script src="{{ asset('main/js/core/libs.min.js') }}"></script>
    <script src="{{ asset('main/js/core/external.min.js') }}"></script>
    <script src="{{ asset('main/js/hope-ui.js') }}" defer></script>

    <!-- Web3.js + SweetAlert -->
    <script src="https://cdn.jsdelivr.net/npm/web3@latest/dist/web3.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        const RPC_URL = 'https://rpc.mwtscan.com';
        const CHAIN_ID = 872; // Meta Wealth Testnet

        async function connectWallet() {
            const btn = document.getElementById('walletLoginBtn');
            const originalText = btn.innerHTML;
            const walletInfo = document.getElementById('walletInfo');
            const walletAddressElement = document.getElementById('walletAddress');

            // Check if on mobile device
            const isMobile = /Android|iPhone|iPad|iPod/i.test(navigator.userAgent);

            // Check wallet availability
            if (!isMobile && typeof window.ethereum === 'undefined') {
                Swal.fire({
                    icon: 'warning',
                    title: 'Wallet Extension Missing',
                    html: 'Please install <a href="https://metamask.io/download/" target="_blank">MetaMask</a> or <a href="https://trustwallet.com/browser-extension" target="_blank">Trust Wallet Extension</a> to continue.',
                    confirmButtonText: 'OK'
                });
                return;
            } else if (isMobile) {
                Swal.fire({
                    icon: 'info',
                    title: 'Use DApp Browser',
                    text: 'Please open this page in a decentralized browser like Trust Wallet or MetaMask Mobile App.',
                    confirmButtonText: 'OK'
                });
                return;
            }

            // Show loader
            btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span> Connecting...';
            btn.disabled = true;

            try {
                const web3 = new Web3(window.ethereum);

                // Request account access
                const accounts = await window.ethereum.request({ method: 'eth_requestAccounts' });
                const walletAddress = accounts[0];

                // Check current chain
                const networkId = await web3.eth.getChainId();
                if (Number(networkId) !== CHAIN_ID) {
                    try {
                        await window.ethereum.request({
                            method: 'wallet_switchEthereumChain',
                            params: [{ chainId: `0x${CHAIN_ID.toString(16)}` }],
                        });
                    } catch (switchError) {
                        if (switchError.code === 4902) {
                            await window.ethereum.request({
                                method: 'wallet_addEthereumChain',
                                params: [{
                                    chainId: `0x${CHAIN_ID.toString(16)}`,
                                    chainName: 'MWTscan',
                                    rpcUrls: [RPC_URL],
                                    nativeCurrency: { name: 'MWT', symbol: 'MWT', decimals: 18 },
                                    blockExplorerUrls: ['https://mwtscan.com']
                                }],
                            });
                        } else {
                            throw switchError;
                        }
                    }
                }

                // Update UI with wallet info
                walletAddressElement.textContent = walletAddress;
                walletInfo.style.display = 'block';

                // Send wallet address to backend
                const response = await fetch('/login', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({ wallet: walletAddress })
                });

                const data = await response.json();
                if (data.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Login Successful',
                        text: 'Redirecting...',
                        timer: 1500,
                        showConfirmButton: false
                    }).then(() => {
                        window.location.href = data.redirect || '/dashboard';
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Login Failed',
                        text: data.message || 'Wallet not registered. Please sign up first.'
                    });
                }
            } catch (error) {
                console.error('Wallet connection error:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Connection Failed',
                    text: error.message || 'Failed to connect wallet. Please try again.'
                });
            } finally {
                btn.innerHTML = originalText;
                btn.disabled = false;
            }
        }

        document.getElementById('walletLoginBtn').addEventListener('click', connectWallet);
    </script>
</body>
</html>