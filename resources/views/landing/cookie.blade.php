@extends('layouts.landing')

@section('title', 'Cookie Policy')

@section('content')
    <main class="content">
      <div class="intro-section bg wf-section">
        <div class="container w-container">
          <h1 class="intro-title white">Cookie Policy</h1>
        </div>
      </div>
      <div class="legal-section wf-section">
        <div class="container w-container">
          <div class="breadcrumbs">
            <ol>
              <li><a href="/">Immediate Trade Pro</a></li>
              <li>Cookie Policy</li>
            </ol>
          </div>
          @include('landing.pages.cookie-content')
        </div>
      </div>
    </main>
@endsection
