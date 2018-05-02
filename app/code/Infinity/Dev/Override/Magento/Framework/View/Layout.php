<?php

namespace Infinity\Dev\Override\Magento\Framework\View;

class Layout extends \Magento\Framework\View\Layout
{
    public function renderNonCachedElement($name)
    {
        $result = parent::renderNonCachedElement($name);
        if(isset($_GET['debug'])) {
            if ($this->isUiComponent($name)) {
                return '<!-- UiComponent('.$name.') -->'.$result.'<!-- /UiComponent('.$name.') -->';
            } elseif ($this->isBlock($name)) {
                return '<!-- block('.$name.') -->'.$result.'<!-- /block('.$name.') -->';
            }
            return '<!-- container('.$name.') -->'.$result.'<!-- /container('.$name.') -->';
        }
        return $result;
    }
}