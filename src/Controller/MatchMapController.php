<?php

namespace App\Controller;

use App\Entity\MapEntity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Doctrine\ORM\EntityManagerInterface;

class MatchMapController extends AbstractController
{
    #[Route('/map', name: 'app_match_map')]
    public function index(): Response
    {
        return $this->render('match_map/index.html.twig', [
            'controller_name' => 'MatchMapController',
        ]);
    }

    
    #[Route('/save-location', name: 'save_location', methods: ['POST'])]
    public function saveLocation(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $latitude = $data['latitude'];
        $longitude = $data['longitude'];

        // Save latitude and longitude to database
        $mapEntity = new MapEntity();
        $mapEntity->setLatitude($latitude);
        $mapEntity->setLongitude($longitude);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($mapEntity);
        $entityManager->flush();

        return new JsonResponse('Location saved successfully', JsonResponse::HTTP_OK);
    }

    #[Route('/show-map', name: 'show_match_map')]
    public function showLocation(EntityManagerInterface $entityManager): Response    
    {
        $mapEntity = $entityManager->getRepository(MapEntity::class)->findOneBy([], ['id' => 'DESC']);

        return $this->render('match_map/show.html.twig', [
            'mapEntity' => $mapEntity,
        ]);
    }
}
