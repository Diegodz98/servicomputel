/**
 * @file
 * Global utilities.
 *
 */
(function ($, Drupal) {

  'use strict';

  Drupal.behaviors.bootstrap_barrio_subtheme = {
      attach: function (context, settings) {

      }
  };

  const menu = document.querySelector('.navbar button');
  let estado = menu.getAttribute('aria-expanded');
  menu.addEventListener('click', (e) => {
      console.log(menu.innerHTML)
      estado = menu.getAttribute('aria-expanded')
      if (e.target.nodeName == 'I') {
          menu.click()
      }
      if (estado == "false") {
          menu.innerHTML = '<i class="fas fa-times"></i>'
      } else {
          menu.innerHTML = '<i class="fas fa-bars"></i>'
      }
  })

  $(".nav-link").on("click", () => {
      $('.navbar-collapse').collapse('hide')
  })
 
  const menuAdmin = document.querySelector('#toolbar-bar');
  console.log( document.querySelector('#navbarPrincipal'))
  if (menuAdmin) {
      console.log('hola')
      document.querySelector('#navbarPrincipal').classList.remove('fixed-top');
  }



})(jQuery, Drupal);

window.addEventListener('scroll', function () {

  const menu = document.querySelector('.navbar');
  menu.classList.toggle("navbar-fijo", window.scrollY > 0);
});



