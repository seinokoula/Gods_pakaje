<?php

namespace Sterlingarcher\GodsPakaje;

use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\DomCrawler\Crawler;

class Api
{
    /**
     * @return array<string, array<int, array<string, mixed>>>
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

        $categoryLinks = $crawler->filter('.stack.col.gap-16.dont-collapse .list a');

        $categories = [];
        foreach ($categoryLinks as $link) {
            $categoryName = $link->textContent;
            $categoryUrl = $link->getAttribute('href');

            $category = [
                'name' => $categoryName,
                'url' => $categoryUrl,
            ];

            $categories[] = $category;
        }

        $brandLinks = $crawler->filter('.stack.col.gap-16.dont-collapse ~ .stack.col.gap-16.dont-collapse .list a');

        $brands = [];
        foreach ($brandLinks as $link) {
            $brandName = $link->textContent;
            $brandUrl = $link->getAttribute('href');


            $brand = [
                'name' => $brandName,
                'url' => $brandUrl,
            ];

            $brands[] = $brand;
        }

        $results = [
            'items' => $items,
            'categories' => $categories,
            'brands' => $brands,
        ];

        return $results;
    }
}
