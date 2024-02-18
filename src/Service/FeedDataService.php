<?php

namespace App\Service;

use App\Entity\Feed;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class FeedDataService
{
    private HttpClientInterface $httpClient;

    public function __construct(HttpClientInterface $httpClient)
    {
        $this->httpClient = $httpClient->withOptions(['verify_peer' => false]);
    }

    public function getFeedData(Feed $feed): array|TransportExceptionInterface
    {
        try {
            // Fetch the XML content from the feed URL
            $xmlContent = $this->httpClient
                ->request('GET', $feed->getUrl())
                ->getContent();

        } catch (TransportExceptionInterface $e) {
           return $e;
        }

        return $this->getFeedDataFromXml($xmlContent);
    }

    public function getFeedDataFromXml(string $xmlContent): array
    {
        $xml = simplexml_load_string($xmlContent);
        $json = json_encode($xml);
        $array = json_decode($json,TRUE);

        return $array;
    }
}
