<?php
/**
 * Ffuenf_Common extension.
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the MIT License
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/mit-license.php
 *
 * @category   Ffuenf
 *
 * @author     Achim Rosenhagen <a.rosenhagen@ffuenf.de>
 * @copyright  Copyright (c) 2018 ffuenf (http://www.ffuenf.de)
 * @license    http://opensource.org/licenses/mit-license.php MIT License
 */

class Ffuenf_Common_Helper_Data extends Ffuenf_Common_Helper_Core
{
    const XML_PATH_EXTENSION_ACTIVE = 'ffuenf_common/general/enable';
    const NEW_MAGENTO_CSS_LOCATION  = 'lib/prototype/windows/themes/magento.css';
    const OLD_MAGENTO_CSS_LOCATION  = 'prototype/windows/themes/magento.css';

    /**
     * Variable for if the extension is active.
     *
     * @var bool
     */
    protected $_bExtensionActive;

    /**
     * path of new magento.css file
     *
     * @return string
     */
    protected function _getNewOverlayFileLocation()
    {
        return BP.DS.'skin'.DS.'adminhtml'.DS.'default'.DS.'default'
        .DS.'lib'.DS.'prototype'.DS.'windows'.DS.'themes'.DS.'magento.css';
    }

    /**
     * Check to see if the extension is active.
     *
     * @return bool
     */
    public function isExtensionActive()
    {
        return $this->getStoreFlag(self::XML_PATH_EXTENSION_ACTIVE, '_bExtensionActive');
    }

    /**
     * return css file path to include for overlay window css - version dependent
     *
     * @return string
     */
    public function getOverlayFileName()
    {
        if (Mage::helper('ffuenf_common/file')->exists($this->_getNewOverlayFileLocation())) {
            return self::NEW_MAGENTO_CSS_LOCATION;
        } else {
            return self::OLD_MAGENTO_CSS_LOCATION;
        }
    }

    /**
     * return css file type to include for overlay window css - version dependent
     *
     * @return string
     */
    public function getOverlayFileType()
    {
        if (Mage::helper('ffuenf_common/file')->exists($this->_getNewOverlayFileLocation())) {
            return 'skin_css';
        } else {
            return 'js_css';
        }
    }

    /**
     * return human-readable sizes
     *
     * @return string
     */
    public function convert($size)
    {
        $unit = array('B', 'KB', 'MB', 'GB', 'TB', 'PB');
        return @round($size / pow(1024, ($i = floor(log($size, 1024)))), 2).$unit[$i];
    }

    /**
     * return feed-friendly text
     *
     * @return string
     */
    public function html2plain($value)
    {
        // 194 -> 32
        $value = str_replace(' ', ' ', $value);
        $value = str_replace('&nbsp;', ' ', $value);
        $value = str_replace('"', '', $value);
        $value = strip_tags($value);
        $value = str_replace('\\\'', '\'', $value);
        $value = preg_replace('/\s+/', ' ', $value);
        $value = trim($value);
        return $value;
    }

    public function hexToRgb($hex, $alpha = false, $css = false) {
       $hex      = str_replace('#', '', $hex);
       $length   = strlen($hex);
       $rgb['r'] = hexdec($length == 6 ? substr($hex, 0, 2) : ($length == 3 ? str_repeat(substr($hex, 0, 1), 2) : 0));
       $rgb['g'] = hexdec($length == 6 ? substr($hex, 2, 2) : ($length == 3 ? str_repeat(substr($hex, 1, 1), 2) : 0));
       $rgb['b'] = hexdec($length == 6 ? substr($hex, 4, 2) : ($length == 3 ? str_repeat(substr($hex, 2, 1), 2) : 0));
       if ($alpha) {
          $rgb['a'] = $alpha;
       }
       if (!$css) {
          return $rgb;
       } else {
           return implode(array_keys($rgb)) . '(' . implode(', ', $rgb) . ')';
       }
    }
}
