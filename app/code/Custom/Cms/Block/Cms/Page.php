<?php
namespace Custom\Cms\Block\Cms;
 
class Page extends \Magento\Framework\View\Element\Template
{
    /**
     * @var \Magento\Cms\Model\Page
     */
    protected $_page;
    /**
     * Page factory
     *
     * @var \Magento\Cms\Model\PageFactory
     */
    protected $_pageFactory;
 
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\Cms\Model\PageFactory $pageFactory,
        \Magento\Cms\Model\Page $page,
        array $data = [])
    {
        parent::__construct($context, $data);
        $this->_page = $page;
        $this->_pageFactory = $pageFactory;
    }
 
    /**
     * Retrieve Page instance
     *
     * @return \Magento\Cms\Model\Page
     */
    public function getPage()
    {
        if (!$this->hasData('page')) {
            if ($this->getPageId()) {
                /** @var \Magento\Cms\Model\Page $page */
                $page = $this->_pageFactory->create();
                $page->setStoreId($this->_storeManager->getStore()->getId())->load($this->getPageId(), 'page_id');
            } else {
                $page = $this->_page;
            }
            $this->setData('page', $page);
        }
        return $this->getData('page');
    }
 
    public function getPageId(){
        return $this->_request->getParam('page_id');
    }
}