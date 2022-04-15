<?php

namespace App\Controller\Api;

use App\Service\ArticleService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Routing\Annotation\Route;

class ApiArticle extends AbstractController
{
    /**
     * @Route(
     *  "/api/articles", 
     *  name="api_get_articles", 
     *  methods={"GET"})
     * 
     * @param Request $request
     * @param SerializerInterface $serializer
     * @param ManagerRegistry $doctrine
     * @return JsonResponse
     */
    public function getArticles(
        Request $request,
        SerializerInterface $serializer,
        ArticleService $articleService
    ): JsonResponse
    {
        $articlesFromDatabase = $articleService->getArticlesFromDatabase();
        $articlesFromRSS = $articleService->getArticlesFromRSS();

        $result = array_merge($articlesFromDatabase, $articlesFromRSS);
        
        $response = new JsonResponse();

        $response->setStatusCode(Response::HTTP_OK);
        $response->setData($result);

        sleep(2);

        return $response;
    }
}