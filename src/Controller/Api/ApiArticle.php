<?php

namespace App\Controller\Api;

use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
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
        ManagerRegistry $doctrine 
    ): JsonResponse
    {
        $response = new JsonResponse(['data' => 'ok']);
        return $response;
    }
}