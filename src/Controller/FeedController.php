<?php
namespace App\Controller;

use App\Entity\Feed;
use App\Form\FeedFormType;
use App\Repository\FeedRepository;
use App\Service\FeedDataService;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Knp\Component\Pager\PaginatorInterface;

class FeedController extends AbstractController
{
    public const PER_PAGE = 6;

    #[Route('/feeds', name: 'feeds')]
    public function index(Request $request, PaginatorInterface $paginator, FeedRepository $feedRepository): Response
    {
        $feeds = $this->fetchFeeds($feedRepository, $searchTerm = $request->query->get('search'));
        $paginatedFeeds = $this->paginateFeeds($paginator, $feeds, $request->query->getInt('page', 1));

        return $this->render('feeds/index.html.twig', [
            'feeds' => $paginatedFeeds,
            'searchTerm' => $searchTerm,
        ]);
    }

    #[Route('/feeds/new', name: 'add_feed')]
    public function addFeed(Request $request, FeedRepository $feedRepository): Response
    {
        $feed = $feedRepository->newFeed();
        $form = $this->createForm(FeedFormType::class, $feed);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $feedRepository->save($feed);
            return $this->redirectToRoute('feed_data', ["id" => $feed->getId()]); // Assuming 'feeds' is the route name for displaying all feeds
        }
        // Render the form template
        return $this->render('feeds/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/feeds/{id}', name: 'feed_data')]
    public function showFeed(Feed $feed, Request $request, FeedDataService $feedDataService): Response
    {
        $feedData = $feedDataService->getFeedData($feed);

        if(is_array($feedData)) {
            return $this->render('feeds/data.html.twig', [
                'feedData' => $feedData
            ]);
        }

        return $this->render('error.html.twig', [
            'message' => 'Failed to retrieve feed data. Is the URL valid?'
        ]);
    }

    #[Route('/feeds/{id}/edit', name: 'edit_feed')]
    public function editFeed(Request $request, Feed $feed, FeedRepository $feedRepository): Response
    {
        // Create the edit form
        $form = $this->createForm(FeedFormType::class, $feed);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Save the updated feed to the database
            $feedRepository->save($feed);

            // Redirect to a success page or display a success message
            return $this->redirectToRoute('feeds'); // Assuming 'feeds' is the route name for displaying all feeds
        }

        // Render the edit form template
        return $this->render('feeds/edit.html.twig', [
            'form' => $form->createView(),
            'feed' => $feed
        ]);
    }


    private function fetchFeeds(FeedRepository $feedRepository, string $searchTerm = null)
    {
        if($searchTerm) {
            return $feedRepository->getFeedsBySearchQueryBuilder($searchTerm);
        }
        return $feedRepository->getAllFeedsQueryBuilder();
    }

    private function paginateFeeds(PaginatorInterface $paginator, $feedsQuery, $page = 1): PaginationInterface
    {
        return $paginator->paginate(
            $feedsQuery, // Query to paginate
            $page, // Page number
            $this::PER_PAGE // Items per page
        );
    }
}
