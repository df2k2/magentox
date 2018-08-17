var config = {
  'paths': {
    'mycss': 'Custom_HelloWorld/js/mycss',
    'mycss2': 'Custom_HelloWorld/js/mycss2',
    'mycss3': 'Custom_HelloWorld/js/mycss3',
    'slick': 'Custom_HelloWorld/js/slick.min'
  },
  shim: {
    'slick': {
      deps: ['jquery'],
      exports: 'jQuery.fn.slick', //The value must be a variable defined within the library.
    }
  },
  // When load 'requirejs' always load the following files also
  deps: [
    'Custom_HelloWorld/js/main'
  ],
  config: {
    mixins: {
      'Custom_HelloWorld/js/mycss': {
        'Custom_HelloWorld/js/mycss-mixins': true
      }
    }
  }
};
