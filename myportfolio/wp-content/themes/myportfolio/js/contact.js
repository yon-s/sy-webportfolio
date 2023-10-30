
document.addEventListener("DOMContentLoaded", function(){
  //CONTACT
  const targetButton = document.getElementById('submit');
  const triggerCheckbox = document.querySelector('input[name="agree_privacy"]');
  targetButton.disabled = true;
  targetButton.classList.add('is-inactive');
  triggerCheckbox.addEventListener('change', function() {
    if (this.checked) {
      targetButton.disabled = false;
      targetButton.classList.remove('is-inactive');
    } else {
      targetButton.disabled = true;
      targetButton.classList.add('is-inactive');
    }
  }, false);
}, false);