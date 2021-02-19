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
mmn_insert_after($GLOBALS['TL_CTE']['files'], 'download', 'mmn_download', 'MarcelMathiasNolte\ContaoHideFilesBundle\Elements\ContentDownload');
mmn_insert_after($GLOBALS['TL_CTE']['files'], 'downloads', 'mmn_downloads', 'MarcelMathiasNolte\ContaoHideFilesBundle\Elements\ContentDownloads');
mmn_insert_after($GLOBALS['TL_CTE']['media'], 'image', 'mmn_image', 'MarcelMathiasNolte\ContaoHideFilesBundle\Elements\ContentImage');
mmn_insert_after($GLOBALS['TL_CTE']['media'], 'gallery', 'mmn_gallery', 'MarcelMathiasNolte\ContaoHideFilesBundle\Elements\ContentGallery');
