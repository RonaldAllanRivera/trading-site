<script src="{{ asset('landing-pages/js/jquery-3.5.1.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('landing-pages/js/the-quantum-ai.js') }}" type="text/javascript"></script>
<script>
 $(document).ready(function(){
    let modal = $("#mob-links-modal");
    let stickyBtnWrap = $(".sticky-btn-wrap");
    var scrolled = false;
    function showModal(){
      stickyBtnWrap.addClass('d-none');
      modal.removeClass('d-none');
      modal.addClass('d-block');
      setTimeout(function(){ modal.addClass('h-show'); }, 0)
    }
    function closeModal(){
      modal.removeClass('h-show');
      setTimeout(function(){
        modal.removeClass('d-block');
        modal.addClass('d-none');
        stickyBtnWrap.removeClass('d-none');
      }, 300)
    }
    $("#h-hamburger").on('click', function(e) { showModal(); })
    $("#close-modal-btn, #mob-links-modal").on('click', function(e) { closeModal(); })
    $(document).on("scroll",function(){
      if(!scrolled && $(this).scrollTop()>500){
        scrolled = true; closeModal();
      } else if(scrolled && $(this).scrollTop()<500){
        scrolled = false;
      }
    });
  })
</script>
<script src="{{ asset('landing-pages/js/webfont.js') }}" type="text/javascript"></script>
<script type="text/javascript">WebFont.load({  google: {    families: ["Ubuntu:700","Roboto:regular,500,700&display=swap"]  }});</script>
<div style="display: none">SB2.0 2025-02-14 02:50:13</div>
<script async src="{{ asset('landing-pages/js/languageSwitcher.js') }}"></script>
<link href="{{ asset('landing-pages/css/flag-icon.min.css') }}" media="print" onload="this.media='all'" rel="stylesheet"/>
<style>
 .top-warning { .warning { &:before { font-size: 14px; font-weight: 700; line-height: 1; content: 'Warning: Due to extremely high media demand, we will close registration as of'; color: inherit; } } }
 .members-form-policy-tooltip:after { display: block; width: 100%; height: auto; content: 'By registering and creating an account you hereby confirm and acknowledge that we are neither brokers nor financial advisors. We are not operating any technology ourselves nor do we hold the ability to send signals of any kind. The information brought to you herein is for your informational purposes solely and shall not constitute as financial advice nor shall it impose any liability on our part. You always must conduct market research independently and consult a professional advisor before making any investment decisions. We may transfer or release your private data for marketing or business purposes to 3rd parties that we may get remunerated for, that may use this data to contact you or to carry out their own business operations and purposes with you directly. You further certify that you have read and agreed to our Terms and Conditions and Privacy Policy and Cookie Policy.'; white-space: pre-wrap; }
 .footer-disclaimer:after { display: block; width: 100%; height: auto; font-size: 12px; font-weight: 400; content: 'HIGH RISK WARNING: Dealing or Trading FX, CFDs and Cryptocurrencies is highly speculative, carries a level of non-negligible risk and may not be suitable for all investors. You may lose some or all of your invested capital, therefore you should not speculate with capital that you cannot afford to lose. Please refer to the risk disclosure below. Immediate Trade Pro does not gain or lose profits based on your activity and operates as a services company. Immediate Trade Pro is not a financial services firm and is not eligible of providing financial advice. Therefore, Immediate Trade Pro shall not be liable for any losses occurred via or in relation to this informational website.\A\A SITE RISK DISCLOSURE: Immediate Trade Pro does not accept any liability for loss or damage as a result of reliance on the information contained within this website; this includes education material, price quotes and charts, and analysis. Please be aware of and seek professional advice for the risks associated with trading the financial markets; never invest more money than you can risk losing. The risks involved in FX, CFDs and Cryptocurrencies may not be suitable for all investors. Immediate Trade Pro doesn\'t retain responsibility for any trading losses you might face as a result of using or inferring from the data hosted on this site.\A\A LEGAL RESTRICTIONS: Without limiting the above mentioned provisions, you understand that laws regarding financial activities vary throughout the world, and it is your responsibility to make sure you properly comply with any law, regulation or guideline in your country of residence regarding the use of the Site. To avoid any doubt, the ability to access our Site does not necessarily mean that our Services and/or your activities through the Site are legal under the laws, regulations or directives relevant to your country of residence. It is against the law to solicit US individuals to buy and sell commodity options, even if they are called...'; white-space: pre-wrap; }
</style>
<script>
  function startTimer(duration, display) {
      var timer = duration, minutes, seconds, intervalId;
      function render() {
          minutes = parseInt(timer / 60, 10);
          seconds = parseInt(timer % 60, 10);
          minutes = minutes < 10 ? "0" + minutes : minutes;
          seconds = seconds < 10 ? "0" + seconds : seconds;
          display.text(minutes + ":" + seconds);
      }
      render();
      intervalId = setInterval(function () {
          if (timer <= 0) { clearInterval(intervalId); return; }
          timer--; render();
      }, 1000);
  }
  (function ($) {
      let d = new Date();
      let month = d.getMonth() + 1;
      let day = d.getDate();
      let output = (day < 10 ? '0' : '') + day + '/' + (month < 10 ? '0' : '') + month + '/' + d.getFullYear();
      $('.today-date').html(output);
      let time = 6 * 60 + 39;
      let display = $('.countdown');
      startTimer(time, display);
  })(jQuery);
</script>
