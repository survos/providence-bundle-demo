<?php

namespace App\Controller;

use App\Entity\Profile;
use Survos\Providence\Services\ProfileService;
use Survos\Providence\XmlModel\ProfileSetting;
use Survos\Providence\XmlModel\XmlProfile;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/profile/{profileId}')]
class ProfileController extends AbstractController
{
    public function __construct(private ProfileService $profileService) {

    }

    #[Route('/dashboard', name: 'profile_dashboard')]
    public function show(XmlProfile $xmlProfile): Response
    {
        return $this->render('profile/dashboard.html.twig', [
            'xmlProfile' => $xmlProfile
        ]);
    }

    #[Route('/labels', name: 'profile_labels')]
    public function labels(XmlProfile $xmlProfile): Response
    {
        $labels = $this->profileService->loadLabelsFromXml($xmlProfile);

        return $this->render('profile/labels.html.twig', [
            'xmlProfile' => $xmlProfile,
            'labels' => $labels,
        ]);
    }

    #[Route('/show/{section}', name: 'profile_show')]
    public function property(XmlProfile $xmlProfile, string $section): Response
    {
        $data = match ($section) {
            'ui' => $xmlProfile->getUserInterfaces(),
            'mde' => $xmlProfile->getElements(),
            'list' => $xmlProfile->getLists(),
            'relationshipTypes' => $xmlProfile->getRelationshipTypes(),
            'sets' => $xmlProfile->getElementSets()
        };

        $columns = match($section) {
            'relationshipTypes' => [
                'relationshipTypeName',
                'relationshipTypes',
//                'dump'
                ],
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
