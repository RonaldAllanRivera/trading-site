@extends('layouts.landing')

@section('title', 'Reset Password')

@section('content')
  <main class="content">
    <div class="intro-section wf-section">
      <div class="container w-container">
        <h1 class="intro-title">Reset your password</h1>
        <p class="p">Enter your new password below.</p>
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

        <form action="{{ route('password.update') }}" method="post" class="members-form">
          @csrf
          <input type="hidden" name="token" value="{{ $token }}" />
          <input type="hidden" name="email" value="{{ old('email', $email) }}" />
          <div class="form-group">
            <input class="form-control w-input" type="password" name="password" placeholder="New password" required autocomplete="new-password" />
          </div>
          <div class="form-group">
            <input class="form-control w-input" type="password" name="password_confirmation" placeholder="Confirm new password" required autocomplete="new-password" />
          </div>
          <button class="btn w-button" type="submit">Reset Password</button>
        </form>

        <div style="margin-top:16px;">
          <a href="{{ route('login') }}">Back to Login</a>
        </div>
      </div>
    </div>
  </main>
@endsection
