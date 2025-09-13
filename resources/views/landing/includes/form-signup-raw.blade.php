<div class="form-title-box">
  <h3 class="form-title">Sign Up and Enjoy a Complimentary Premium Account Today!</h3>
</div>
<div class="form-box w-form-wrapper">
  <form action="{{ route('leads.store') }}" class="members-form" data-name="Email Form" id="email-form" method="post" name="email-form">
    @csrf
    @if (session('success'))
      <div class="alert success" role="alert">{{ session('success') }}</div>
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
    <div class="form-row">
      <div class="form-cell form-cell-fn">
        <div class="form-group">
          <input class="form-control w-input" data-name="FunnelRegistrationForm[first_name]" maxlength="256" name="first_name" placeholder="First Name" type="text"/>
          <div class="warning-icon"></div>
        </div>
      </div>
      <div class="form-cell form-cell-ln">
        <div class="form-group">
          <input class="form-control w-input" data-name="FunnelRegistrationForm[last_name]" maxlength="256" name="last_name" placeholder="Last Name" type="text"/>
          <div class="warning-icon"></div>
        </div>
      </div>
    </div>
    <div class="form-group">
      <input class="form-control w-input" data-name="FunnelRegistrationForm[email]" maxlength="256" name="email" placeholder="E-mail" type="email"/>
      <div class="warning-icon"></div>
    </div>
    <div class="form-row-nowrap">
      <div class="form-cell">
        <div class="form-group">
          <input id="signup-password" class="form-control w-input" data-name="FunnelRegistrationForm[password]" maxlength="256" name="password" placeholder="Password (you can use a simple one)" type="password" autocomplete="new-password"/>
          <div class="warning-icon"></div>
          <div class="password-visibility" style="margin-top:4px;">
            <button type="button" class="toggle-visibility" aria-pressed="false" aria-controls="signup-password" style="padding:4px 8px;border:1px solid #e5e7eb;border-radius:4px;background:#fff;color:#374151;font-size:12px;cursor:pointer;">Show</button>
          </div>          
        </div>
      </div>
      <div class="form-cell">
        <div class="btn generate-pass">Generate passwords</div>
      </div>
    </div>
    <div class="form-group">
      <input class="form-control w-input" data-name="FunnelRegistrationForm[country]" maxlength="256" name="country" placeholder="Country" type="text"/>
      <div class="warning-icon"></div>
    </div>
    <div class="phone-row">
      <div class="prefix-cell">
        <div class="form-group">
          <input class="form-control fc-prefix w-input" data-name="FunnelRegistrationForm[phone_prefix]" maxlength="256" name="phone_prefix" placeholder="Prefix" type="text" inputmode="tel" autocomplete="tel"/>
          <div class="warning-icon"></div>
        </div>
      </div>
      <div class="phone-cell">
        <div class="form-group">
          <input class="form-control w-input" data-name="FunnelRegistrationForm[phone_number]" maxlength="256" name="phone_number" placeholder="Phone" type="text" inputmode="tel" autocomplete="tel"/>
          <div class="warning-icon"></div>
        </div>
      </div>
    </div>
    <button class="btn btn-submit submit-btn w-button" data-wait="Please wait..." type="submit">EMBARK ON ONLINE CRYPTO TRADING NOW</button>
    <div class="form-footer">
      By registering and creating an account, you certify that you have read and agreed to our
      <a href="/terms" target="_blank">Terms and Conditions</a>
      and
      <a href="/privacy" target="_blank">Privacy Policy</a>
      and
      <a href="/cookie" target="_blank">Cookie Policy</a>.
      <div class="members-form-policy-toggle">Read More</div>
      <div class="members-form-policy-tooltip" style="display: none;"></div>
    </div>
    <div class="scenario-input w-embed">
      <input name="scenario" type="hidden" value="_user_registration_without_phone"/>
    </div>
  </form>
</div>

<script>
  document.addEventListener('DOMContentLoaded', function () {
    var genBtn = document.querySelector('.generate-pass');
    var pwd = document.getElementById('signup-password');
    var tipIcon = document.querySelector('.password-tip .tip-icon');
    var tipBox = document.getElementById('pwd-tip');
    var toggleBtn = document.querySelector('.password-visibility .toggle-visibility');
    if (genBtn && pwd) {
      genBtn.addEventListener('click', function (e) {
        e.preventDefault();
        // Generate a simple, memorable password like trade123
        var simple = 'trade' + Math.floor(100 + Math.random() * 900);
        pwd.value = simple;
        try { pwd.dispatchEvent(new Event('input', { bubbles: true })); } catch (err) {}
        // Show the password after generating
        if (toggleBtn) {
          pwd.type = 'text';
          toggleBtn.textContent = 'Hide';
          toggleBtn.setAttribute('aria-pressed', 'true');
        }
      });
    }

    if (tipIcon && tipBox) {
      tipIcon.addEventListener('click', function (e) {
        e.preventDefault();
        var expanded = tipIcon.getAttribute('aria-expanded') === 'true';
        tipIcon.setAttribute('aria-expanded', (!expanded).toString());
        tipBox.style.display = expanded ? 'none' : 'block';
      });

      document.addEventListener('click', function (e) {
        if (!tipBox.contains(e.target) && !tipIcon.contains(e.target)) {
          tipIcon.setAttribute('aria-expanded', 'false');
          tipBox.style.display = 'none';
        }
      });
    }

    if (toggleBtn && pwd) {
      toggleBtn.addEventListener('click', function (e) {
        e.preventDefault();
        var isText = pwd.type === 'text';
        pwd.type = isText ? 'password' : 'text';
        toggleBtn.textContent = isText ? 'Show' : 'Hide';
        toggleBtn.setAttribute('aria-pressed', (!isText).toString());
      });
    }
  });
  </script>
