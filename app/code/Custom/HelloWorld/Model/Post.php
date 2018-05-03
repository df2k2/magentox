<?php
/**
 * The model file contain overall database logic, do not execute sql queries. 
 *  models have many different functions such as manage data, install or upgrade module
 * 
 */
namespace Custom\HelloWorld\Model;

class Post extends \Magento\Framework\Model\AbstractModel implements \Magento\Framework\DataObject\IdentityInterface
{
	const CACHE_TAG = 'custom_helloworld_post';

	protected $_cacheTag = 'custom_helloworld_post';

    //a prefix for events to be triggered
	protected $_eventPrefix = 'custom_helloworld_post';

	protected function _construct()
	{
		$this->_init('Custom\HelloWorld\Model\ResourceModel\Post');
	}

    // your model required cache refresh after database operation and render information to the frontend page.
	public function getIdentities()
	{
		return [self::CACHE_TAG . '_' . $this->getId()];
	}

	public function getDefaultValues()
	{
		$values = [];

		return $values;
	}
}