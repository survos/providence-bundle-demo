<?php

namespace App\Controller;

use Survos\Providence\Services\ProfileService;
use Survos\Providence\XmlModel\XmlProfile;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;

class AppController extends AbstractController
{
    #[Route('/', name: 'app_homepage')]
    public function index(ProfileService $profileService): Response
    {
        $profiles = $profileService->getXmlProfiles();
        return $this->render('app/index.html.twig', [
            'profiles' => $profiles
        ]);
    }

    #[Route('/dropdown', name: 'umbrella_admin_notification_list')]
    public function dropdown(XmlProfile $xmlProfile,
                             Environment $twig,
                             ProfileService $profileService): Response
    {

        $notifications = $profileService->getProfileFiles();

        if (0 === count($notifications)) {
            return new JsonResponse([
                'count' => 0,
                'html' => $this->renderView('@UmbrellaAdmin/Notification/empty.html.twig')
            ]);
        }

        $notificationData = [];
        foreach ($notifications as $notification) {
            $notificationData[] = [
                'html' =>
                    $this->renderView("profile/_dropdown_item.html.twig", ['xmlProfile' => $notification])
            ];
        }

        return new JsonResponse([
            'count' => count($notifications),
            'notifications' => $notificationData
        ]);

    }

}
