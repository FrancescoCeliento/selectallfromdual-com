(function() {
  var saved = localStorage.getItem('tom79-theme');
  if (saved) {
    document.documentElement.setAttribute('data-theme', saved);
  }
})();
