<?php
return array(
    'di' => array(
        'instance' => array(
            'alias' => array(
                'widgets_service'                  => 'Widgets\Service\Widgets',
                'widgets_controller_plugin_broker' => 'Zend\Mvc\Controller\PluginBroker',
                'widgets_controller_plugin_loader' => 'Zend\Mvc\Controller\PluginLoader',
            ),
            
            'Zend\Mvc\Controller\ActionController' => array(
                'parameters' => array(
                    'broker'       => 'widgets_controller_plugin_broker',
                ),
            ),
            
            'widgets_controller_plugin_broker' => array(
                'parameters' => array(
                    'loader' => 'widgets_controller_plugin_loader',
                ),
            ),
            'widgets_controller_plugin_loader' => array(
                'parameters' => array(
                    'map' => array(
                        'widgets' => 'Widgets\Controller\Plugin\Widgets',
                    ),
                ),
            ),
            
            'Widgets\Controller\Plugin\Widgets' => array(
            	'parameters' => array(
                    'service' => 'widgets_service',
                ),
            ),
                        
            /**
             * View helper(s)
             */

            'Zend\View\PhpRenderer' => array(
                'parameters' => array(
                    'broker' => 'Zend\View\HelperBroker',
                ),
            ),
            'Zend\View\HelperLoader' => array(
                'parameters' => array(
                    'map' => array(
                        'widgets' => 'Widgets\View\Helper\Widgets',
                    ),
                ),
            ),
            'Zend\View\HelperBroker' => array(
                'parameters' => array(
                    'loader' => 'Zend\View\HelperLoader',
                ),
            ),
            'Widgets\View\Helper\Widgets' => array(
                'parameters' => array(
            		'service' => 'widgets_service'
                ),
            ),
        ),
    ),
);
