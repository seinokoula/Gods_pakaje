<?php

namespace Sterlingarcher\GodsPakaje;

use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\DomCrawler\Crawler;

class Api
{
    /**
     * @return array<array<string, mixed>>
     */
    public function scrapeWebsite(): array
    {
        $httpClient = HttpClient::create();
        $response = $httpClient->request('GET', 'https://goods.wtf/');

        $content = $response->getContent();

        $crawler = new Crawler($content);
        $itemElements = $crawler->filter('.item');

        $items = [];
        foreach ($itemElements as $itemElement) {
            $domCrawler = new Crawler($itemElement);

            $name = $domCrawler->filter('.text-secondary')->first()->text();
            $picture = $domCrawler->filter('img')->first()->attr('src');
            $price = $domCrawler->filter('.text-secondary')->last()->text();

            $item = [
                'name' => $name,
                'picture' => $picture,
                'price' => $price,
            ];

            $items[] = $item;
        }

        return $items;
    }
}
