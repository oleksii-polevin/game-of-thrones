if(document.getElementById('firstForm')) {
  const email = document.getElementById('mail');
  const password = document.getElementById('password');
  pinListener('email', email);
  pinListener('password', password);
};

if(document.getElementById('secondForm')) {
  const name = document.getElementById('name');
  const textarea = document.getElementById('textarea');
  const select = document.getElementById('houses');
  pinListener('name', name);
  pinListener('textarea', textarea);
  pinListener('select', select);
};

const isValid =
{
  email: function(elem) {
    const regex = /^\w{2,20}\@\w{1,6}\.\w{2,4}$/;
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
    const MIN_LENGTH = 7;
    return elem.length > MIN_LENGTH;
  }
}

const checker = (name, element) => {
  const valid =  isValid[name](element.value);
  valid ? removeError(element) : showError(element);
};

function pinListener (name, element) {
  element.addEventListener('keyup', function() {
    checker(name, element);
  })
};

const showError = (element) => {
  element.classList.add('error');
};

const removeError = (element) => {
  element.classList.remove('error');
};

//holds number of house in particular order for displaying
const houses =
{
  'Select Your Great House': 'notSelected',
  arryn: 0,
  baratheon: 1,
  greyjoy: 2,
  lannister: 3,
  martell: 4,
  stark: 5,
  tully: 6
};

$(document).ready(function() {
  showCurrentHouse();
});

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

function showCurrentHouse() {
  let currentHouse;
  let houseNumber;
  if(document.getElementById('secondForm')) {
  currentHouse = $('.current').text();
  houseNumber = houses[currentHouse];
} else {
  houseNumber = 'notSelected';
}
  /*dropdown wipes out all except innerHTML
  thus, in order to display correct picture
  its number needed
  */
  if(houseNumber === 'notSelected') { //default
    owl.trigger('play.owl.autoplay');
    return true;
  } else {
    owl.trigger('stop.owl.autoplay');
    owl.trigger('to.owl.carousel', houseNumber);
    return false;
  }
}
