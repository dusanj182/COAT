jQuery(document).ready(function ($) {
  $('h2.wc-shipping-zones-heading').next('p').append('<p>To use <b>table rate shipping</b> make sure that the Shipping Zone listed below has "Table Rate" set as the shipping method. You can edit an existing zone to set the shipping method or create a new zone.</p>');

  $('table.wc-shipping-zone-methods').parent('td').append('<p>To use <b>table rate shipping</b> make sure that the Shipping Method is set to Table Rate.</p>');

  if ($('.pro-box').length) {
    submit = $('.pro-box').next('p.submit');
    $(submit).insertBefore($('.pro-box'));
  }
});
