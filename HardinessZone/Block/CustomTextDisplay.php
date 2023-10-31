<?php
namespace Dcw\HardinessZone\Block;

use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;

class CustomTextDisplay extends Template
{
    protected $scopeConfig;

    public function __construct(
        Context $context,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->scopeConfig = $scopeConfig;
    }

    public function displayCustomText()
    {
        $zoneArray = [];
        
        $customText = $this->scopeConfig->getValue('hardinesszone/general/comma_separated_values', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
        $customTextArray = explode('|', $customText);

        foreach ($customTextArray as $customText) {
            $zoneRangeAndText = explode('-', $customText);
            $zones = explode(',', $zoneRangeAndText[0]);

            $text = trim($zoneRangeAndText[1]);

            foreach ($zones as $zoneNumber) {
                $zoneArray[trim($zoneNumber)] = $text;
            }
        }
        return $zoneArray;
    }

    public function displayShippingInfo($zoneValue)
    {
        if (!$zoneValue) {
            return false;
        }
        $zoneList = $this->displayCustomText();

        if (isset($zoneList[$zoneValue])) {
            return $zoneList[$zoneValue];
        } else {
            return $zoneList[0];
        }
    }
}
