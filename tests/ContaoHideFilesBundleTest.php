<?php

/*
 * This file is part of SkeletonBundle.
 *
 * (c) John Doe
 *
 * @license LGPL-3.0-or-later
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
