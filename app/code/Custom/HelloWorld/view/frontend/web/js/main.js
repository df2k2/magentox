// 测试translate
require(['jquery', 'mage/translate'], function ($, __) {
  // 如果执行比它快: module-translation\view\base\templates\translate.phtml
  // 则需要延迟执行, 因为translate还没加进storage
  // 另外 mage/translate 只有在js文件才才有用, 因为js文件才会被搜索进待翻译文字中, 然后在js-translation.json生成翻译;
    setTimeout(() => {
        $('#tr-js').text('script-translate: ' + $.mage.__('TS_TEST'));
    }, 1000);
});
