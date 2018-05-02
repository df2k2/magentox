<?php
namespace Infinity\Dev\Console\Command;

use Magento\Framework\App\State as AppState;
use Magento\Framework\Exception\NoSuchEntityException;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Magento\Framework\App\Filesystem\DirectoryList;

class ImageFixCommand extends Command
{
    /**
     * @var AppState
     */
    protected $appState;

    /**
     * @param AppState $appState
     */
    public function __construct(
        AppState $appState
    ) {
        $this->appState = $appState;;
        parent::__construct();
    }

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this->setName('infinity:imagefix');
        $this->setDescription('miss image fix');
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->appState->setAreaCode('customer');
        $output->writeln("<info>Running...</info>");
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $filesystem = $objectManager->get( 'Magento\Framework\Filesystem' );
        $dir = $filesystem->getDirectoryRead( DirectoryList::MEDIA );
        $mainImage = $dir->getAbsolutePath('/catalog/product/main.jpg');
        if(!file_exists($mainImage)) {
            $output->writeln("Main image not found");
            return \Magento\Framework\Console\Cli::RETURN_FAILURE;
        }
        /* @var \Magento\Catalog\Model\Product $model */
        /* @var \Magento\Catalog\Model\Product $product */
        $model = $objectManager->get('Magento\Catalog\Model\Product');
        foreach($model->getCollection() as $_product) {
            $product = $objectManager->create('Magento\Catalog\Model\Product');
            $product->load($_product->getId());
            if($product->hasData('media_gallery')) {
                $gallery = $product->getData('media_gallery');
                foreach($gallery['images'] as $item) {
                    $filePath = $dir->getAbsolutePath('/catalog/product'.$item['file']);
                    if(!file_exists($filePath)) {
                        $output->writeln($filePath);
                        if(!file_exists(dirname($filePath)))
                            mkdir(dirname($filePath), 0777, true);
                        copy($mainImage, $filePath);
                    }
                }
            }
        }

        return \Magento\Framework\Console\Cli::RETURN_SUCCESS;
    }
}
