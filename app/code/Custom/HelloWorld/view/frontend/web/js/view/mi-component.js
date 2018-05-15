define([
  'uiComponent',
  'jquery',
  'Magento_Customer/js/customer-data',
  'underscore'
  // 'mage/decorate'
], function (Component, $, customerData, _) {
  'use strict';

  return Component.extend({
      initialize: function () {
          this._super();
          if (_.isEmpty(customerData.get('mi-component-data')())) {
            customerData.set('mi-component-data', {title: 'This mi-component\'s Title'});
          }
          
          this.miComponent = customerData.get('mi-component-data')();
      }
  });
});
