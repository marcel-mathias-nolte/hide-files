<?php

/*
 * This file is part of ContaoHideFilesBundle.
 *
 * @package   ContaoHideFilesBundle
 * @author    Marcel Mathias Nolte
 * @copyright Marcel Mathias Nolte 2020
 * @website	  https://github.com/marcel-mathias-nolte
 * @license   LGPL-3.0-or-later
 */

namespace MarcelMathiasNolte\ContaoHideFilesBundle;

$GLOBALS['TL_DCA']['tl_content']['palettes']['mmn_download'] = &$GLOBALS['TL_DCA']['tl_content']['palettes']['download'];
$GLOBALS['TL_DCA']['tl_content']['palettes']['mmn_downloads'] = &$GLOBALS['TL_DCA']['tl_content']['palettes']['downloads'];
$GLOBALS['TL_DCA']['tl_content']['palettes']['mmn_image'] = &$GLOBALS['TL_DCA']['tl_content']['palettes']['image'];
$GLOBALS['TL_DCA']['tl_content']['palettes']['mmn_gallery'] = &$GLOBALS['TL_DCA']['tl_content']['palettes']['gallery'];
$GLOBALS['TL_DCA']['tl_content']['fields']['singleSRC']['load_callback'][] = ['\MarcelMathiasNolte\ContaoHideFilesBundle\DcaCallbacks', 'setSingleSrcFlags'];
$GLOBALS['TL_DCA']['tl_content']['fields']['multiSRC']['load_callback'][] = ['\MarcelMathiasNolte\ContaoHideFilesBundle\DcaCallbacks', 'setMultiSrcFlags'];
