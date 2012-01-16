Widgets
=======
Version 0.0.1 Created by Cristian Bagemihl

Introduction
------------

Widgets is a very simple MVC controller dispatcher for ZF2.

Requirements
------------

* [Zend Framework 2](https://github.com/zendframework/zf2) (latest master)

Features / Goals
----------------

* Prepare Widgets to dispatch in View or Layout

Common Use-Cases
----------------

### Add Widgets from YourModule/Module.php

    public function init(Manager $moduleManager)
    {
       	...
        $events->attach('bootstrap', 'bootstrap', array($this, 'initializeWidgets'));
		...
    }

	public function initializeWidgets($e)
    {
        $app          = $e->getParam('application');
        $locator      = $app->getLocator();
        $widgets = $locator->get('widgets_service');
        $widgets
	        ->addWidget(
					// widget id
	    		'unique_widget_name', 
					// controller DI instance
				'controller_di_instance', 
			        // route params
	    		array(	
	    			'controller' => 'user',
	    			'action' => 'userbox'
	    		), 
					// widget groups
	    		array('col1') 
	    	);
	}

### Add Widget in YourController.php

    $this->widgets()->getInstance()->addWidget( ... );

### Dispatching Widget group from view or layout

	$widgets = $this->widgets()->dispatchWidgets('col1');
	foreach($widgets as $name=>$widget) :
		echo $widget;
	endforeach;

### Dispatching single Widget

	echo $this->widgets()->dispatchWidget('widget_name');

