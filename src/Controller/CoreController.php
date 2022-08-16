<?php

namespace App\Controller;

use Survos\Providence\Model\Core;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/core/{coreId}')]
class CoreController extends AbstractController
{
    #[Route('/show', name: 'core_show')]
    public function show(Core $core): Response
    {
        return $this->render('core/show.html.twig', [
            'core' => $core
        ]);
    }
}
