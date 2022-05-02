<?php

namespace Tests\Unit;

use App\Inspections\Spam;
use Tests\TestCase;

class SpamTest extends TestCase
{
    public function testItChecksForInvalidKeywords()
    {
        $spam = new Spam();

        $this->assertFalse($spam->detect('This is a legitimate reply!'));

        $this->expectException('Exception');

        $spam->detect('yahoo customer support');
    }

    public function testItChecksForAKeyBeingHeldDown()
    {
        $spam = new Spam();

        $this->assertFalse($spam->detect('This is a legitimate reply!'));

        $this->expectException('Exception');

        $spam->detect('Hello World aaaaaaaaaaaaaa');
    }
}
