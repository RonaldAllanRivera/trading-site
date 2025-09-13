@extends('layouts.landing')

@section('title', 'Forgot Password')

@section('content')
  <main class="content">
    <div class="intro-section wf-section">
      <div class="container w-container">
        <h1 class="intro-title">Forgot your password?</h1>
        <p class="p">Enter your email and we will send you a password reset link.</p>
      </div>
    </div>

    <div class="form-section wf-section">
      <div class="container w-container" style="max-width:560px;">
        @if (session('status'))
          <div class="alert success" role="alert">{{ session('status') }}</div>
        @endif
        @if ($errors->any())
          <div class="alert error" role="alert">
            <ul>
              @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
              @endforeach
            </ul>
          </div>
        @endif

        <form action="{{ route('password.email') }}" method="post" class="members-form">
          @csrf
          <div class="form-group">
            <input class="form-control w-input" type="email" name="email" placeholder="Email" required />
          </div>
          <button class="btn w-button" type="submit">Email Password Reset Link</button>
        </form>

        <div style="margin-top:16px;">
          <a href="{{ route('login') }}">Back to Login</a>
        </div>
      </div>
    </div>
  </main>
@endsection
