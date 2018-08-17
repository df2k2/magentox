<?php

namespace Custom\HelloWorld\Plugin;

class ExPlugin{
    public function beforeSetTitle(\Custom\HelloWorld\Controller\Index\Plugin $subject, $title)//title时参数值
	{
		$title = $title . " to ";
		echo __METHOD__ . "</br>";

        //return改变参数值
		return [$title];
    }

    public function afterGetTitle(\Custom\HelloWorld\Controller\Index\Plugin $subject, $result)//result: return值
	{

		echo __METHOD__ . "</br>";

        //return改变return值
		return '<h1>'. $result . 'Mageplaza.com' .'</h1>';

    }

    public function aroundGetTitle(\Custom\HelloWorld\Controller\Index\Plugin $subject, callable $proceed, ...$args)
	{

        echo __METHOD__ . " - Before proceed() </br>";
		$result = $proceed(...$args);//$proceed()必要, 执行原来的方法
		echo __METHOD__ . " - After proceed() </br>";

		return $result;
	}

}