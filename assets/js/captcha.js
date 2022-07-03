
var refreshCaptcha = document.querySelector(".img-refresh");
refreshCaptcha.onclick = function() {
  document.querySelector(".captcha-image").src = 'captcha.php?' + Math.random();
}