<?php

namespace Fintecture\HyvaPayment\Block\Adminhtml\System\Config\Information;

use Magento\Config\Block\System\Config\Form\Field;

class Documentation extends Field
{
    /**
     * @param \Magento\Framework\Data\Form\Element\AbstractElement $element
     *
     * @return string
     */
    public function render(\Magento\Framework\Data\Form\Element\AbstractElement $element)
    {
        $output = '<p>';
        $output .= __('Explore our <a href="%1" target="_blank"> online documentation</a> for step-by-step guidance on configuring this module. Need assistance? Contact our support team at support@fintecture.com', 'https://doc.fintecture.com/page/magento');
        $output .= '</p>';

        return '<div id="row_' . $element->getHtmlId() . '">' . $output . '</div>';
    }
}
