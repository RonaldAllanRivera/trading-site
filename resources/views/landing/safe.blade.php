@extends('layouts.landing')

@section('title', 'Safe Page')

@section('content')
  <main class="content">
    <div class="intro-section wf-section">
      <div class="container w-container">
        <h1 class="intro-title">Welcome</h1>
        <p class="p">This is a general information page.</p>
      </div>
    </div>

    <div class="section wf-section">
      <div class="container w-container">
        <div class="richtext w-richtext">
          <h2>About This Page</h2>
          <p>
            This page provides generic information suitable for broad audiences and automated review systems.
          </p>
          <p>
            If you are looking for more product details, offers, or interactive features, please navigate using the site menu.
          </p>
        </div>
      </div>
    </div>
  </main>
@endsection
