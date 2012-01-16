<?php

namespace Widgets\Service;

use Zend\Di\Locator,
	Zend\Mvc\Router\RouteStack as Router,
    Zend\Mvc\InjectApplicationEvent,
    Zend\Mvc\Exception,
    Zend\Mvc\LocatorAware,
    Zend\Mvc\MvcEvent,
    Zend\Mvc\Router\RouteMatch,
    Zend\Stdlib\Dispatchable;
class Widgets
{
    /**
     * @var Widgets
     */
    protected $widgets = array();
    
    /**
     * @var Groups
     */
    protected $groups = array();
    
    /**
     * @var Groups
     */
    protected $dispatched = array();
    
    /**
     * @var Locator
     */
    protected $locator = array();
    
    /**
     * @var router
     */
    protected $router = array();
    
    
    /**
     * Enter description here ...
     * @param unknown_type $name
     * @param unknown_type $controller_instance
     * @param unknown_type $route_params
     * @param unknown_type $groups
     * @return \Widgets\Service\Widgets
     */
    public function addWidget($name, $controller_instance, $route_params, $groups = array()) {
    	
    	$this->widgets[$name] = compact('controller_instance', 'route_params');;
    	$this->widgets[$name]['id'] = $route_params['controller'].'#'.$route_params['action'];
    	if( is_array($groups)) {
	    	foreach($groups as $group) {
	    		$this->groups[$group][] = $name;
	    	}
    	}
    	
    	return $this;
    }

    /**
     * Enter description here ...
     * @param unknown_type $group
     * @return multitype:
     */
    public function getGroup($group = '') {
    	    	
    	if( isset($this->groups[$group]))
    		return $this->groups[$group];
    	else 
    		return array();
    	
    }
    
    /**
     * Enter description here ...
     * @param unknown_type $name
     */
    public function getWidget($name) {
    	return $this->widgets[$name];
    }
    
    /**
     * Enter description here ...
     * @param unknown_type $name
     * @throws Exception\DomainException
     */
    public function dispatchWidget($name) {
    	$widget = $this->widgets[$name];
    	
    	
    	if( ! isset($this->dispatched[$widget['id']]) ) {
    		
    		$controller = $this->getLocator()->get($widget['controller_instance']);
    		
    		$event = new MvcEvent();
    		
        	$routeMatch = new RouteMatch($widget['route_params']);
        	
        	$request = new \Zend\Stdlib\Request;
        	$router = $this->getRouter();
        	
    		$event
	        	->setRequest($request)
	        	->setRouter($router)
	        	->setRouteMatch($routeMatch)
        	;
        
	        if (!$controller instanceof Dispatchable) {
	            throw new Exception\DomainException('Can only forward to Dispatchable classes; class of type ' . get_class($controller) . ' received');
	        }
	        if ($controller instanceof InjectApplicationEvent) {
	            $controller->setEvent($event);
	        }
	        if ($controller instanceof LocatorAware) {
	            $controller->setLocator($this->getLocator());
	        }
			$controller->dispatch( $request);
			$this->dispatched[$widget_id] = $controller->getEvent()->getParam('content');
			
    	}
    		
		return $this->dispatched[$widget_id];
    }
    
    
    /**
     * Dispatch widgets by group name or by widget names array
     * 
     * @param  string|array $widgets 
     * @return dispatched widgets
     */
    public function dispatchWidgets($widgets) {
    	
    	$return = array();
    	if( ! is_array($widgets))
    		$widgets = $this->getGroup($widgets);
    	
    	
    	foreach($widgets as $name) {
    		
    		$return[$name] = $this->dispatchWidget($name);	
    	}
    	
    	return $return;
    }
    
	/**
     * Set locator instance
     * 
     * @param  Locator $locator 
     * @return void
     */
    public function setLocator(Locator $locator)
    {
        $this->locator = $locator;
    }

    /**
     * Retrieve locator instance
     * 
     * @return Locator
     */
    public function getLocator()
    {
        return $this->locator;
    }
    
	/**	
     * Set router instance
     * 
     * @param  Router $router 
     * @return void
     */
    public function setRouter(Router $router)
    {
        $this->router = $router;
    }

    /**
     * Retrieve router instance
     * 
     * @return Router
     */
    public function getRouter()
    {
        return $this->router;
    }
}
