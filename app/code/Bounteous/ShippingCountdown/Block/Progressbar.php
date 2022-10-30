<?php
namespace Bounteous\ShippingCountdown\Block;

use Magento\Framework\Stdlib\DateTime\DateTime;
use Magento\Framework\Stdlib\DateTime\TimezoneInterface;
use Magento\Customer\Model\Session\Mage;

class Progressbar extends \Magento\Framework\View\Element\Template
{
/**
 * @var TimezoneInterface
 */
private $timezone;

private $currentCustomer;
  
   public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\Customer\Model\Session $currentCustomer,
        TimezoneInterface $timezone,
        array $data
    ) {
        parent::__construct($context, $data);
        $this->timezone = $timezone;
        $this->currentCustomer = $currentCustomer;
    }

    public function getCustomerFirstName() { 

        return $this->currentCustomer->isLoggedIn() ? $this->currentCustomer->getCustomer()->getFirstname() : null;
    }

    public function getStoreTimestamp()
    {
        $returnArray = [];

        // for get current time according to time zone
        $returnArray['currenttime'] = $this->timezone->scopeTimeStamp();
        $returnArray['storetimezone'] = $this->timezone->getConfigTimezone();
        // Set time to calculate shipping time
        $date = (new \DateTime())->setTimestamp($returnArray['currenttime']);
        $startDayTime = new \DateTime($date->format('Y-m-d ') . '00:00:01');
        $shippingHour = new \DateTime($date->format('Y-m-d ') . '09:40:00');
        // Get total seconds of free shipping at day
        $returnArray['limittime'] = ($shippingHour->getTimestamp() - $startDayTime->getTimestamp());
        // Get total of elapsed minutes
        $returnArray['elapsedtime'] = ($returnArray['currenttime'] - $startDayTime->getTimestamp());
        $shippingHour->setTimezone(new \DateTimeZone($returnArray['storetimezone']));
        $returnArray['limittimeutc'] = $this->timezone->convertConfigTimeToUtc($shippingHour);

        return $returnArray;    
    }
}
