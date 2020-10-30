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

$GLOBALS['TL_DCA']['tl_files']['fields']['meta']['eval']['metaFields']['protected'] = 'maxlength="1"';
$GLOBALS['TL_DCA']['tl_files']['fields']['hidden'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_files']['hidden'],
	'exclude'                 => true,
	'filter'                  => true,
	'inputType'               => 'checkbox',
	'sql'                     => "char(1) NOT NULL default ''",
	'save_callback'           => [['\MarcelMathiasNolte\ContaoHideFilesBundle\DcaCallbacks','updateMeta']]
);
array_insert($GLOBALS['TL_DCA']['tl_files']['list']['operations'], 0, array(
	'toggle' => array
	(
		'icon'                => 'visible.svg',
		'attributes'          => 'onclick="Backend.getScrollOffset();return AjaxRequest.toggleVisibility(this,\'%s\')"',
		'button_callback'     => array('\MarcelMathiasNolte\ContaoHideFilesBundle\DcaCallbacks', 'toggleIcon')
	)
));
$GLOBALS['TL_DCA']['tl_files']['fields']['meta']['save_callback'][] = ['\MarcelMathiasNolte\ContaoHideFilesBundle\DcaCallbacks','updateMeta2'];
