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
    return elem.length > 2 && elem.length < 20;//symbols
  },
  select: function() {
    return $('.current').html() === 'Select your Great House' ?
    false : true;
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
    } else normalise(password);
    if(!validationRules.email(email.value)) {
      attemptSwitcher(email, 'email');
    } else normalise(email);
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
  validationRules.select() &&
  validationRules.textarea(textarea.value)) {
    alert('info is correct');
    toggleMessage('hide');
  } else {
    toggleMessage('show');
    if(!validationRules.name(name.value)) {
      attemptSwitcher(name, 'name');
    } else normalise(name);
    if(!validationRules.textarea(textarea.value)) {
      attemptSwitcher(textarea, 'textarea');
    }else normalise(textarea);
    selectSwitcher();
  }
})
//highliting dropdown
function selectSwitcher() {
    if(attempts.select === 0) {
      attempts.select++;
      validationRules.select() ? $('.houses').css("border", "1px solid #c0994f") :
      $('.houses').css("border", "1px solid gray");
    }
    if(attempts.select > 0) {
      $('.houses').change(function() {
        validationRules.select() ? $('.houses').css("border", "1px solid green") :
        $('.houses').css("border", "1px solid red");
      })
    }
}
//element - innerHTML of particular field
//name - its string name
function attemptSwitcher(element, name) {
  let elemName; // for finding correct key of attempts object
  for(let key in attempts) {
    if(key.toString() === name) {
      elemName = key;
    }
  }
  if(attempts[elemName] === 0) {
    firstValidation(element);
  } else if(attempts[elemName] === 1) {
    focusValidation(element, name, 'focusout');
  } else {
    focusValidation(element, name, 'keyup');
  }
  attempts[elemName]++;
}

function firstValidation(element) {
  element.style.borderBottom = '3px solid gray';
}
function normalise(element) {
  element.style.borderBottom = '3px solid green';
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
//holds number of house in particular order for displaying
//by carousel slider
const houses =
{
  "Select your Great House": 7,
  arryn: 0,
  baratheon:1,
  greyjoy: 2,
  lannister: 3,
  martell: 4,
  stark: 5,
  tully: 6
}
//slider
const owl = $('.owl-carousel');
owl.owlCarousel({
    items:1,
    loop:true,
    margin:10,
    autoplay:true,
    dots: false,
    autoplayTimeout:2000,
    autoplayHoverPause:true
});
$(document).ready(function() {
  $('#houses').niceSelect();
})

$('#houses').on('change',function() {
  const currentHouse = $('.current').html();
  let number;
  //dropdown wipe out everything except innerHTML,
  //thus number of house (which is necesssary to display correct house)
  //can be obtained from following loop
  for(let key in houses) {
     if(key === currentHouse){
       number = houses[key];
     }
  }
  if(number === 7) {
    owl.trigger('play.owl.autoplay', [2000])
  }
  else {
    owl.trigger('stop.owl.autoplay');
    owl.trigger('to.owl.carousel', number)
  }
});
