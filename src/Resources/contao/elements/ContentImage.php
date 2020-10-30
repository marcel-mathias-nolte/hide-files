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

/**
 * Front end content element "image".
 *
 * @author Leo Feyer <https://github.com/leofeyer>
 */
class ContentImage extends \Contao\ContentElement
{
	/**
	 * Template
	 * @var string
	 */
	protected $strTemplate = 'ce_image';

	/**
	 * Files model
	 * @var \Contao\FilesModel
	 */
	protected $objFilesModel;

	/**
	 * Return if the image does not exist
	 *
	 * @return string
	 */
	public function generate()
	{
		if (!$this->singleSRC)
		{
			return '';
		}

		$objFile = \Contao\FilesModel::findByUuid($this->singleSRC);

		if ($objFile === null || !is_file(\Contao\System::getContainer()->getParameter('kernel.project_dir') . '/' . $objFile->path))
		{
			return '';
		}

		$this->singleSRC = $objFile->path;
		$this->objFilesModel = $objFile;

		return parent::generate();
	}

	/**
	 * Generate the content element
	 */
	protected function compile()
	{
		$this->arrData['floating'] = '';

		$this->addImageToTemplate($this->Template, $this->arrData, null, null, $this->objFilesModel);
	}
}
