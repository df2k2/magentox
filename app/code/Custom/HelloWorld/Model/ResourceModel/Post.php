<?php
/**
 * . The resource model will execute sql queries.
 */
namespace Custom\HelloWorld\Model\ResourceModel;


class Post extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
	
	public function __construct(
		\Magento\Framework\Model\ResourceModel\Db\Context $context
	)
	{
		parent::__construct($context);
	}
	
	protected function _construct()
	{
		$this->_init('custom_helloworld_post', 'post_id');
	}
	
}