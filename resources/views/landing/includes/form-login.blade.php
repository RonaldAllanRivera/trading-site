<div class="form-block w-form-wrapper">
  <form action="{{ route('login.perform') }}" class="login-form" data-name="login-form" id="login-form" method="post" name="wf-form-login-form">
    @csrf
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
    <div class="form-group">
      <input class="form-control form-control-bg email-control w-input" data-name="FunnelLoginForm[email]" maxlength="256" name="email" placeholder="Email" type="email"/>
      <div class="warning-icon"></div>
    </div>
    <div class="form-group">
      <input class="form-control form-control-bg pass-control w-input" data-name="FunnelLoginForm[password]" maxlength="256" name="password" placeholder="Password" type="password"/>
      <div class="warning-icon"></div>
    </div>
    <button class="btn btn-login w-button" data-wait="Please wait..." type="submit">Login</button>
    <div style="margin-top:8px;">
      <a href="{{ route('password.request') }}">Forgot your password?</a>
    </div>
  </form>
</div>
