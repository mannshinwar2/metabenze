<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>@yield('title', 'Meta Benz')</title>

    <!-- Favicon -->
    <link rel="shortcut icon" href="{{ asset('main/images/favicon.ico') }}">

    <!-- CSS -->
    <link rel="stylesheet" href="{{ asset('main/css/core/libs.min.css') }}">
    <link rel="stylesheet" href="{{ asset('main/vendor/aos/dist/aos.css') }}">
    <link rel="stylesheet" href="{{ asset('main/css/hope-ui.min.css') }}">
    <link rel="stylesheet" href="{{ asset('main/css/custom.min.css') }}">
    <link rel="stylesheet" href="{{ asset('main/css/dark.min.css') }}">
    <link rel="stylesheet" href="{{ asset('main/css/customizer.min.css') }}">
    <link rel="stylesheet" href="{{ asset('main/css/rtl.min.css') }}">
</head>
<body>

    <!-- Sidebar -->
    @include('user.layouts.sidebar')

    <!-- Main Content -->
    <main class="main-content">
       <div class="position-relative iq-banner">
                <nav class="nav navbar navbar-expand-lg navbar-light iq-navbar">
          <div class="container-fluid navbar-inner">
            <a href="../dashboard/index.html" class="navbar-brand">
                <!--Logo start-->
                <!--logo End-->
                
              
                
                
                
                
                <h4 class="logo-title">Meta Benz</h4>
            </a>
            <div class="sidebar-toggle" data-toggle="sidebar" data-active="true">
                <i class="icon">
                 <svg  width="20px" class="icon-20" viewBox="0 0 24 24">
                    <path fill="currentColor" d="M4,11V13H16L10.5,18.5L11.92,19.92L19.84,12L11.92,4.08L10.5,5.5L16,11H4Z" />
                </svg>
                </i>
            </div>
            <div class="input-group search-input">
              <span class="input-group-text" id="search-input">
                <svg class="icon-18" width="18" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <circle cx="11.7669" cy="11.7666" r="8.98856" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></circle>
                    <path d="M18.0186 18.4851L21.5426 22" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                </svg>
              </span>
              <input type="search" class="form-control" placeholder="Search...">
            </div>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
              <span class="navbar-toggler-icon">
                  <span class="mt-2 navbar-toggler-bar bar1"></span>
                  <span class="navbar-toggler-bar bar2"></span>
                  <span class="navbar-toggler-bar bar3"></span>
                </span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
              <ul class="mb-2 navbar-nav ms-auto align-items-center navbar-list mb-lg-0">
               
                <li class="nav-item dropdown">
                    <a href="#" class="search-toggle nav-link" id="dropdownMenuButton2" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <img src="../main/images/flag.jpg" class="img-fluid rounded-circle" alt="user" style="height: 30px; min-width: 30px; width: 30px;">
                    <span class="bg-primary"></span>
                    </a>
                    <div class="p-0 sub-drop dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton2">
                        <div class="m-0 border-0 shadow-none card">
                            <div class="p-0 ">
                                <ul class="p-0 list-group list-group-flush">
                                    <li class="iq-sub-card list-group-item"><a class="p-0" href="#"><img src="../main/images/Flag/flag-03.png" alt="img-flaf" class="img-fluid me-2" style="width: 15px;height: 15px;min-width: 15px;"/>Spanish</a></li>
                                    <li class="iq-sub-card list-group-item"><a class="p-0" href="#"><img src="../main/images/Flag/flag-04.png" alt="img-flaf" class="img-fluid me-2" style="width: 15px;height: 15px;min-width: 15px;"/>Italian</a></li>
                                    <li class="iq-sub-card list-group-item"><a class="p-0" href="#"><img src="../main/images/Flag/flag-02.png" alt="img-flaf" class="img-fluid me-2" style="width: 15px;height: 15px;min-width: 15px;"/>French</a></li>
                                    <li class="iq-sub-card list-group-item"><a class="p-0" href="#"><img src="../main/images/Flag/flag-05.png" alt="img-flaf" class="img-fluid me-2" style="width: 15px;height: 15px;min-width: 15px;"/>German</a></li>
                                    <li class="iq-sub-card list-group-item"><a class="p-0" href="#"><img src="../main/images/Flag/flag-06.png" alt="img-flaf" class="img-fluid me-2" style="width: 15px;height: 15px;min-width: 15px;"/>Japanese</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </li>
                <li class="nav-item dropdown">
                  <a href="#"  class="nav-link" id="notification-drop" data-bs-toggle="dropdown" >
                      <svg class="icon-24" width="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M19.7695 11.6453C19.039 10.7923 18.7071 10.0531 18.7071 8.79716V8.37013C18.7071 6.73354 18.3304 5.67907 17.5115 4.62459C16.2493 2.98699 14.1244 2 12.0442 2H11.9558C9.91935 2 7.86106 2.94167 6.577 4.5128C5.71333 5.58842 5.29293 6.68822 5.29293 8.37013V8.79716C5.29293 10.0531 4.98284 10.7923 4.23049 11.6453C3.67691 12.2738 3.5 13.0815 3.5 13.9557C3.5 14.8309 3.78723 15.6598 4.36367 16.3336C5.11602 17.1413 6.17846 17.6569 7.26375 17.7466C8.83505 17.9258 10.4063 17.9933 12.0005 17.9933C13.5937 17.9933 15.165 17.8805 16.7372 17.7466C17.8215 17.6569 18.884 17.1413 19.6363 16.3336C20.2118 15.6598 20.5 14.8309 20.5 13.9557C20.5 13.0815 20.3231 12.2738 19.7695 11.6453Z" fill="currentColor"></path>
                        <path opacity="0.4" d="M14.0088 19.2283C13.5088 19.1215 10.4627 19.1215 9.96275 19.2283C9.53539 19.327 9.07324 19.5566 9.07324 20.0602C9.09809 20.5406 9.37935 20.9646 9.76895 21.2335L9.76795 21.2345C10.2718 21.6273 10.8632 21.877 11.4824 21.9667C11.8123 22.012 12.1482 22.01 12.4901 21.9667C13.1083 21.877 13.6997 21.6273 14.2036 21.2345L14.2026 21.2335C14.5922 20.9646 14.8734 20.5406 14.8983 20.0602C14.8983 19.5566 14.4361 19.327 14.0088 19.2283Z" fill="currentColor"></path>
                      </svg>
                      <span class="bg-danger dots"></span>
                  </a>
                  <div class="p-0 sub-drop dropdown-menu dropdown-menu-end" aria-labelledby="notification-drop">
                      <div class="m-0 shadow-none card">
                        <div class="py-3 card-header d-flex justify-content-between bg-primary">
                            <div class="header-title">
                              <h5 class="mb-0 text-white">All Notifications</h5>
                            </div>
                        </div>
                        <div class="p-0 card-body">
                            <a href="#" class="iq-sub-card">
                              <div class="d-flex align-items-center">
                                  <img class="p-1 avatar-40 rounded-pill bg-soft-primary" src="../main/images/shapes/01.png" alt="">
                                  <div class="ms-3 w-100">
                                    <h6 class="mb-0 ">Emma Watson Bni</h6>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <p class="mb-0">95 MB</p>
                                        <small class="float-end font-size-12">Just Now</small>
                                    </div>
                                  </div>
                              </div>
                            </a>
                            <a href="#" class="iq-sub-card">
                              <div class="d-flex align-items-center">
                                  <div class="">
                                    <img class="p-1 avatar-40 rounded-pill bg-soft-primary" src="main/images/logoicon.png" alt="">
                                  </div>
                                  <div class="ms-3 w-100">
                                    <h6 class="mb-0 ">New customer is join</h6>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <p class="mb-0">Cyst Bni</p>
                                        <small class="float-end font-size-12">5 days ago</small>
                                    </div>
                                  </div>
                              </div>
                            </a>
                            <a href="#" class="iq-sub-card">
                              <div class="d-flex align-items-center">
                                  <img class="p-1 avatar-40 rounded-pill bg-soft-primary" src="../main/images/shapes/03.png" alt="">
                                  <div class="ms-3 w-100">
                                    <h6 class="mb-0 ">Two customer is left</h6>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <p class="mb-0">Cyst Bni</p>
                                        <small class="float-end font-size-12">2 days ago</small>
                                    </div>
                                  </div>
                              </div>
                            </a>
                            <a href="#" class="iq-sub-card">
                              <div class="d-flex align-items-center">
                                  <img class="p-1 avatar-40 rounded-pill bg-soft-primary" src="../main/images/shapes/04.png" alt="">
                                  <div class="w-100 ms-3">
                                    <h6 class="mb-0 ">New Mail from Fenny</h6>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <p class="mb-0">Cyst Bni</p>
                                        <small class="float-end font-size-12">3 days ago</small>
                                    </div>
                                  </div>
                              </div>
                            </a>
                        </div>
                      </div>
                  </div>
                </li>
                <li class="nav-item dropdown">
                  <a href="#" class="nav-link" id="mail-drop" data-bs-toggle="dropdown"  aria-haspopup="true" aria-expanded="false">
                    <svg class="icon-24" width="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                      <path opacity="0.4" d="M22 15.94C22 18.73 19.76 20.99 16.97 21H16.96H7.05C4.27 21 2 18.75 2 15.96V15.95C2 15.95 2.006 11.524 2.014 9.298C2.015 8.88 2.495 8.646 2.822 8.906C5.198 10.791 9.447 14.228 9.5 14.273C10.21 14.842 11.11 15.163 12.03 15.163C12.95 15.163 13.85 14.842 14.56 14.262C14.613 14.227 18.767 10.893 21.179 8.977C21.507 8.716 21.989 8.95 21.99 9.367C22 11.576 22 15.94 22 15.94Z" fill="currentColor"></path>
                      <path d="M21.4759 5.67351C20.6099 4.04151 18.9059 2.99951 17.0299 2.99951H7.04988C5.17388 2.99951 3.46988 4.04151 2.60388 5.67351C2.40988 6.03851 2.50188 6.49351 2.82488 6.75151L10.2499 12.6905C10.7699 13.1105 11.3999 13.3195 12.0299 13.3195C12.0339 13.3195 12.0369 13.3195 12.0399 13.3195C12.0429 13.3195 12.0469 13.3195 12.0499 13.3195C12.6799 13.3195 13.3099 13.1105 13.8299 12.6905L21.2549 6.75151C21.5779 6.49351 21.6699 6.03851 21.4759 5.67351Z" fill="currentColor"></path>
                    </svg>
                    <span class="bg-primary count-mail"></span>
                  </a>
                  <div class="p-0 sub-drop dropdown-menu dropdown-menu-end" aria-labelledby="mail-drop">
                      <div class="m-0 shadow-none card">
                        <div class="py-3 card-header d-flex justify-content-between bg-primary">
                            <div class="header-title">
                              <h5 class="mb-0 text-white">All Message</h5>
                            </div>
                        </div>
                        <div class="p-0 card-body ">
                            <a href="#" class="iq-sub-card">
                              <div class="d-flex align-items-center">
                                  <div class="">
                                    <img class="p-1 avatar-40 rounded-pill bg-soft-primary" src="../main/images/shapes/01.png" alt="">
                                  </div>
                                  <div class="ms-3">
                                    <h6 class="mb-0 ">Bni Emma Watson</h6>
                                    <small class="float-start font-size-12">13 Jun</small>
                                  </div>
                              </div>
                            </a>
                            <a href="#" class="iq-sub-card">
                              <div class="d-flex align-items-center">
                                  <div class="">
                                    <img class="p-1 avatar-40 rounded-pill bg-soft-primary" src="../main/images/shapes/02.png" alt="">
                                  </div>
                                  <div class="ms-3">
                                    <h6 class="mb-0 ">Lorem Ipsum Watson</h6>
                                    <small class="float-start font-size-12">20 Apr</small>
                                  </div>
                              </div>
                            </a>
                            <a href="#" class="iq-sub-card">
                              <div class="d-flex align-items-center">
                                  <div class="">
                                    <img class="p-1 avatar-40 rounded-pill bg-soft-primary" src="../main/images/shapes/03.png" alt="">
                                  </div>
                                  <div class="ms-3">
                                    <h6 class="mb-0 ">Why do we use it?</h6>
                                    <small class="float-start font-size-12">30 Jun</small>
                                  </div>
                              </div>
                            </a>
                            <a href="#" class="iq-sub-card">
                              <div class="d-flex align-items-center">
                                  <div class="">
                                    <img class="p-1 avatar-40 rounded-pill bg-soft-primary" src="../main/images/shapes/04.png" alt="">
                                  </div>
                                  <div class="ms-3">
                                    <h6 class="mb-0 ">Variations Passages</h6>
                                    <small class="float-start font-size-12">12 Sep</small>
                                  </div>
                              </div>
                            </a>
                            <a href="#" class="iq-sub-card">
                              <div class="d-flex align-items-center">
                                  <div class="">
                                    <img class="p-1 avatar-40 rounded-pill bg-soft-primary" src="../main/images/shapes/05.png" alt="">
                                  </div>
                                  <div class="ms-3">
                                    <h6 class="mb-0 ">Lorem Ipsum generators</h6>
                                    <small class="float-start font-size-12">5 Dec</small>
                                  </div>
                              </div>
                            </a>
                        </div>
                      </div>
                  </div>
                </li>
                <li class="nav-item dropdown">
                  <a class="py-0 nav-link d-flex align-items-center" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <img src="main/images/logoicon.png" alt="User-Profile" class="theme-color-default-img img-fluid avatar avatar-50 avatar-rounded">
                    <img src="../main/images/avatars/avtar_1.png" alt="User-Profile" class="theme-color-purple-img img-fluid avatar avatar-50 avatar-rounded">
                    <img src="../main/images/avatars/avtar_2.png" alt="User-Profile" class="theme-color-blue-img img-fluid avatar avatar-50 avatar-rounded">
                    <img src="../main/images/avatars/avtar_4.png" alt="User-Profile" class="theme-color-green-img img-fluid avatar avatar-50 avatar-rounded">
                    <img src="../main/images/avatars/avtar_5.png" alt="User-Profile" class="theme-color-yellow-img img-fluid avatar avatar-50 avatar-rounded">
                    <img src="../main/images/avatars/avtar_3.png" alt="User-Profile" class="theme-color-pink-img img-fluid avatar avatar-50 avatar-rounded">
                    <div class="caption ms-3 d-none d-md-block ">
                        <h6 class="mb-0 caption-title">Shyam Yadav</h6>
                        <p class="mb-0 caption-sub-title">MBZ372847238</p>
                    </div>
                  </a>
                  <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                    <li><a class="dropdown-item" href="/User/EditProfile">Profile</a></li>
                    <li><a class="dropdown-item" href="../dashboard/app/user-privacy-setting.html">Privacy Setting</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item" href="../dashboard/auth/sign-in.html">Logout</a></li>
                  </ul>
                </li>
              </ul>
            </div>
          </div>
        </nav>
<div class="iq-navbar-header" style="height: 215px; position: relative; overflow: hidden; perspective: 1000px;">
    <!-- Header content -->
    <div class="container-fluid iq-container" style="position: relative; z-index: 2; transform-style: preserve-3d;" id="headerContent">
        <div class="row">
            <div class="col-md-12">
                <div class="flex-wrap d-flex justify-content-between align-items-center">
                    <div>
                      <h1 class="slide-in-left text-3d" data-depth="30">Welcome To Meta Benz</h1>
<p class="slide-in-left delay-1 text-3d" data-depth="20">
    This is the dashboard where you can check your reports of income.
</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Header images -->
    <div class="iq-header-img position-absolute top-0 start-0 w-100 h-100" style="z-index: 1; transform-style: preserve-3d;" id="headerImages">
        <img src="../main/images/head2.png" class="theme-color-default-img img-fluid w-100 h-100 bg-zoom" data-depth="5">
        <img src="../main/images/unnamed.jpg" class="theme-color-purple-img img-fluid w-100 h-100 bg-zoom" data-depth="10">
        <img src="../main/images/dashboard/top-header2.png" class="theme-color-blue-img img-fluid w-100 h-100 bg-zoom" data-depth="8">
        <img src="../main/images/dashboard/top-header3.png" class="theme-color-green-img img-fluid w-100 h-100 bg-zoom" data-depth="12">
        <img src="../main/images/dashboard/top-header4.png" class="theme-color-yellow-img img-fluid w-100 h-100 bg-zoom" data-depth="6">
        <img src="../main/images/dashboard/top-header5.png" class="theme-color-pink-img img-fluid w-100 h-100 bg-zoom" data-depth="4">
    </div>

  

    <!-- Light streak -->
    <div class="light-streak" data-depth="25"></div>
</div>

<style>
  .text-3d {
    color: #fff;
    font-weight: 700;
    text-shadow: 
        1px 1px 0 rgba(0,0,0,0.2),
        2px 2px 0 rgba(0,0,0,0.2),
        3px 3px 0 rgba(0,0,0,0.15),
        4px 4px 0 rgba(0,0,0,0.1);
    transform-style: preserve-3d;
    transition: transform 0.1s ease-out;
}

/* Optional: subtle floating animation */
.text-3d {
    animation: floatText 6s ease-in-out infinite;
}
@keyframes floatText {
    0% { transform: translate3d(0,0,0); }
    50% { transform: translate3d(0,-5px,5px); }
    100% { transform: translate3d(0,0,0); }
}
/* Text animations */
@keyframes slideInLeft { 0% { opacity: 0; transform: translateX(-50px); } 100% { opacity: 1; transform: translateX(0); } }
.slide-in-left { animation: slideInLeft 1s forwards; }
.delay-1 { animation-delay: 0.5s; }

/* Background image subtle zoom */
.bg-zoom { animation: pulseBG 20s ease-in-out infinite; object-fit: cover; }
@keyframes pulseBG { 0% { transform: scale(1); } 50% { transform: scale(1.05); } 100% { transform: scale(1); } }

/* Floating blobs */
.blob { position: absolute; border-radius: 50%; background: rgba(255,255,255,0.05); animation: floatBlob 15s ease-in-out infinite; }
@keyframes floatBlob { 0% { transform: translate(0,0) scale(1); } 50% { transform: translate(50px,-30px) scale(1.2); } 100% { transform: translate(0,0) scale(1); } }

/* Light streak */
.light-streak { position: absolute; top: 0; left: -200px; width: 200px; height: 100%; background: linear-gradient(90deg, rgba(255,255,255,0) 0%, rgba(255,255,255,0.15) 50%, rgba(255,255,255,0) 100%); animation: streakMove 6s linear infinite; z-index: 4; }
@keyframes streakMove { 0% { left: -200px; } 100% { left: 100%; } }

</style>

<script>
const header = document.querySelector('.iq-navbar-header');
const layers = header.querySelectorAll('[data-depth]');

function parallax(e) {
    const {innerWidth: w, innerHeight: h} = window;
    const x = (e.clientX - w/2);
    const y = (e.clientY - h/2);
    
    layers.forEach(el => {
        const depth = el.getAttribute('data-depth');
        const moveX = (x * depth / 200); // adjust sensitivity
        const moveY = (y * depth / 200);
        el.style.transform = `translate3d(${moveX}px, ${moveY}px, 0)`;
    });
}

// Desktop
header.addEventListener('mousemove', parallax);

// Mobile
header.addEventListener('touchmove', function(e){
    const touch = e.touches[0];
    parallax(touch);
});
</script>


        @yield('content')
    </main>
     <a class="btn btn-fixed-end btn-warning btn-icon btn-setting" data-bs-toggle="offcanvas" data-bs-target="#offcanvasExample" role="button" aria-controls="offcanvasExample">
      <svg width="24" viewBox="0 0 24 24" class="animated-rotate icon-24" fill="none" xmlns="http://www.w3.org/2000/svg">
          <path fill-rule="evenodd" clip-rule="evenodd" d="M20.8064 7.62361L20.184 6.54352C19.6574 5.6296 18.4905 5.31432 17.5753 5.83872V5.83872C17.1397 6.09534 16.6198 6.16815 16.1305 6.04109C15.6411 5.91402 15.2224 5.59752 14.9666 5.16137C14.8021 4.88415 14.7137 4.56839 14.7103 4.24604V4.24604C14.7251 3.72922 14.5302 3.2284 14.1698 2.85767C13.8094 2.48694 13.3143 2.27786 12.7973 2.27808H11.5433C11.0367 2.27807 10.5511 2.47991 10.1938 2.83895C9.83644 3.19798 9.63693 3.68459 9.63937 4.19112V4.19112C9.62435 5.23693 8.77224 6.07681 7.72632 6.0767C7.40397 6.07336 7.08821 5.98494 6.81099 5.82041V5.82041C5.89582 5.29601 4.72887 5.61129 4.20229 6.52522L3.5341 7.62361C3.00817 8.53639 3.31916 9.70261 4.22975 10.2323V10.2323C4.82166 10.574 5.18629 11.2056 5.18629 11.8891C5.18629 12.5725 4.82166 13.2041 4.22975 13.5458V13.5458C3.32031 14.0719 3.00898 15.2353 3.5341 16.1454V16.1454L4.16568 17.2346C4.4124 17.6798 4.82636 18.0083 5.31595 18.1474C5.80554 18.2866 6.3304 18.2249 6.77438 17.976V17.976C7.21084 17.7213 7.73094 17.6516 8.2191 17.7822C8.70725 17.9128 9.12299 18.233 9.37392 18.6717C9.53845 18.9489 9.62686 19.2646 9.63021 19.587V19.587C9.63021 20.6435 10.4867 21.5 11.5433 21.5H12.7973C13.8502 21.5001 14.7053 20.6491 14.7103 19.5962V19.5962C14.7079 19.088 14.9086 18.6 15.2679 18.2407C15.6272 17.8814 16.1152 17.6807 16.6233 17.6831C16.9449 17.6917 17.2594 17.7798 17.5387 17.9394V17.9394C18.4515 18.4653 19.6177 18.1544 20.1474 17.2438V17.2438L20.8064 16.1454C21.0615 15.7075 21.1315 15.186 21.001 14.6964C20.8704 14.2067 20.55 13.7894 20.1108 13.5367V13.5367C19.6715 13.284 19.3511 12.8666 19.2206 12.3769C19.09 11.8873 19.16 11.3658 19.4151 10.928C19.581 10.6383 19.8211 10.3982 20.1108 10.2323V10.2323C21.0159 9.70289 21.3262 8.54349 20.8064 7.63277V7.63277V7.62361Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
          <circle cx="12.1747" cy="11.8891" r="2.63616" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></circle>
      </svg>
    </a>
 <!-- offcanvas start -->
    <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasExample" data-bs-scroll="true" data-bs-backdrop="true" aria-labelledby="offcanvasExampleLabel">
      <div class="offcanvas-header">
        <div class="d-flex align-items-center">
          <h3 class="offcanvas-title me-3" id="offcanvasExampleLabel">Settings</h3>
        </div>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
      </div>
      <div class="offcanvas-body data-scrollbar">
        <div class="row">
       <div class="col-lg-12">
    <h5 class="mb-3">Scheme</h5>
    <div class="d-grid gap-3 grid-cols-3 mb-4">
        <div class="btn btn-border" data-setting="color-mode" data-name="color" data-value="auto">
            <svg class="icon-20" width="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path fill="currentColor" d="M7,2V13H10V22L17,10H13L17,2H7Z" />
            </svg>
            <span class="ms-2 "> Auto </span>
        </div>

        <div class="btn btn-border active" data-setting="color-mode" data-name="color" data-value="dark">
            <svg class="icon-20" width="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path fill="currentColor" d="M9,2C7.95,2 6.95,2.16 6,2.46C10.06,3.73 13,7.5 13,12C13,16.5 10.06,20.27 6,21.54C6.95,21.84 7.95,22 9,22A10,10 0 0,0 19,12A10,10 0 0,0 9,2Z" />
            </svg>
            <span class="ms-2 "> Dark  </span>
        </div>

        <div class="btn btn-border" data-setting="color-mode" data-name="color" data-value="light">
            <svg class="icon-20" width="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path fill="currentColor" d="M12,8A4,4 0 0,0 8,12A4,4 0 0,0 12,16A4,4 0 0,0 16,12A4,4 0 0,0 12,8M12,18A6,6 0 0,1 6,12A6,6 0 0,1 12,6A6,6 0 0,1 18,12A6,6 0 0,1 12,18M20,8.69V4H15.31L12,0.69L8.69,4H4V8.69L0.69,12L4,15.31V20H8.69L12,23.31L15.31,20H20V15.31L23.31,12L20,8.69Z" />
            </svg>
            <span class="ms-2 "> Light</span>
        </div>
    </div>
    <hr class="hr-horizontal"> 

    <h5 class="mt-4 mb-3">Sidebar Color</h5>
    <div class="d-grid gap-3 grid-cols-2 mb-4">
        <div class="btn btn-border d-block" data-setting="sidebar" data-name="sidebar-color" data-value="sidebar-white">
            <span class=""> Default </span>
        </div>
        <div class="btn btn-border d-block" data-setting="sidebar" data-name="sidebar-color" data-value="sidebar-dark">
            <span class=""> Dark </span>
        </div>
        <div class="btn btn-border d-block" data-setting="sidebar" data-name="sidebar-color" data-value="sidebar-color">
            <span class=""> Color </span>
        </div>
        <div class="btn btn-border d-block" data-setting="sidebar" data-name="sidebar-color" data-value="sidebar-transparent">
            <span class=""> Transparent </span>
        </div>
    </div>
</div>

        </div>
      </div>
    </div>
    <!-- JS -->
       <!-- Library Bundle Script -->
    <script src="../main/js/core/libs.min.js"></script>
    
    <!-- External Library Bundle Script -->
    <script src="../main/js/core/external.min.js"></script>
    
    <!-- Widgetchart Script -->
    <script src="../main/js/charts/widgetcharts.js"></script>
    
    <!-- mapchart Script -->
    <script src="../main/js/charts/vectore-chart.js"></script>
    <script src="../main/js/charts/dashboard.js" ></script>
    
    <!-- fslightbox Script -->
    <script src="../main/js/plugins/fslightbox.js"></script>
    
    <!-- Settings Script -->
    <script src="../main/js/plugins/setting.js"></script>
    
    <!-- Slider-tab Script -->
    <script src="../main/js/plugins/slider-tabs.js"></script>
    
    <!-- Form Wizard Script -->
    <script src="../main/js/plugins/form-wizard.js"></script>
    
    <!-- AOS Animation Plugin-->
    <script src="../main/vendor/aos/dist/aos.js"></script>
    
    <!-- App Script -->
    <script src="../main/js/hope-ui.js" defer></script>
</body>
</html>
