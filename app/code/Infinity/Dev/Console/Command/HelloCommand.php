<?php
namespace Infinity\Dev\Console\Command;

use Magento\Framework\App\State as AppState;
use Magento\Framework\Exception\NoSuchEntityException;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class HelloCommand extends Command
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
        $this->setName('infinity:hello');
        $this->setDescription('hello world');
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln("<info>Hello World</info>");
        return \Magento\Framework\Console\Cli::RETURN_SUCCESS;
    }
}
