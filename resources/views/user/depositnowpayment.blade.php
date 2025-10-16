@extends('user.layouts.app')

@section('title', 'Deposit')

@section('content')
<!-- Font Awesome 6 CDN -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-pJ4Xk1E6S8mK5V5gV0nD2oSXpV1PZwBJqkC+fUgPqfHIdPc5gzX6C8eC6hIYYQ6Nx5p20FZsABrB5vC8XmkV0A==" crossorigin="anonymous" referrerpolicy="no-referrer" />

<div class="container-fluid content-inner mt-4 py-4">
    <div class="row justify-content-center">
        <div class="col-12 col-lg-8">
            <div class="card shadow-sm">
                <div class="card-header position-relative">
    <h4 class="card-title mb-0 text-center w-100">Deposit Funds</h4>
</div>

                <div class="card-body">

                  

                    <!-- Messages -->
                    @foreach (['success','warning'] as $msg)
                        @if(session($msg))
                            <div class="alert alert-{{ $msg }} alert-dismissible fade show">
                                <strong>{{ ucfirst($msg) }}!</strong> {{ session($msg) }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif
                    @endforeach

                    @if ($errors->any())
                        @foreach ($errors->all() as $error)
                            <div class="alert alert-danger alert-dismissible fade show">
                                <strong>Alert!</strong> {{ $error }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endforeach
                    @endif

                    <!-- Deposit Form -->
                    @if (!isset($payment))
                        <form method="POST" action="{{ url('/User/Deposit') }}" id="depositForm">
                            @csrf
                            <input type="hidden" name="honeypot" value="{{ \Session::get('logtime') }}">
                            <div class="row g-4">
                                <div class="col-md-6">
                                    <label for="amountusdt" class="form-label">Amount (USD)</label>
                                    <input type="number" name="amount" id="amountusdt" class="form-control @error('amount') is-invalid @enderror" step="0.000001" placeholder="Enter amount" min="25" required>
                                    @error('amount')<span class="invalid-feedback">{{ $message }}</span>@enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="currency" class="form-label">Currency</label>
                                    <select name="currency" id="currency" class="form-select" disabled>
                                        <option value="usdtbep20" selected>USDT BEP20</option>
                                    </select>
                                </div>
                            </div>
                            <div class="alert alert-warning text-center mt-4">
                                ⚠️ This is an automated payment system. Please ensure your payment is correct. Do not refresh or close this page until your payment is confirmed.
                            </div>
                            <div class="text-center mt-4">
                                <button type="submit" class="btn btn-primary px-5" id="submitBtn">Submit</button>
                            </div>
                        </form>
                    @endif

                    <!-- Payment Details -->
                    @if (isset($payment))
                        <div class="text-center mt-3">
                            <h6 class="text-muted mb-2">Send your deposit to this address:</h6>
                            <div class="input-group mb-2">
                                <input type="text" id="depositAddress" class="form-control text-center" readonly value="{{ $payment->pay_address }}">
                              <button class="btn btn-outline-primary" id="copyBtn">
    Copy
</button>


                            </div>
                            <small class="text-muted">Network: <strong>USDT BSC (BEP20)</strong></small>
                            <div class="form-group mb-4 mt-3">
                                <img id="qrimg" src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data={{ $payment->pay_address }}" alt="QR Code" style="max-width: 200px;">
                                <div class="text-muted small mt-1">Scan QR to pay</div>
                            </div>
                            <div class="alert alert-info text-center mt-3" id="countdownBox">
                                <strong>Time Remaining:</strong> <span id="countdownTimer">19:00</span>
                            </div>
                            <p class="mb-1 mt-3"><strong>Payment ID:</strong> {{ $payment->payment_id }}</p>
                            <p class="text-muted mb-3">Send the exact amount shown on Payments screen.</p>
                            <div class="text-center mt-4 d-none" id="statusBox">
                                <div class="spinner-border text-primary" role="status"></div>
                                <p class="mt-2 mb-0 fw-bold text-primary">Verifying your payment...</p>
                            </div>
                            <div class="mt-3 text-center d-none" id="statusMessage"></div>
                            <button class="btn btn-success px-4" id="checkStatusBtn" data-id="{{ $payment->payment_id }}">
                                <i class="fas fa-sync-alt me-2"></i>I've Paid, Check Status
                            </button>
                            <a href="/User/Deposit" class="btn btn-outline-secondary ms-2 px-4">Cancel</a>

                            <div class="text-center mt-4 d-none" id="statusBox">
                                <div class="spinner-border text-primary" role="status"></div>
                                <p class="mt-2 mb-0 fw-bold text-primary">Verifying your payment...</p>
                            </div>
                            <div class="mt-3 text-center d-none" id="statusMessage"></div>
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="transactionModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Message</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body"><p id="modaltext"></p></div>
            <div class="modal-footer">
                <a class="btn btn-primary" id="modalbtn" href="/User/DepositHistory">Continue</a>
            </div>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script>
$(document).ready(function() {
    // Copy address
    $('#copyBtn').on('click', function() {
        const address = $('#depositAddress').val();
        const tempInput = $('<input>');
        $('body').append(tempInput);
        tempInput.val(address).select();
        document.execCommand('copy');
        tempInput.remove();
        $(this).html('Copied');
        setTimeout(() => $(this).html('Copied'), 2000);
        alert(`Address Copied Successfully: ${address}`);
    });

    // Countdown
    let totalSeconds = 19 * 60;
    const $timer = $('#countdownTimer');
    if ($timer.length) {
        setInterval(() => {
            if (totalSeconds > 0) {
                totalSeconds--;
                let m = Math.floor(totalSeconds / 60);
                let s = totalSeconds % 60;
                $timer.text(`${m}:${s.toString().padStart(2,'0')}`);
            }
        }, 1000);
    }

    // Check Payment Status
    @if (!is_null($payment))
    function checkPaymentStatus() {
        $.ajax({
            url: '/Transaction/transactionStatus/{{ $payment->payment_id }}',
            type: 'GET',
            dataType: 'json',
            beforeSend: function() {
                $('#statusBox').removeClass('d-none');
                $('#statusMessage').addClass('d-none');
            },
            success: function(data) {
                $('#statusBox').addClass('d-none');
                const $msgBox = $('#statusMessage').removeClass('d-none');

                if(data.transaction_status===1){
                    $msgBox.html(`<div class="alert alert-success">${data.transaction_message}</div>`);
                } else if(data.transaction_status===2){
                    $msgBox.html(`<div class="alert alert-danger">${data.transaction_message}</div>`);
                } else {
                    $msgBox.html(`<div class="alert alert-warning">Payment still pending, please wait...</div>`);
                }
            },
            error: function() {
                $('#statusBox').addClass('d-none');
                $('#statusMessage').removeClass('d-none').html('<div class="alert alert-danger">Error checking status. Please try again later.</div>');
            }
        });
    }

    // Auto poll
    setTimeout(checkPaymentStatus, 1000);
    setInterval(checkPaymentStatus, 10000);
    @endif

    // Disable submit
    $('#depositForm').on('submit', function() {
        $('#submitBtn').prop('disabled', true).text('Processing, please wait...');
    });
});
</script>
@endsection
