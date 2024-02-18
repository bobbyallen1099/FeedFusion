<?php

namespace App\Command;

use App\Entity\Feed;
use App\Repository\FeedRepository;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class SeedFeedsCommand extends Command
{
    private $feedRepository;

    // Had to make `http://` for local testing as it would error as there wasn't an SSL certificate
    private $feedsData = [
        ['url' => 'http://news.ycombinator.com/rss', 'name' => 'Hacker News', 'description' => 'Tech news from Hacker News.'],
        ['url' => 'http://www.php.net/news.rss', 'name' => 'PHP News', 'description' => 'All the latest news for PHP.'],
        ['url' => 'http://slashdot.org/rss/slashdot.rss', 'name' => 'SlashDot', 'description' => 'The latest news from SlashDot.'],
        ['url' => 'http://newsrss.bbc.co.uk/rss/newsonline_uk_edition/front_page/rss.xml', 'name' => 'BBC News', 'description' => 'The latest of BBC News in one convenient place.'],
        ['url' => 'http://www.reddit.com/r/technology/.rss', 'name' => 'Reddit Tech', 'description' => 'The latest tech news from Reddit.'],
        ['url' => 'http://rss.nytimes.com/services/xml/rss/nyt/Technology.xml', 'name' => 'New York Times Tech', 'description' => 'Tech news from The New York Times.'],
        ['url' => 'http://feeds.feedburner.com/TechCrunch/', 'name' => 'TechCrunch', 'description' => 'The latest technology news from TechCrunch.'],
        ['url' => 'http://www.wired.com/feed/rss', 'name' => 'Wired', 'description' => 'The latest news in technology, culture, science, and more from Wired.']
    ];

    public function __construct(FeedRepository $feedRepository)
    {
        $this->feedRepository = $feedRepository;

        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->setName('app:seed-feeds')
            ->setDescription('Seed data for the Feed entity');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        foreach ($this->feedsData as $feedData) {
            $this->createFeed($feedData['url'], $feedData['name'], $feedData['description']);
        }

        $io->success('Feeds seeded successfully.');

        return Command::SUCCESS;
    }

    private function createFeed(string $url, string $name, string $description)
    {
        $feed = new Feed();
        $feed->setUrl($url);
        $feed->setName($name);
        $feed->setDescription($description);

        $this->feedRepository->save($feed);
    }
}
