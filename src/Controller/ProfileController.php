<?php

namespace App\Controller;

use App\Entity\Profile;
use Survos\Providence\XmlModel\XmlProfile;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/profile/{profileId}')]
class ProfileController extends AbstractController
{

    #[Route('/dashboard', name: 'profile_dashboard')]
    public function show(XmlProfile $xmlProfile): Response
    {
        return $this->render('profile/dashboard.html.twig', [
            'xmlProfile' => $xmlProfile
        ]);
    }

    #[Route('/show/{section}', name: 'profile_show')]
    public function property(XmlProfile $xmlProfile, string $section): Response
    {
        $data = match ($section) {
            'ui' => $xmlProfile->getUserInterfaces(),
            'mde' => $xmlProfile->getElements(),
            'list' => $xmlProfile->getLists(),
            'sets' => $xmlProfile->getElementSets()
        };

        $columns = match($section) {
            'mde' => [
                'code',
                'datatype',
                'labels',
                'restrictions',
            ],
            'list' => [
                'hierarchical',
                'vocabulary',
                'system',
//                'dump',
                'code',
                'labels',
                'items'

            ],
            'ui' => [
                'type',
                'code',
                'labels',
                'screens',

                'dump'
            ]
        };
        return $this->render('profile/show.html.twig', [
            'xmlProfile' => $xmlProfile,
            'property' => $section,
            'data' => $data,
            'columns' => $columns
        ]);
    }
}
