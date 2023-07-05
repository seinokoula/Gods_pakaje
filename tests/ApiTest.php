<?php

use PHPUnit\Framework\TestCase;
use Sterlingarcher\GodsPakaje\Api;

class ApiTest extends TestCase
{
    public function testScrapeWebsite(): void
    {
        $api = new Api();
        $results = $api->scrapeWebsite();

        $this->assertIsArray($results['items']);
        $this->assertIsArray($results['categories']);
        $this->assertIsArray($results['brands']);
    }
}
