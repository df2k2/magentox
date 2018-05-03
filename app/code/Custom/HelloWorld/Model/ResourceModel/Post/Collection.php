<?php
/**
 *  collection model is considered a resource model which allow us to filter and fetch a collection table data
 */
namespace Custom\HelloWorld\Model\ResourceModel\Post;


class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
	protected $_idFieldName = 'post_id';
    protected $_eventPrefix = 'custom_helloworld_post_collection';
    //a object name when access in event 
	protected $_eventObject = 'post_collection';

	/**
	 * Define resource model
	 *
	 * @return void
	 */
	protected function _construct()
	{
		$this->_init('Custom\HelloWorld\Model\Post', 'Custom\HelloWorld\Model\ResourceModel\Post');
	}

}