<div class="h-links-wrap-mobile w-nav" data-animation="default" data-collapse="none" data-duration="400" data-easing="ease" data-easing2="ease" role="banner">
    <nav class="h-links-mobile w-nav-menu" role="navigation">
        @guest
            <a class="h-login w-inline-block" href="/login">
                <div class="h-login-ico">
                    <img alt="Immediate Trade Pro - Login" class="h-login-img" loading="lazy" src="{{ asset('landing-pages/img/login-ico_1login-ico.png') }}"/>
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
        <div class="h-hamburger" id="h-hamburger">
            <div class="ham-line"></div>
            <div class="ham-line"></div>
            <div class="ham-line mb0"></div>
        </div>
    </nav>
</div>
