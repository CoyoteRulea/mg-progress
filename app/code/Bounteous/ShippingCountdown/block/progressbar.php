<?php
namespace Bounteous\ShippingCountdown;

use Magento\Customer\Block\Widget\AbstractWidget;

class Progressbar extends AbstractWidget
{


    /**
     * Initialize block
     *
     * @return void
     */
    public function _construct()
    {
        echo "Marcho polo";
        
        parent::_construct();
        $this->setTemplate('progresssbar.phtml');
    }

}