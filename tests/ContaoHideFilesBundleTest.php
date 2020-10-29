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

namespace MarcelMathiasNolte\ContaoHideFilesBundle\Tests;

use PHPUnit\Framework\TestCase;

class ContaoHideFilesBundleTest extends TestCase
{
    public function testCanBeInstantiated()
    {
        $bundle = new ContaoHideFilesBundle();

        $this->assertInstanceOf('MarcelMathiasNolte\ContaoHideFilesBundle\ContaoHideFilesBundle', $bundle);
    }
}
