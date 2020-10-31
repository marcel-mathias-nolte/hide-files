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

class DcaCallbacks extends \Contao\Backend
{
    public function updateMeta($value, \Contao\DataContainer $dc) {
        $time = time();
        $meta = deserialize($dc->activeRecord->meta ? $dc->activeRecord->meta : 'a:1:{s:2:"de";a:5:{s:5:"title";s:0:"";s:3:"alt";s:0:"";s:4:"link";s:0:"";s:7:"caption";s:0:"";s:9:"protected";s:0:"";}}');
        foreach ($meta as $lang => $m) {
            $meta[$lang]['protected'] = $value ? '1' : '';
        }
        $dc->activeRecord->meta = serialize($meta);
        $this->Database->prepare("UPDATE tl_files SET tstamp=$time, meta=? WHERE id=?")
            ->execute($dc->activeRecord->meta, $dc->activeRecord->id);
        return $value;
    }

    public function updateMeta2($value, \Contao\DataContainer $dc) {
        $meta = deserialize($value ? $value : 'a:1:{s:2:"de";a:5:{s:5:"title";s:0:"";s:3:"alt";s:0:"";s:4:"link";s:0:"";s:7:"caption";s:0:"";s:9:"protected";s:0:"";}}');
        foreach ($meta as $lang => $m) {
            $meta[$lang]['protected'] = $dc->activeRecord->hidden ? '1' : '';
        }
        return serialize($meta);
    }

    public function toggleIcon($row, $href, $label, $title, $icon, $attributes)
    {
        if (\Contao\Input::get('cid'))
        {
            $this->toggleVisibility(\Contao\Input::get('cid'), (\Contao\Input::get('state') == 1), (@func_get_arg(12) ?: null));
            $this->redirect($this->getReferer());
        }

        if ($row['type'] == 'folder') return '';

        $href .= '&amp;id=' . \Contao\Input::get('id') . '&amp;cid=' . urlencode($row['id']) . '&amp;state=' . $row['hidden'];
        $visible = $this->Database->prepare("SELECT hidden FROM tl_files WHERE path = ?")->execute(html_entity_decode(urldecode($row['id'])))->next()->hidden;
        $icon = $visible ? 'invisible.svg' : 'visible.svg';


        return '<a href="' . $this->addToUrl($href) . '" title="' . \Contao\StringUtil::specialchars($title) . '" data-tid="cid"' . $attributes . '>' . \Contao\Image::getHtml($icon, $label, 'data-state="' . ($row['hidden'] ? 0 : 1) . '"') . '</a> ';
    }

    public function toggleVisibility($intId, $blnVisible, \Contao\DataContainer $dc=null)
    {
        // Set the ID and action
        $intId = html_entity_decode($intId);
        $id = $this->Database->prepare("SELECT id FROM tl_files WHERE path = ?")->execute($intId)->next()->id;
        \Contao\Input::setGet('id', $id);
        \Contao\Input::setGet('act', 'toggle');
        if (!$dc) {
            $dc = new \Contao\DC_File('tl_files');
        }
        if ($dc)
        {
            $dc->id = $id; // see #8043
        }

        // Trigger the onload_callback
        if (is_array($GLOBALS['TL_DCA']['tl_files']['config']['onload_callback']))
        {
            foreach ($GLOBALS['TL_DCA']['tl_files']['config']['onload_callback'] as $callback)
            {
                if (is_array($callback))
                {
                    $this->import($callback[0]);
                    $this->{$callback[0]}->{$callback[1]}($dc);
                }
                elseif (is_callable($callback))
                {
                    $callback($dc);
                }
            }
        }

        // Set the current record
        if ($dc)
        {
            $objRow = $this->Database->prepare("SELECT * FROM tl_files WHERE id=?")
                ->limit(1)
                ->execute($dc->id);

            if ($objRow->numRows)
            {
                $dc->activeRecord = $objRow;
            }
        }

        $objVersions = new \Contao\Versions('tl_files', $intId);
        $objVersions->initialize();

        // Reverse the logic (elements have invisible=1)
        $blnVisible = !$blnVisible;

        // Trigger the save_callback
        if (is_array($GLOBALS['TL_DCA']['tl_files']['fields']['hidden']['save_callback']))
        {
            foreach ($GLOBALS['TL_DCA']['tl_files']['fields']['hidden']['save_callback'] as $callback)
            {
                if (is_array($callback))
                {
                    $this->import($callback[0]);
                    $blnVisible = $this->{$callback[0]}->{$callback[1]}($blnVisible, $dc);
                }
                elseif (is_callable($callback))
                {
                    $blnVisible = $callback($blnVisible, $dc);
                }
            }
        }

        $time = time();
        // Update the database
        $this->Database->prepare("UPDATE tl_files SET tstamp=$time, hidden='" . ($blnVisible ? '1' : '') . "' WHERE id=?")
            ->execute($dc->id);
        if ($dc)
        {
            $dc->activeRecord->tstamp = $time;
            $dc->activeRecord->hidden = ($blnVisible ? '1' : '');
        }

        // Trigger the onsubmit_callback
        if (is_array($GLOBALS['TL_DCA']['tl_files']['config']['onsubmit_callback']))
        {
            foreach ($GLOBALS['TL_DCA']['tl_files']['config']['onsubmit_callback'] as $callback)
            {
                if (is_array($callback))
                {
                    $this->import($callback[0]);
                    $this->{$callback[0]}->{$callback[1]}($dc);
                }
                elseif (is_callable($callback))
                {
                    $callback($dc);
                }
            }
        }

        $objVersions->create();
    }

    public function setSingleSrcFlags($varValue, \Contao\DataContainer $dc)
    {
        if ($dc->activeRecord)
        {
            switch ($dc->activeRecord->type)
            {
                case 'mmn_image':
                    $GLOBALS['TL_DCA'][$dc->table]['fields'][$dc->field]['eval']['extensions'] = \Contao\Config::get('validImageTypes');
                    break;

                case 'mmn_download':
                    $GLOBALS['TL_DCA'][$dc->table]['fields'][$dc->field]['eval']['extensions'] = \Contao\Config::get('allowedDownload');
                    break;
            }
        }

        return $varValue;
    }


    public function setMultiSrcFlags($varValue, \Contao\DataContainer $dc)
    {
        if ($dc->activeRecord)
        {
            switch ($dc->activeRecord->type)
            {
                case 'mmn_gallery':
                    $GLOBALS['TL_DCA'][$dc->table]['fields'][$dc->field]['eval']['isGallery'] = true;
                    $GLOBALS['TL_DCA'][$dc->table]['fields'][$dc->field]['eval']['extensions'] = \Contao\Config::get('validImageTypes');
                    break;

                case 'mmn_downloads':
                    $GLOBALS['TL_DCA'][$dc->table]['fields'][$dc->field]['eval']['isDownloads'] = true;
                    $GLOBALS['TL_DCA'][$dc->table]['fields'][$dc->field]['eval']['extensions'] = \Contao\Config::get('allowedDownload');
                    break;
            }
        }

        return $varValue;
    }

    public static function getBlurredSrc($objFile) {
        static $hideMode;
        static $watermarkFile;
        if (!$hideMode) {
            global $objPage;
            $objRootPage = \Contao\PageModel::findByPk($objPage->rootId);
            $hideMode = $objRootPage != null && $objRootPage->mmn_hide_files_mode != '' ? $objRootPage->mmn_hide_files_mode : 'hide';
            if ($objRootPage->mmn_hide_files_overlay_custom) {
                $objWatermarkFile = \Contao\FilesModel::findByUuid($objRootPage->mmn_hide_files_overlay_image);
                if ($objWatermarkFile != null) {
                    $watermarkFile = \Contao\System::getContainer()->getParameter('kernel.project_dir') . '/' . $objWatermarkFile->path;
                    if (!file_exists($watermarkFile)) {
                        $watermarkFile = __DIR__ . '/Resources/contao/assets/lock.png';
                    }
                } else {
                    $watermarkFile = __DIR__ . '/Resources/contao/assets/lock.png';
                }
            }
            elseif ($objRootPage->mmn_hide_files_overlay_none) {
                $watermarkFile = '';
            }
            else {
                $watermarkFile = __DIR__ . '/Resources/contao/assets/lock.png';
            }
        }
        if (!FE_USER_LOGGED_IN && $objFile->hidden) {
            if ($hideMode == 'blur' && extension_loaded('imagick')) {#
                try {
                    set_time_limit(0);
                    $src = \Contao\System::getContainer()->getParameter('kernel.project_dir') . '/' . $objFile->path;
                    $ext = $objFile->extension;
                    $target_dir = \Contao\System::getContainer()->getParameter('kernel.project_dir') . '/assets/images/hide-files';
                    if (!is_dir($target_dir)) {
                        mkdir($target_dir);
                    }
                    $newsrc = md5($objFile->path) . '.' . $ext;
                    $abs = $target_dir . '/' . $newsrc;
                    if (!file_exists($abs) || filemtime($abs) != filemtime($src)) {
                        $imagick = new \Imagick($src);
                        $imagick->gaussianBlurImage(80, 25);
                        $s_height = $imagick->getImageHeight();
                        $s_width = $imagick->getImageWidth();
                        if ($watermarkFile) {
                            $watermark = new \Imagick($watermarkFile);
                            $w_height = $watermark->getImageHeight();
                            $w_width = $watermark->getImageWidth();
                            if ($s_height > $s_width) {
                                $n_width = $s_width / 2;
                                $n_height = $n_width * $w_height / $w_width;
                                $n_pos_x = $s_width / 4;
                                $n_pos_y = $s_height / 2 - $n_height / 2;
                            } else {
                                $n_height = $s_height / 2;
                                $n_width = $w_width * $n_height / $w_height;
                                $n_pos_x = $s_width / 2 - $n_width / 2;
                                $n_pos_y = $s_height / 4;
                            }
                            $watermark->resizeImage($n_width, $n_height, \Imagick::FILTER_LANCZOS, 1);
                            $imagick->compositeImage($watermark, \Imagick::COMPOSITE_DEFAULT, $n_pos_x, $n_pos_y);
                        }
                        $imagick->flattenImages();
                        file_put_contents($abs, $imagick->getImageBlob());
                        touch($abs, filemtime($src));
                        $imagick->destroy();
                        if ($watermarkFile) {
                            $watermark->destroy();
                        }
                    }
                    return 'assets/images/hide-files/' . $newsrc;
                }
                catch (\Exception $e) {
                    return false;
                    //throw new \Exception('Unable to process ' . $src);
                }
            } else {
                return false;
            }
        }
        return $objFile->path;
    }
}
