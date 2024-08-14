<footer class="footer-container">
  <div class="footer-top">
    <div class="footer-left">
      <a href="<?php echo e(home_url('/')); ?>">
        <img class="footer-logo" src="<?= App\asset_path('images/logo-footer.svg'); ?>" alt="Logo">
      </a>
      <p>At NewMetro we're committed to providing you with a seamless and stress-free experience.</p>
    </div>
    <div class="footer-center">
      <h1>Contact & Socials</h1>
      <a href="https://maps.google.com/?q=5540+Centerview+Dr+Ste+204+PMB+889962+Raleigh+North+Carolina+27606-8012+US" target="_blank">
        <img class="footer-location" src="<?= App\asset_path('images/location.svg'); ?>" alt="location">
        5540 Centerview Dr Ste 204 PMB 889962 Raleigh, North Carolina 27606-8012 US
      </a>

      <a href="tel:7047418861">
        <img class="footer-phone" src="<?= App\asset_path('images/telephone.svg'); ?>" alt="location">
        (704) 741-8861
      </a>

      <a href="mailto:sean@brellare.com">
        <img class="footer-email" src="<?= App\asset_path('images/mail.svg'); ?>" alt="email icon">
        sean@brellare.com
      </a>
    </div>
    <div class="footer-right">
      <a href="<?php echo e(home_url('/privacy-policy')); ?>">
        <h1>Privacy Policy</h1>
      </a>
      <img src="<?= App\asset_path('images/certification-footer.svg'); ?>" alt="Logo">
    </div>
  </div>
  <div class="footer-bottom">
    <p class="copyright">Copyright © <?php echo e(date('Y')); ?> NewMetro. All rights reserved.</p>
  </div>
</footer>
