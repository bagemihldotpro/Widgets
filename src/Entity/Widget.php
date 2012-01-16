<?php

namespace Widgets\Entity;

use Zend\Di\Locator,
	Zend\Mvc\Router\RouteStack as Router,
	Zend\Mvc\MvcEvent;

class Widget
{
	protected $name;
	
	protected $route_params;
	
	protected $html;
	
	protected $is_dispatched = false;
	
	
}