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

use Contao\CoreBundle\Exception\PageNotFoundException;

/**
 * Front end content element "download".
 *
 * @author Leo Feyer <https://github.com/leofeyer>
 */
class ContentDownload extends \Contao\ContentElement
{
	/**
	 * @var \Contao\FilesModel
	 */
	protected $objFile;

	/**
	 * Template
	 * @var string
	 */
	protected $strTemplate = 'ce_download';

	/**
	 * Return if the file does not exist
	 *
	 * @return string
	 */
	public function generate()
	{
		// Return if there is no file
		if (!$this->singleSRC)
		{
			return '';
		}

		$objFile = \Contao\FilesModel::findByUuid($this->singleSRC);

		if ($objFile === null)
		{
			return '';
		}

		$allowedDownload = \Contao\StringUtil::trimsplit(',', strtolower(\Contao\Config::get('allowedDownload')));

		// Return if the file type is not allowed
		if (!\in_array($objFile->extension, $allowedDownload))
		{
			return '';
		}

		$file = \Contao\Input::get('file', true);

		// Send the file to the browser (see #4632 and #8375)
		if ($file && (!isset($_GET['cid']) || \Contao\Input::get('cid') == $this->id))
		{

			if ($file == $objFile->path)
			{

                if (!FE_USER_LOGGED_IN && $objFile->hidden) {
                    throw new \Contao\CoreBundle\Exception\AccessDeniedException('Page access denied:  ' . \Environment::get('uri'));
                    return '';
                }

                \Contao\Controller::sendFileToBrowser($file, (bool) $this->inline);
			}

			if (isset($_GET['cid']))
			{
				throw new PageNotFoundException('Invalid file name');
			}
		}

		$this->objFile = $objFile;
		$this->singleSRC = $objFile->path;

		return parent::generate();
	}

	/**
	 * Generate the content element
	 */
	protected function compile()
	{
		$objFile = new \Contao\File($this->singleSRC);
		$request = \Contao\System::getContainer()->get('request_stack')->getCurrentRequest();

		if ($request && \Contao\System::getContainer()->get('contao.routing.scope_matcher')->isBackendRequest($request))
		{
			$arrMeta = \Contao\Frontend::getMetaData($this->objFile->meta, $GLOBALS['TL_LANGUAGE']);
		}
		else
		{
			global $objPage;

			$arrMeta = \Contao\Frontend::getMetaData($this->objFile->meta, $objPage->language);

			if (empty($arrMeta) && $objPage->rootFallbackLanguage !== null)
			{
				$arrMeta = \Contao\Frontend::getMetaData($this->objFile->meta, $objPage->rootFallbackLanguage);
			}
		}

		// Use the meta title (see #1459)
		if (!$this->overwriteLink && isset($arrMeta['title']))
		{
			$this->linkTitle = \Contao\StringUtil::specialchars($arrMeta['title']);
		}

		if (!$this->titleText || !$this->overwriteLink)
		{
			$this->titleText = sprintf($GLOBALS['TL_LANG']['MSC']['download'], $objFile->basename);
		}

		$strHref = \Contao\Environment::get('request');

		// Remove an existing file parameter (see #5683)
		if (isset($_GET['file']))
		{
			$strHref = preg_replace('/(&(amp;)?|\?)file=[^&]+/', '', $strHref);
		}

		if (isset($_GET['cid']))
		{
			$strHref = preg_replace('/(&(amp;)?|\?)cid=\d+/', '', $strHref);
		}

		$strHref .= (strpos($strHref, '?') !== false ? '&amp;' : '?') . 'file=' . \Contao\System::urlEncode($objFile->value) . '&amp;cid=' . $this->id;

		$this->Template->link = $this->linkTitle ?: $objFile->basename;
		$this->Template->title = \Contao\StringUtil::specialchars($this->titleText);
		$this->Template->href = $strHref;
		$this->Template->filesize = $this->getReadableSize($objFile->filesize);
		$this->Template->icon = \Contao\Image::getPath($objFile->icon);
		$this->Template->mime = $objFile->mime;
		$this->Template->extension = $objFile->extension;
		$this->Template->path = $objFile->dirname;
	}
}

