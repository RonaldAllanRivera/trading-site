@extends('layouts.landing')

@section('title', 'Sign Up')

@section('content')
  <main class="content login-bg">
    <div class="intro-section abs wf-section">
      <div class="container w-container">
        <h1 class="intro-title abt">Immediate Trade Pro Sign Up<br/></h1>
      </div>
    </div>
    <div class="form-section wf-section">
      <div class="container w-container">
        <div class="breadcrumbs white">
          <ol>
            <li><a href="/">Immediate Trade Pro</a></li>
            <li>Sign Up</li>
          </ol>
        </div>
        <div class="sgn-form-wrap forms-wrap">
          <div class="f-col f-col-1">
            <h2 class="login-form-title">Sign up to Immediate Trade Pro</h2>
            <p class="form-text">Step into the future of trading with Immediate Trade Pro! Advanced tools and analytics help refine your approach and grow your earnings. Sign up today for intelligent trading.</p>
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
  </main>
@endsection
