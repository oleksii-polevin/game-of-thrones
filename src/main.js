const email = document.getElementById('mail');
const password = document.getElementById('password');
const signUp = document.getElementById('signUp');
const name = document.getElementById('name');
const textarea = document.getElementById('textarea');
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
  select: function() {
    const x =$('.current').text();
    return x.indexOf('Select') === -1;
  },
  textarea: function(elem) {
    const minlength = 9;
    return elem.length > minlength ? true : false;
  }
}

form.addEventListener('submit', function(event) {
  event.preventDefault();
  if(validationRules.name(name.value) &&
  validationRules.select() &&
  validationRules.textarea(textarea.value)) {
    alert('info is correct');
  }
  if(!validationRules.name(name.value)) {
    showError(name);
  }
  if(!validationRules.textarea(textarea.value)) {
    showError(textarea);
  }
  if(!validationRules.select()) {
    $('.current').addClass('error');
  }
});

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

pinListener('name', name);
pinListener('textarea', textarea);

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
  const currentHouse = $('.current').text();
  // console.log(currentHouse);
  let number;
  //dropdown wipe out everything except innerHTML,
  //thus number of house (which is necesssary to display correct house)
  //can be obtained from following loop
  for(let key in houses) {
     if(key === currentHouse){
       number = houses[key];
     }
  }
  if(number === 7) { //default
    owl.trigger('play.owl.autoplay', [2000]);
    $('.current').addClass('error');
  }
  else {
    owl.trigger('stop.owl.autoplay');
    owl.trigger('to.owl.carousel', number);
    $('.current').removeClass('error');
  }
});
