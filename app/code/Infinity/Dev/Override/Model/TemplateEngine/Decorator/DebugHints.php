<?php
namespace Infinity\Dev\Override\Model\TemplateEngine\Decorator;

class DebugHints extends \Magento\Developer\Model\TemplateEngine\Decorator\DebugHints
{
    /**
     * Insert template debugging hints into the rendered block contents
     *
     * @param string $blockHtml
     * @param string $templateFile
     * @return string
     */
    protected function _renderTemplateHints($blockHtml, $templateFile)
    {
        return <<<HTML
<!-- template: {$templateFile} -->
{$blockHtml}
HTML;
    }

    /**
     * Insert block debugging hints into the rendered block contents
     *
     * @param string $blockHtml
     * @param \Magento\Framework\View\Element\BlockInterface $block
     * @return string
     */
    protected function _renderBlockHints($blockHtml, \Magento\Framework\View\Element\BlockInterface $block)
    {
        $blockClass = get_class($block);
        return <<<HTML
<!-- block:  {$blockClass} -->
{$blockHtml}
HTML;
    }
}
