@extends('layouts.landing')

@section('title', 'Terms and Conditions')

@section('content')
    <main class="content">
      <div class="intro-section bg wf-section">
        <div class="container w-container">
          <h1 class="intro-title white">TERMS &amp; CONDITIONS<br/></h1>
        </div>
      </div>
      <div class="legal-section wf-section">
        <div class="container">
          <div class="breadcrumbs">
            <ol>
              <li><a href="/">Immediate Trade Pro</a></li>
              <li>Terms and Conditions</li>
            </ol>
          </div>
          @include('landing.pages.terms-content')
        </div>
      </div>
    </main>
@endsection
