const email = document.getElementById('mail');
const password = document.getElementById('password');
const forma = document.getElementById('firstForm');
const name = document.getElementById('name');
const select = document.getElementById('select');
const textarea = document.getElementById('textarea');
const forma2 = document.getElementById('save');
const attempts = {
  email: 0,
  password: 0,
  select: 0,
  name: 0,
  textarea: 0
}
//contains all function necessary for validation
const validationRules =
{
  email: function(elem) {
    const regex = /\w{2,16}\@\w{2,6}\.\w{2,4}/;
    return regex.test(elem);
  },
  password:function(elem) {
    //at least one lowercase letter, one uppercase,and one digit; length >=8
    const regex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#\$%\^&\*])(?=.{8,})/;
    return regex.test(elem);
    //for testing
    // return elem.length > 7;
  },
  name: function(elem) {
    return elem.length > 2;
  },
  select: function(elem) {
    const compare = document.getElementsByTagName('option');
    for(i=0; i < compare.length; i++) {
      if(elem === compare[i].innerHTML) {
        return true;
      }
    }
    return false;
  },
  textarea: function(elem) {
    return elem.length > 10 && elem.length < 300;
  }
}

forma.addEventListener('submit', function(e) {
  e.preventDefault();
  if((validationRules.password(password.value)) &&
  (validationRules.email(email.value))) {
    showSecondForm();
  }else {
    if(!validationRules.password(password.value)) {
      attemptSwitcher(password, 'password');
    }
    if(!validationRules.email(email.value)) {
      attemptSwitcher(email, 'email');
    }
  }
});

forma2.addEventListener('click', function(e) {
  e.preventDefault();
  if(validationRules.name(name.value) &&
  validationRules.select(select.value) &&
  validationRules.textarea(textarea.value)) {
    alert('info is correct');
  } else {
    if(!validationRules.name(name.value)) {
      attemptSwitcher(name, 'name');
    }
    if(!validationRules["select"](select.value)) {
      attemptSwitcher(select, 'select');
    }
    if(!validationRules.textarea(textarea.value)) {
      attemptSwitcher(textarea, 'textarea');
    }
  }
})
function attemptSwitcher(element, name) {
  let x;
  for(let key in attempts) {
    if(key.toString() === name) {
      x = key;
    }
  }
  if(attempts[x] === 0) {
    firstValidation(element);
  } else if(attempts[x] === 1) {
    focusValidation(element, name, 'blur');
  } else if(attempts[x] >= 2){
    focusValidation(element, name, 'keyup');
  }
  attempts[x]++;
}

function firstValidation(element) {
  element.style.borderBottom = '3px solid gray';
}

function focusValidation(element, name, eventType) {
  let x;
  for(let key in validationRules) {
    if(key.toString() === name) {
      x = key;
    }
  }
  const norm = '3px solid green';
  const invalid = '3px solid red';
  element.addEventListener(eventType, function () {
    validationRules[x](element.value) ? element.style.borderBottom = norm
    : element.style.borderBottom = invalid;
  })
}

function showSecondForm() {
  let first = document.getElementById('firstForm');
  let second = document.getElementById('secondForm');
  first.style.display = "none";
  second.style.display = 'flex';
}
