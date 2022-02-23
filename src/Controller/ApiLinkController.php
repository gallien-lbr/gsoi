<?php

namespace App\Controller;

use App\Entity\Link;
use App\Repository\LinkRepositoryInterface;
use App\Service\LinkHelpers;
use App\Service\LinkProvider;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;


class ApiLinkController
{
    public function save(Request $request, LinkProvider $linkProvider,
                         LinkRepositoryInterface $linkRepository): Response
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

        if(LinkHelpers::isValid($url) && null !== LinkHelpers::extractType($url))
        {
            $providedLink = $linkProvider->get($url);
            $link = new Link();
            $link->setTitle($providedLink['title']);
            $link->setProperties([]);
            $linkRepository->save($link);
        }

        return new Response('debug');
    }
}