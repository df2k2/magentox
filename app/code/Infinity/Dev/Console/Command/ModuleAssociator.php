<?php

namespace Infinity\Dev\Console\Command;

use Magento\Framework\Component\ComponentRegistrar;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Module Associator
 * 
 * Help developer to build module
 *
 * @author Bruce
 */
class ModuleAssociator extends Command {

    const INPUT_KEY_MODULE = 'module';
    const INPUT_KEY_ACTION = 'action';
    const INPUT_KEY_MODEL = 'model';
    const INPUT_KEY_ACTION_PATH = 'action_path';

    private $_componentRegistrar;
    private $_module;

    public function __construct( ComponentRegistrar $componentRegistrar, $name = null )
    {
        parent::__construct( $name );

        $this->_componentRegistrar = $componentRegistrar;
    }

    protected function configure()
    {
        $this->setName( 'dev:module-associator' );
        $this->setDescription( 'Help developer to build module' );

        $this->setDefinition( [
            new InputArgument( self::INPUT_KEY_MODULE, InputArgument::REQUIRED, 'Module name. e.g. Infinity_EPortal' ),
            new InputArgument( self::INPUT_KEY_ACTION, InputArgument::REQUIRED, 'Allowed actions: create, create-grid' ),
            new InputArgument( self::INPUT_KEY_MODEL, InputArgument::OPTIONAL, 'Model. e.g. Record/Element' ),
            new InputArgument( self::INPUT_KEY_ACTION_PATH, InputArgument::OPTIONAL, 'Used for creating grid. e.g. Record/Pending' )
        ] );
    }

    private function _getModuleRoot()
    {
        return $this->_componentRegistrar->getPath( ComponentRegistrar::MODULE, $this->_module );
    }

    private function _createModule()
    {
        return sprintf( '<info>%s</info>', 'Module is created.' );
    }

    private function _createGrid( $actionDirPath, $model )
    {
        $namespace = substr( $this->_module, 0, strpos( $this->_module, '_' ) );
        $module = substr( $this->_module, strpos( $this->_module, '_' ) + 1 );
        $moduleAlias = strtolower( $module );
        $modelAlias = strtolower( str_replace( '/', '_', $model ) );
        $actionPath = strtolower( str_replace( '/', '_', $actionDirPath ) );
        $year = date( 'Y' );

        $files = [ [
                'tpl' => 'Index',
                'file' => "Controller/Adminhtml/{$actionDirPath}/Index.php",
                'params' => [ [ '{{Namespace}}', '{{Module}}', '{{year}}', '{{ActionDirPath}}', '{{Model}}' ],
                        [ $namespace, $module, $year, str_replace( '/', '\\', $actionDirPath ), $model ] ]
            ], [
                'tpl' => 'Grid',
                'file' => "Ui/DataProvider/{$model}/Grid.php",
                'params' => [ [ '{{Namespace}}', '{{Module}}', '{{year}}', '{{Model}}' ],
                        [ $namespace, $module, $year, str_replace( '/', '\\', $model ) ] ]
            ], [
                'tpl' => 'layout',
                'file' => "view/adminhtml/layout/{$module}_{$actionPath}_index.xml",
                'params' => [ [ '{{Namespace}}', '{{Module}}', '{{year}}', '{{module}}', '{{action_path}}' ],
                        [ $namespace, $module, $year, $moduleAlias, $actionPath ] ]
            ], [
                'tpl' => 'ui',
                'file' => "view/adminhtml/ui_component/{$moduleAlias}_{$actionPath}_listing.xml",
                'params' => [ [ '{{Namespace}}', '{{Module}}', '{{year}}', '{{module}}', '{{action_path}}', '{{Model}}', '{{model}}' ],
                        [ $namespace, $module, $year, $moduleAlias, $actionPath, str_replace( '/', '\\', $model ), $modelAlias ] ]
            ]
        ];

        $moduleRoot = $this->_getModuleRoot();
        $tplDir = BP . '/app/code/Infinity/Dev/Console/Command/ModuleAssociator/CreateGrid/';
        foreach ( $files as $file ) {
            $filename = $moduleRoot . '/' . $file['file'];
            if ( is_file( $filename ) ) {
                return sprintf( '<error>%s</eror>', 'Grid existed.' );
            }
            $dir = dirname( $filename );
            if ( !is_dir( $dir ) ) {
                //mkdir( $dir, 0755, true );
            }
            $content = str_replace( $file['params'][0], $file['params'][1], file_get_contents( $tplDir . $file['tpl'] ) );
            //file_put_contents( $filename, $content );
            echo $content;
        }

        return sprintf( '<info>%s</info>', 'Grid is created.' );
    }

    protected function execute( InputInterface $input, OutputInterface $output )
    {
        $this->_module = $input->getArgument( self::INPUT_KEY_MODULE );
        $action = $input->getArgument( self::INPUT_KEY_ACTION );

        if ( $action != 'create' && !$this->_getModuleRoot() ) {
            return $output->writeln( sprintf( '<error>%s</error>', 'Specified module does not exist.' ) );
        }

        switch ( $action ) {
            case 'create':
                $result = $this->_createModule();
                break;

            case 'create-grid' :
                $actionPath = str_replace( ' ', '/', ucwords( str_replace( '/', ' ', $input->getArgument( self::INPUT_KEY_ACTION_PATH ) ) ) );
                $model = str_replace( ' ', '/', ucwords( str_replace( '/', ' ', $input->getArgument( self::INPUT_KEY_MODEL ) ) ) );
                $result = $this->_createGrid( $actionPath, $model );
                break;
        }

        $output->writeln( $result );
    }

}
