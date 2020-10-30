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

$GLOBALS['TL_DCA']['tl_settings']['palettes']['default'] .= ';{hide_files_settings};mmn_hide_files_mode';
$GLOBALS['TL_DCA']['tl_settings']['fields']['mmn_hide_files_mode'] = [
    'inputType'               => 'select',
    'options'                 => &$GLOBALS['TL_LANG']['tl_settings']['mmn_hide_files_mode_options'],
    'eval'                    => array('chosen'=>false, 'tl_class'=>'w50'),
];
