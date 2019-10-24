const email = document.getElementById('mail');
const password = document.getElementById('password');
const signUp = document.getElementById('signUp');
const name = document.getElementById('name');
const textarea = document.getElementById('textarea');
const form = document.getElementById('form');
const select = document.getElementById('houses');
const isValid =
{
  email: function(elem) {
    const regex = /^\w{2,16}\@\w{2,6}\.\w{2,4}$/;
    return regex.test(elem);
  },
  password:function(elem) {
    const MIN_LENGTH = 7;
    return elem.length > MIN_LENGTH;
  },
  name: function(elem) {
    const regex = /^\w{2,20}$/;
    return regex.test(elem);
  },
  select: function() {
    const x = $('.current').text();
    return x.indexOf('Select') === -1;
  },
  textarea: function(elem) {
    const MIN_LENGTH = 3;
    return elem.length > MIN_LENGTH;
  }
}

form.addEventListener('submit', function(event) {
  event.preventDefault();
  if (isValid.name(name.value)
  &&  isValid.select()
  &&  isValid.textarea(textarea.value)) {
    alert('info is correct');
  }
  if (!isValid.name(name.value)) {
    showError(name);
  }
  if (!isValid.textarea(textarea.value)) {
    showError(textarea);
  }
  if (!isValid.select()) {
    $('.nice-select').addClass('error');
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
  if (isValid.email(email.value)
  &&  isValid.password(password.value)) {
    showSecondForm();
  }
  if (!isValid.email(email.value)) {
    showError(email);
    pinListener('email', email);
  }
  if (!isValid.password(password.value)) {
    showError(password);
    pinListener('password', password);
  }
});

pinListener('name', name);
pinListener('textarea', textarea);

checker = (name, element) => {
  const valid =  isValid[name](element.value);
  valid ? removeError(element) : showError(element);
}

function pinListener (name, element) {
  element.addEventListener('keyup', function() {
    checker(name, element);
  })
};

const showError = (element) => {
  element.classList.add('error');
}

const removeError = (element) => {
  element.classList.remove('error');
}

showSecondForm = () => {
  const first = document.getElementById('firstForm');
  const second = document.getElementById('secondForm');
  first.classList.add('invisible');
  second.classList.remove('invisible');
}

//holds number of house in particular order for displaying
const houses =
{
  'Select your Great House': 'notSelected',
  arryn: 0,
  baratheon: 1,
  greyjoy: 2,
  lannister: 3,
  martell: 4,
  stark: 5,
  tully: 6
}

//slider
const owl = $('.owl-carousel');

owl.owlCarousel({
  items: 1,
  loop: true,
  margin: 10,
  autoplay: true,
  center: true,
  dots: false,
  autoplayTimeout: 2000,
  autoplayHoverPause: true,
});

owl.on('resized.owl.carousel', function() {
  showCurrentHouse();
});

//dropdown
$('#houses').niceSelect();

$('#houses').on('change', function() {
  showCurrentHouse()
  ? $('.nice-select').addClass('error')
  : $('.nice-select').removeClass('error');
});

showCurrentHouse = () => {
  const currentHouse = $('.current').text();
  /*dropdown wipes out all except innerHTML
  thus, in order to display correct picture
  its number needed
  */
  const houseNumber = houses[currentHouse];
  if(houseNumber === 'notSelected') { //default
    owl.trigger('play.owl.autoplay');
    return true;
  } else {
    owl.trigger('stop.owl.autoplay');
    owl.trigger('to.owl.carousel', houseNumber);
    return false;
  }
}
