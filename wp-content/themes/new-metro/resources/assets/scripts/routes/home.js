export default {
  init() {
    // JavaScript to be fired on the home page
    document.addEventListener('scroll', function() {
      var homestart = document.querySelector('.homestart');
      var scrollPosition = window.scrollY || document.documentElement.scrollTop;
  
      if (scrollPosition >= window.innerHeight * 0.75) { // 50vh
          homestart.style.display = 'flex';
      } else {
          homestart.style.display = 'none';
      }
  });
  },
  finalize() {
    // JavaScript to be fired on the home page, after the init JS
  },
};
