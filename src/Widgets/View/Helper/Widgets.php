<?php

namespace Widgets\View\Helper;

use Zend\View\Helper\AbstractHelper;
use Widgets\Service\Widgets as WidgetsService;

class Widgets extends AbstractHelper
{

    /**
     * @var loaded Widgets
     */
    protected $service;
    
    
    /**
     * __invoke 
     * 
     * @access public
     * @return $this
     */
    public function __invoke()
    {
    	return $this->service;
    }

	/**
     * Get view.
     *
     * @return var
     */
    public function getService()
    {
        return $this->service;
    }
 
    /**
     * Set Service.
     *
     * @param WidgetsService $widgetsService
     */
    public function setService(WidgetsService $service)
    {
        $this->service = $service;
        return $this;
    }
}