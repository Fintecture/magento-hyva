<?php

declare(strict_types=1);

namespace Fintecture\HyvaPayment\Model\Config\File;

class PemFile extends \Magento\Config\Block\System\Config\Form\Field\File
{
    protected function _getDeleteCheckbox()
    {
        $value = $this->getValue();
        if ($value) {
            if (substr_compare($value, '.pem', -strlen('.pem')) === 0) {
                return '<div><br>' . __('Please re-upload private key file') . '</div>';
            } else {
                return '<div><br>' . __('Private key file already saved') . '</div>';
            }
        } else {
            return '<div><br>' . __('Please upload private key file') . '</div>';
        }
    }
}
