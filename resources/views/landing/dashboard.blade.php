@extends('layouts.landing')

@section('title', 'Dashboard')

@section('content')
  <main class="content">
    <div class="intro-section wf-section">
      <div class="container w-container">
        <h1 class="intro-title">Welcome, {{ auth()->user()->name ?: auth()->user()->email }}!</h1>
        <p class="p">This is your public dashboard. From here, you can manage your profile and continue your journey.</p>
        <form action="{{ route('logout') }}" method="post" style="margin-top: 20px;">
          @csrf
          <button class="btn w-button" type="submit">Logout</button>
        </form>
      </div>
    </div>
  </main>
@endsection
