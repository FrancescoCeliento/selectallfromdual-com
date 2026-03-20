(function() {
  var savedTheme = localStorage.getItem('tom79-theme');
  if (savedTheme) {
    document.documentElement.setAttribute('data-theme', savedTheme);
  }

  function isCurrentlyDark() {
    var dataTheme = document.documentElement.getAttribute('data-theme');
    if (dataTheme) {
      return dataTheme === 'dark';
    }
    return window.matchMedia('(prefers-color-scheme: dark)').matches;
  }

  function toggleTheme() {
    var isDark = isCurrentlyDark();
    var newTheme = isDark ? 'light' : 'dark';
    document.documentElement.setAttribute('data-theme', newTheme);
    localStorage.setItem('tom79-theme', newTheme);
  }

  document.addEventListener('DOMContentLoaded', function() {
    var toggleBtn = document.getElementById('theme-toggle');
    if (toggleBtn) {
      toggleBtn.addEventListener('click', function(e) {
        e.preventDefault();
        e.stopPropagation();
        toggleTheme();
      });
    }
  });
})();
