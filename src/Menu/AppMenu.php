<?php

namespace App\Menu;

use Survos\Providence\Services\ProfileService;
use Twig\Environment;
use Umbrella\AdminBundle\Menu\BaseAdminMenu;
use Umbrella\AdminBundle\UmbrellaAdminConfiguration;
use Umbrella\CoreBundle\Menu\Builder\MenuBuilder;
use Umbrella\CoreBundle\Menu\DTO\Breadcrumb;
use Umbrella\CoreBundle\Menu\DTO\Menu;
use Umbrella\CoreBundle\Menu\MenuType;

class AppMenu extends BaseAdminMenu
{
    public function __construct(private ProfileService $profileService, Environment $twig, UmbrellaAdminConfiguration $configuration)
    {
        parent::__construct($twig, $configuration);
        $this->twig = $twig;
        $this->configuration = $configuration;
    }

    /**
     * {@inheritDoc}
     */
    public function buildMenu(MenuBuilder $builder, array $options)
    {
        $root = $builder->root();

        // Create a new entry with route
        $root->add('welcome')
            ->icon('uil-home') // Icon of entry
            ->route('app_homepage'); // Route of entry

        // Create a new entry with url
        $root->add('ca')
            ->icon('mdi mdi-google') // Icon of entry
            ->url('https://www.collectiveaccess.org/'); // Url of entry

        // Create a nested entry

        $x = $root->add('app')
            ->icon('uil-apps');
        foreach ($this->profileService->getXmlProfiles() as $xmlProfile) {
            $x
                ->add($xmlProfile->getProfileId())
                ->route('profile_dashboard', $xmlProfile->getrp())
                ->end();
        }
    }

    /**
     * {@inheritDoc}
     */
//    public function renderMenu(Menu $menu, array $options): string
//    {
//        return parent::renderMenu($menu, $options);
//        // render menu using twig template for example
//    }
//
//    /**
//     * {@inheritDoc}
//     */
//    public function renderBreadcrumb(Breadcrumb $breadcrumb, array $options): string
//    {
//        return parent::renderBreadcrumb($breadcrumb, $options);
//        // render breadcrumb using twig template for example
//    }
}
