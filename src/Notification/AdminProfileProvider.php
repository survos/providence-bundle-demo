<?php

namespace App\Notification;

use App\Entity\AdminNotification;
use Doctrine\ORM\EntityManagerInterface;
use Survos\Providence\Services\ProfileService;
use Symfony\Component\Security\Core\Security;
use Umbrella\AdminBundle\Notification\BaseNotificationProvider;

class AdminProfileProvider extends BaseNotificationProvider
{
    public function __construct(
        private ProfileService $profileService,
        private EntityManagerInterface $em,
        private Security $security)
    {
    }

    public function collect(): iterable
    {
        return $this->profileService->getProfileFiles();
    }
}
