@extends('layouts.landing')

@section('title', 'Privacy Policy')

@section('content')
    <main class="content">
      <div class="intro-section bg wf-section">
        <div class="container w-container">
          <h1 class="intro-title white">PRIVACY POLICY<br/></h1>
        </div>
      </div>
      <div class="legal-section wf-section">
        <div class="container">
          <div class="breadcrumbs">
            <ol>
              <li><a href="/">Immediate Trade Pro</a></li>
              <li>Privacy Policy</li>
            </ol>
          </div>
          @include('landing.pages.privacy-content')
        </div>
      </div>
    </main>
@endsection
