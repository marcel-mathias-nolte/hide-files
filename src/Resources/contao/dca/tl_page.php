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

$GLOBALS['TL_DCA']['tl_page']['palettes']['root'] .= ';{hide_files_settings},mmn_hide_files_mode';
$GLOBALS['TL_DCA']['tl_page']['palettes']['rootfallback'] .= ';{hide_files_settings},mmn_hide_files_mode';
$GLOBALS['TL_DCA']['tl_page']['fields']['mmn_hide_files_mode'] = [
    'inputType'               => 'select',
    'exclude'                 => true,
    'options'                 => &$GLOBALS['TL_LANG']['tl_settings']['mmn_hide_files_mode_options'],
    'eval'                    => array('chosen'=>false, 'tl_class'=>'w50'),
    'sql'                     => "varchar(255) NOT NULL default ''"
];
