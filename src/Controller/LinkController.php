<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Link;
use App\Repository\LinkRepositoryInterface;
use App\Service\LinkProvider;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Util\Json;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class LinkController extends AbstractApiController
{
    public function save(Request                 $request, LinkProvider $linkProvider,
                         LinkRepositoryInterface $linkRepository): JsonResponse
    {

        try{
            $bodyContent = $this->getBodyContent($request);
        }catch (\Exception $e)
        {
            return new JsonResponse(null,Response::HTTP_BAD_REQUEST);
        }


        if (!isset($bodyContent['url'])) {
            return new JsonResponse(null,Response::HTTP_BAD_REQUEST);
        }

        /** @var Link $link */
        $link = $linkProvider->get($bodyContent['url']);
        if ($link) {
            $linkRepository->save($link);
        }

        return new JsonResponse(json_encode($link), Response::HTTP_CREATED, [], true);
    }

    public function delete(Request                $request, LinkRepositoryInterface $linkRepository,
                           EntityManagerInterface $em
    ): JsonResponse
    {

        try{
            $bodyContent = $this->getBodyContent($request);
        }catch (\Exception $e)
        {
            return new JsonResponse(null,Response::HTTP_BAD_REQUEST);
        }

        $link = $linkRepository->findOneById($bodyContent['id']);
        if ($link) {
            $em->remove($link);
            $em->flush();
        }else{
            return new JsonResponse(null,Response::HTTP_NO_CONTENT);
        }

        return new JsonResponse(json_encode([]), Response::HTTP_OK, [], true);
    }

    public function list(LinkRepositoryInterface $linkRepository): JsonResponse
    {
        $links = $linkRepository->findAll();
        return new JsonResponse($links, Response::HTTP_OK, [], false);
    }

}