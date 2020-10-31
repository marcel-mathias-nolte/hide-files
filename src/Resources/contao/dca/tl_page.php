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

$GLOBALS['TL_DCA']['tl_page']['palettes']['root'] .= ';{hide_files_settings},mmn_hide_files_mode,mmn_hide_files_overlay';
$GLOBALS['TL_DCA']['tl_page']['palettes']['rootfallback'] .= ';{hide_files_settings},mmn_hide_files_mode,mmn_hide_files_overlay_none,mmn_hide_files_overlay_custom';
$GLOBALS['TL_DCA']['tl_page']['palettes']['__selector__'][] = 'mmn_hide_files_overlay_custom';
$GLOBALS['TL_DCA']['tl_page']['fields']['mmn_hide_files_mode'] = [
    'label'                   => &$GLOBALS['TL_LANG']['tl_page']['mmn_hide_files_mode'],
    'inputType'               => 'select',
    'exclude'                 => true,
    'options'                 => &$GLOBALS['TL_LANG']['tl_page']['mmn_hide_files_mode_options'],
    'eval'                    => array('chosen'=>false, 'tl_class'=>'w50'),
    'sql'                     => "varchar(255) NOT NULL default 'hide'"
];
$GLOBALS['TL_DCA']['tl_page']['fields']['mmn_hide_files_overlay_none'] = [
    'label'                   => &$GLOBALS['TL_LANG']['tl_page']['mmn_hide_files_overlay_none'],
    'exclude'                 => true,
    'inputType'               => 'checkbox',
    'eval'                    => array('tl_class'=>'w50 clr'),
    'sql'                     => "char(1) NOT NULL default ''"
];
$GLOBALS['TL_DCA']['tl_page']['fields']['mmn_hide_files_overlay_custom'] = [
    'label'                   => &$GLOBALS['TL_LANG']['tl_page']['mmn_hide_files_overlay_custom'],
    'exclude'                 => true,
    'inputType'               => 'checkbox',
    'eval'                    => array('tl_class'=>'w50', 'submitOnChange'=>true),
    'sql'                     => "char(1) NOT NULL default ''"
];
$GLOBALS['TL_DCA']['tl_page']['fields']['mmn_hide_files_overlay_image'] = [
    'label'                   => &$GLOBALS['TL_LANG']['tl_page']['mmn_hide_files_overlay_image'],
    'exclude'                 => true,
    'inputType'               => 'fileTree',
    'eval'                    => array('filesOnly'=>true, 'fieldType'=>'radio', 'mandatory'=>true, 'tl_class'=>'clr', 'extensions' => \Contao\Config::get('validImageTypes')),
    'sql'                     => "binary(16) NULL"
];
$GLOBALS['TL_DCA']['tl_page']['subpalettes']['mmn_hide_files_overlay_custom'] = 'mmn_hide_files_overlay_image';
