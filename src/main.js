const email = document.getElementById('mail');
const password = document.getElementById('password');
const signUp = document.getElementById('signUp');
const name = document.getElementById('name');
const textarea = document.getElementById('textarea');
const select = document.getElementById('select');
const form = document.getElementById('form');
const validationRules =
{
  email: function(elem) {
    const regex = /^\w{2,16}\@\w{2,6}\.\w{2,4}$/;
    return regex.test(elem);
  },
  password:function(elem) {
    return elem.length > 7;
  },
  name: function(elem) {
    const regex = /^\w{2,20}$/;
    return regex.test(elem);
  },
  select: function(elem) {
     return elem.length > 0;
  },
  textarea: function(elem) {
    const minlength = 9;
    return elem.length > minlength ? true : false;
  }
}

email.addEventListener('blur', function() {
  checker('email', email)
  pinListener('email', email);
});
password.addEventListener('blur', function() {
  checker('password', password)
  pinListener('password', password);
});

signUp.addEventListener('click', function(e) {
  if(validationRules.email(email.value) &&
  validationRules.password(password.value)) {
    showSecondForm();
  }
  if(!validationRules.email(email.value)) {
    showError(email);
    pinListener('email', email);
  }
  if(!validationRules.password(password.value)) {
    showError(password);
    pinListener('password', password);
  }
});

form.addEventListener('submit', function(event) {
  event.preventDefault();
  if(validationRules.name(name.value) &&
  validationRules.select(select.value) &&
  validationRules.textarea(textarea.value)) {
    alert('info is correct');
  }
  if(!validationRules.name(name.value)) {
    showError(name);
  }
  if(!validationRules.textarea(textarea.value)) {
    showError(textarea);
  }
  if(!validationRules.select(select.value)) {
    showError(select);
  }
});
pinListener('name', name);
pinListener('textarea', textarea);
pinListener('select', select);

function checker(name, element) {
  const valid =  validationRules[name](element.value);
  valid ? removeError(element) : showError(element);
}

function pinListener(name, element) {
  element.addEventListener('keyup', function() {
    checker(name, element);
  })
};

function showError(element) {
  element.classList.add('error');
}
function removeError(element) {
  element.classList.remove('error');
}
function showSecondForm() {
  const first = document.getElementById('firstForm');
  const second = document.getElementById('secondForm');
  first.classList.add('invisible');
  second.classList.remove('invisible');
}
