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

if (!function_exists('mmn_insert_after')) {
    function mmn_insert_after (&$array, $after, $newKey, $newValue) {
        foreach (array_keys($array) as $pos => $key) {
            if ($key == $after) {
                array_insert($array, $pos +1, [$newKey => $newValue]);
                return;
            }
        }
    }
}

// Content elements
mmn_insert_after($GLOBALS['TL_CTE']['files'], 'download', 'mmn_download', 'MarcelMathiasNolte\ContaoHideFilesBundle\ContentDownload');
mmn_insert_after($GLOBALS['TL_CTE']['files'], 'downloads', 'mmn_downloads', 'MarcelMathiasNolte\ContaoHideFilesBundle\ContentDownloads');

/*
(
    'texts' => array
    (
        'headline'        => 'Contao\ContentHeadline',
        'text'            => 'Contao\ContentText',
        'html'            => 'Contao\ContentHtml',
        'list'            => 'Contao\ContentList',
        'table'           => 'Contao\ContentTable',
        'code'            => 'Contao\ContentCode',
        'markdown'        => 'Contao\ContentMarkdown'
    ),
    'accordion' => array
    (
        'accordionSingle' => 'Contao\ContentAccordion',
        'accordionStart'  => 'Contao\ContentAccordionStart',
        'accordionStop'   => 'Contao\ContentAccordionStop'
    ),
    'slider' => array
    (
        'sliderStart'     => 'Contao\ContentSliderStart',
        'sliderStop'      => 'Contao\ContentSliderStop'
    ),
    'links' => array
    (
        'hyperlink'       => 'Contao\ContentHyperlink',
        'toplink'         => 'Contao\ContentToplink'
    ),
    'media' => array
    (
        'image'           => 'Contao\ContentImage',
        'gallery'         => 'Contao\ContentGallery',
        'player'          => 'Contao\ContentMedia',
        'youtube'         => 'Contao\ContentYouTube',
        'vimeo'           => 'Contao\ContentVimeo'
    ),
    'files' => array
    (
        'download'        => 'Contao\ContentDownload',
        'downloads'       => 'Contao\ContentDownloads'
    ),
    'includes' => array
    (
        'article'         => 'Contao\ContentArticle',
        'alias'           => 'Contao\ContentAlias',
        'form'            => 'Contao\Form',
        'module'          => 'Contao\ContentModule',
        'teaser'          => 'Contao\ContentTeaser'
    )
); */
