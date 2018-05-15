define([
  'uiComponent',  //module-ui\view\base\web\js\lib\core\collection.js
  'jquery',
  'Magento_Customer/js/customer-data',
  'underscore'
  // 'mage/decorate'
], function (Component, $, customerData, _) {
  'use strict';

  return Component.extend({
      data: {},
      initialize: function () {
          this._super();

          if (_.isEmpty(customerData.get('mi-component-data')())) {
            customerData.set('mi-component-data', {
              title: 'This mi-component\'s Title',
              list: [
                {id: 1, text: 'this is id 1'},
                {id: 2, text: 'this is id 2'},
                {id: 3, text: 'this is id 3'},
              ]
            });
          }
          this.data = customerData.get('mi-component-data')();

          return this;
      },
      testLog: function() {
        console.log('testLog')
      }
  });
});
