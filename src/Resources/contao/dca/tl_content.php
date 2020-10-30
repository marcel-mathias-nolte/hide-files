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

//'image'                       => '{type_legend},type,headline;{source_legend},singleSRC,size,imagemargin,fullsize,overwriteMeta;{template_legend:hide},customTpl;{protected_legend:hide},protected;{expert_legend:hide},guests,cssID;{invisible_legend:hide},invisible,start,stop',
//'gallery'                     => '{type_legend},type,headline;{source_legend},multiSRC,sortBy,metaIgnore;{image_legend},size,imagemargin,perRow,fullsize,perPage,numberOfItems;{template_legend:hide},galleryTpl,customTpl;{protected_legend:hide},protected;{expert_legend:hide},guests,cssID,useHomeDir;{invisible_legend:hide},invisible,start,stop',
