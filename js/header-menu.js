const btn = document.querySelector('.menu-toggle');
const menu = document.querySelector('nav .nav');

btn.addEventListener('click', () => {
  menu.classList.toggle('show');
});

// Schließt das Menü nach Klick auf einen Link (mobil)
document.querySelectorAll('nav .nav a').forEach(link => {
  link.addEventListener('click', () => {
    if (window.innerWidth <= 768) {
      menu.classList.remove('show');
    }
  });
});