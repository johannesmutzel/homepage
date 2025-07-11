const toggle = document.querySelector('.menu-toggle');
const nav = document.querySelector('nav');
const navLinks = document.querySelectorAll('nav ul.nav li a');

toggle.addEventListener('click', () => {
  toggle.classList.toggle('open');
  nav.classList.toggle('open');
});

navLinks.forEach(link => {
  link.addEventListener('click', () => {
    toggle.classList.remove('open'); // Kreuz zurück zu Burger
    nav.classList.remove('open');    // Menü ausblenden
  });
});