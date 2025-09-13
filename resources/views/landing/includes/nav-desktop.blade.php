<div class="h-links-wrap w-nav" data-animation="default" data-collapse="none" data-duration="400" data-easing="ease" data-easing2="ease" role="banner">
    <nav class="h-links w-nav-menu" role="navigation">
        <a class="h-link w-nav-link" href="#">About Us</a>
        <a class="h-link w-nav-link" href="#">Contact Us</a>
        @guest
            <a class="h-link w-nav-link" href="/sign-up">Sign Up</a>
            <a class="h-login w-inline-block" href="/login">
                <div class="h-login-ico">
                    <img alt="Immediate Trade Pro - Sign Up and Enjoy a Complimentary Premium Account Today!" class="h-login-img" loading="lazy" src="{{ asset('landing-pages/img/login-ico_1login-ico.png') }}"/>
                </div>
                <div class="h-login-text">Login</div>
            </a>
        @else
            <form action="{{ route('logout') }}" method="post" style="display:inline;">
                @csrf
                <button type="submit" class="h-login w-inline-block" style="background:none;border:0;padding:0;cursor:pointer;">
                    <div class="h-login-ico">
                        <img alt="Immediate Trade Pro - Logout" class="h-login-img" loading="lazy" src="{{ asset('landing-pages/img/login-ico_1login-ico.png') }}"/>
                    </div>
                    <div class="h-login-text">Logout</div>
                </button>
            </form>
        @endguest
        <a class="btn h-started-btn anchor-js w-button" href="#formTop">Get started</a>
    </nav>
</div>
