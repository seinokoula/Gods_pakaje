<?php

use Sterlingarcher\GodsPakaje\Api;
use PHPUnit\Framework\TestCase;


class ApiTest extends TestCase
{
    public function testScrapeWebsite()
    {
        $api = new Api();
        $items = $api->scrapeWebsite();

        $this->assertIsArray($items);
        $this->assertNotEmpty($items);
        $this->assertArrayHasKey('name', $items[0]);
        $this->assertArrayHasKey('picture', $items[0]);
        $this->assertArrayHasKey('price', $items[0]);
    }
}

?>