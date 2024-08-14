<?php $__env->startSection('content'); ?>
<div class="floating-button">
  <a href="<?php echo e(home_url('/contact')); ?>" class="blackToPurple homestart">
    <p class="button-text">Start Here</p>
    <div class="circlegrow"></div>
    <p class="second-text"> 
      <svg xmlns="http://www.w3.org/2000/svg" width="40" height="18" viewBox="0 0 40 18" fill="none">
        <path d="M1.25118 8.8877H37.6844M31.2592 1.74243C33.0916 4.43963 35.4933 6.7346 38.3081 8.47766L38.7489 8.75069L38.2933 9.01401C35.2921 10.7485 32.8554 13.2578 31.2592 16.2577" stroke="white" stroke-width="2" stroke-linecap="square" stroke-linejoin="round"/>
      </svg> 
      Talk with Us
    </p>
  </a>
</div>

  <?php echo $__env->make('pages.home.home-hero', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
  <?php echo $__env->make('pages.home.home-weare', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
  <?php echo $__env->make('pages.home.home-whychoose', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
  <?php echo $__env->make('pages.home.home-testimonials', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
  <?php echo $__env->make('pages.home.home-rundown', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
  <?php echo $__env->make('pages.home.home-map', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
  <?php echo $__env->make('pages.home.home-faq', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>