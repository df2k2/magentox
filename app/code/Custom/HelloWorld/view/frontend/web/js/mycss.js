define(['jquery'], function ($) {
  'use strict';
  return {
    'mycss': function(config, element) {
      $(element).css(config);
    }
  }
})