<?php
namespace Infinity\Dev\Override\Model\TemplateEngine\Decorator;

class DebugHints extends \Magento\Developer\Model\TemplateEngine\Decorator\DebugHints
{
    /**
     * @var \Magento\Framework\View\TemplateEngineInterface
     */
    private $_subject;

    private $_count;

    public function __construct(\Magento\Framework\View\TemplateEngineInterface $subject, $showBlockHints)
    {
        $this->_count = 0;
        $this->_subject = $subject;
        $this->_showBlockHints = $showBlockHints;
    }
    /**
     * Insert template debugging hints into the rendered block contents
     *
     * @param string $blockHtml
     * @param string $templateFile
     * @return string
     */
    protected function _renderTemplateHints($blockHtml, $templateFile)
    {
        $root_dir = getcwd();
        $templateFile = str_replace($root_dir, '', $templateFile);
        return $templateFile;
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
        return $blockClass;
    }

    public function render(\Magento\Framework\View\Element\BlockInterface $block, $templateFile, array $dictionary = [])
    {
        ++$this->_count;
        $id = $this->_count;
        $result = $this->_subject->render($block, $templateFile, $dictionary);
        $blockHint = '';
        if ($this->_showBlockHints) {
            $blockHint = $this->_renderBlockHints($result, $block);
        }
        $tmpHint = '';
        $tmpHint = $this->_renderTemplateHints($result, $templateFile);
        $randId = rand(1000, 9999);
        return <<<HTML
<!-- ${id}: ${blockHint} 【${tmpHint}】-->
{$result}
<!--/${id} -->
HTML;
    }
}
