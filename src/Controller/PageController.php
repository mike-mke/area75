<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class PageController extends AbstractController
{
    private const VALID_PAGES = [
        'whatisaa', 'preamble', '12steps', '12traditions',
        'aaresources', 'messagetoteens', 'structure',
        'districtmeetings', 'registrar', 'accessibilities',
        'archives', 'corrections', 'cpc', 'finance',
        'grapevine', 'literature', 'publicinformation',
        'treatment', 'technology', 'post_your_event',
    ];

    #[Route('/page/{slug}', name: 'app_page', requirements: ['slug' => '[a-z0-9_]+'])]
    public function show(string $slug): Response
    {
        if (!in_array($slug, self::VALID_PAGES, true)) {
            throw $this->createNotFoundException("Page '$slug' not found.");
        }

        return $this->render("page/$slug.html.twig");
    }
}
