@extends('layouts.landing')

@section('title', 'Login')

@section('content')
  <main class="content login-bg">
    <div class="intro-section abs wf-section">
      <div class="container w-container">
        <h1 class="intro-title abt">Visit the Immediate Trade Pro Registration Page and Sign Up Now!<br/></h1>
      </div>
    </div>
    <div class="form-section wf-section">
      <div class="container w-container">
        <div class="breadcrumbs white">
          <ol>
            <li><a href="/">Immediate Trade Pro</a></li>
            <li>Login</li>
          </ol>
        </div>
        <h2 class="login-form-title">
          Welcome to Immediate Trade Pro – Discover the Power of Crypto Trading with the Immediate Trade Pro Platform<br/>
          Sign in Below and Embark on Your Trading Journey<br/>
        </h2>
        <div class="forms-wrap">
          <div class="f-col f-col-1">
            <div class="login-form-subtitle">Enter your login info below and start trading.</div>
            <div class="form-pre-wrap">
              @include('landing.includes.form-login')
            </div>
            <p class="form-text">Welcome to the Official Web Portal of Immediate Trade Pro. Fill out the Registration Form Here<br/></p>
          </div>
          <div class="f-col f-col-2">
            <div class="form-container w500" id="formTop">
              @include('landing.includes.form-signup')
            </div>
          </div>
          <div class="f-col form-img-col"></div>
        </div>
      </div>
    </div>
    <div class="still-section wf-section">
      <div class="container relative w-container">
        <div class="cols still-cols">
          <div class="col-50 text-col">
            <h2 class="title still-title">
              Ready to Master Cryptocurrency Trading? Look no further - meet Immediate Trade Pro! Our groundbreaking platform empowers traders of all levels to thrive in the market and become skilled individuals with a profound understanding of market dynamics. Leave behind worries about market research and analysis as Immediate Trade Pro's cutting-edge software takes care of it for you. Seize this opportunity and embark on your cryptocurrency trading journey today!
              <br/>
            </h2>
            <p class="p still-p">Embrace the benefits of our cutting-edge trading platform by joining the vibrant Immediate Trade Pro community now.</p>
            <div class="still-btn-wrap">
              <a class="btn w-button" href="#formTop">Embark on a Powerful Trading Journey with the All-Inclusive Immediate Trade Pro Platform.</a>
            </div>
          </div>
          <div class="col-50 trade-img-col">
            <div class="still-img-wrap">
              <img alt="Immediate Trade Pro" class="still-img radi" loading="lazy" sizes="(max-width: 479px) 100vw, (max-width: 767px) 57vw, (max-width: 991px) 48vw, 35vw" src="{{ asset('landing-pages/img/still.webp') }}"/>
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>
@endsection
