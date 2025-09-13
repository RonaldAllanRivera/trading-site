<header class="header wf-section">
    <div class="top-warning">
        <p class="warning">
            <strong class="today-date">DD/MM/YYYY</strong>
            – <span class="countdown">mm:ss</span>
        </p>
    </div>
    @auth
    <div class="user-banner" style="background: #f8fafc; border-bottom: 1px solid #e5e7eb;">
        <div class="container w-container" style="display: flex; align-items: center; justify-content: space-between; padding: 8px 0;">
            <div class="user-greeting" style="font-size: 14px; color: #111827;">
                Hello, {{ auth()->user()->name ?: auth()->user()->email }}
            </div>
            <div class="user-actions">
                <a href="{{ route('dashboard') }}" class="btn small w-button" style="padding: 6px 12px;">Go to Dashboard</a>
            </div>
        </div>
    </div>
    @endauth
    <div class="bottom-head">
        <div class="container w-container">
            <div class="header-wrap">
                <a class="logo w-inline-block" href="/">
                    <img alt="Immediate Trade Pro - Sign Up and Enjoy a Complimentary Premium Account Today!" class="logo-img" height="40" loading="lazy" src="{{ asset('landing-pages/img/logo-d8e1bc53.png') }}" width="110"/>
                </a>
                @include('landing.includes.nav-desktop')
                <div class="lang-ham-wrap">
                    <div id="languageSelect">
                        <div class="languageSelect-container">
                            <div class="languageSelect-toggle">
                                <div class="flag-icon flag-icon-gb"></div>
                                <div class="lang">EN</div>
                                <div class="arrow"></div>
                            </div>
                            <nav class="languageSelect-list">
                                <div class="languageSelect-list-item">
                                    <a class="languageSelect-list-item-link selectedLanguage" data-lang="en" href="/">
                                        <div class="languageSelect-list-item-link-flag flag-icon flag-icon-gb"></div>
                                        <div>English</div>
                                    </a>
                                </div>
                            </nav>
                        </div>
                    </div>
                    @include('landing.includes.nav-mobile')
                </div>
            </div>
        </div>
    </div>
    <div class="mob-links-modal" id="mob-links-modal">
        <a class="close-modal-btn" href="#" id="close-modal-btn">+</a>
        <div class="modal-links">
            <div class="modal-link"><a class="modal-link-a" href="/sign-up">Sign Up</a></div>
            <div class="modal-link"><a class="modal-link-a" href="#">About Us</a></div>
            <div class="modal-link"><a class="modal-link-a" href="#">Contact Us</a></div>
            <div class="modal-link"><a class="modal-link-a" href="/privacy">Privacy Policy</a></div>
            <div class="modal-link"><a class="modal-link-a" href="/terms">Terms and Conditions</a></div>
            <div class="modal-link"><a class="modal-link-a" href="/cookie">Cookie Policy</a></div>
            <div class="modal-link started">
                <a class="btn modal-started-btn w-button" href="#formTop">EMBARK ON ONLINE CRYPTO TRADING NOW</a>
            </div>
        </div>
    </div>
</header>
