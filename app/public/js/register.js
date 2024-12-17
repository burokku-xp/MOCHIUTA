/*パスワードの表示-------------------------------------------------*/
document.addEventListener('DOMContentLoaded', function(event) {

  const targetElement = document.getElementById('password');
  const targetElementConfirm = document.getElementById('password-confirm');
  const triggerElement = document.getElementById('showPassword');

  triggerElement.addEventListener('change', function(event) {
    if ( this.checked ) {
      targetElement.setAttribute('type', 'text');
      targetElementConfirm.setAttribute('type', 'text');
    } else {
      targetElement.setAttribute('type', 'password');
      targetElementConfirm.setAttribute('type', 'password');
    }
  }, false);

}, false);