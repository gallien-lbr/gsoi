<?php

namespace App\Controller;

use App\Repository\LinkRepositoryInterface;
use App\Service\LinkHelpers;
use App\Service\LinkProvider;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;


class ApiLinkController extends AbstractController
{
    public function save(Request $request, LinkProvider $linkProvider,
                         LinkRepositoryInterface $linkRepository): JsonResponse
    {
        try {
            $bodyContent = json_decode($request->getContent(), true, 512, JSON_THROW_ON_ERROR);
        } catch (JsonException $e) {
            throw new BadRequestHttpException('Bad content');
        }

        if (!isset($bodyContent['url'])) {
            throw new BadRequestHttpException('Bad request');
        }

        $url = $bodyContent['url'];

        if(LinkHelpers::isValid($url))
        {
            /** @var Link $link */
            $link = $linkProvider->get($url);
            $linkRepository->save($link);
        }

        return new JsonResponse('ok', 200, [], true);
    }
}