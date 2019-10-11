const email = document.getElementById('mail');
const password = document.getElementById('password');
const forma = document.getElementById('firstForm');
const name = document.getElementById('name');
const select = document.getElementById('select');
const textarea = document.getElementById('textarea');
const forma2 = document.getElementById('save');
//firstly wrong fields highlighted when button clicked
//second time when input area become inactive
//finally wrong fields highlighted after each inputted symbol
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
    // const regex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#\$%\^&\*])(?=.{8,})/;
    // return regex.test(elem);
    //for testing
    return elem.length > 7;
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
    const minNumberOfSymbols = 15;
    const maxNumberOfSymbols = 300;
    return elem.length > minNumberOfSymbols && elem.length < maxNumberOfSymbols;
  }
}

forma.addEventListener('submit', function(e) {
  e.preventDefault();
  if((validationRules.password(password.value)) &&
  (validationRules.email(email.value))) {
    showSecondForm();
    toggleMessage('hide');
  } else {
    toggleMessage('show');
    if(!validationRules.password(password.value)) {
      attemptSwitcher(password, 'password');
    }
    if(!validationRules.email(email.value)) {
      attemptSwitcher(email, 'email');
    }
  }
});

function toggleMessage(flag) {
  flag === 'show' ?
  document.getElementById('errorMessage').style.color = 'red':
  document.getElementById('errorMessage').style.color = '#202020';
}

forma2.addEventListener('click', function(e) {
  e.preventDefault();
  if(validationRules.name(name.value) &&
  validationRules.select(select.value) &&
  validationRules.textarea(textarea.value)) {
    alert('info is correct');
    toggleMessage('hide');
  } else {
    toggleMessage('show');
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
  let elemName;
  for(let key in attempts) {
    if(key.toString() === name) {
      elemName = key;
    }
  }
  if(attempts[elemName] === 0) {
    firstValidation(element);
  } else if(attempts[elemName] === 1) {
    focusValidation(element, name, 'focusout');
  } else if(attempts[elemName] >= 2){
    focusValidation(element, name, 'keyup');
  }
  attempts[elemName]++;
}

function firstValidation(element) {
  element.style.borderBottom = '3px solid gray';
}

function focusValidation(element, name, eventType) {
  let elemName;
  for(let key in validationRules) {
    if(key.toString() === name) {
      elemName = key;
    }
  }
  const norm = '3px solid green';
  const invalid = '3px solid red';
  element.addEventListener(eventType, function () {
    validationRules[elemName](element.value) ? element.style.borderBottom = norm
    : element.style.borderBottom = invalid;
  })
}

function showSecondForm() {
  const first = document.getElementById('firstForm');
  const second = document.getElementById('secondForm');
  first.style.display = "none";
  second.style.display = 'flex';
}
