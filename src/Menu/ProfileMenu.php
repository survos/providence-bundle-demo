<?php

namespace App\Menu;

use Symfony\Component\PropertyAccess\PropertyAccessor;
use Umbrella\AdminBundle\Menu\BaseAdminMenu;
use Umbrella\CoreBundle\Menu\Builder\MenuBuilder;
use Umbrella\CoreBundle\Menu\DTO\Breadcrumb;
use Umbrella\CoreBundle\Menu\DTO\Menu;
use Umbrella\CoreBundle\Menu\MenuType;

class ProfileMenu extends BaseAdminMenu
{
    /**
     * {@inheritDoc}
     */
    public function buildMenu(MenuBuilder $builder, array $options)
    {
        $root = $builder->root();
        $xmlProfile = $options['xmlProfile'];
        $propertyAccessor = new PropertyAccessor();
        $root->add('dashboard')
            ->route('profile_dashboard', $xmlProfile->getRp());

        foreach (['mde','list','ui','display'] as $prefix) {
            $root->add($prefix)
                ->badge($propertyAccessor->getValue($xmlProfile, $prefix . 'Count'))
                ->route('profile_show', $xmlProfile->getRp(['section'  => $prefix]))
            ; // Route of entry
        }

        $root->add('home')->route('app_homepage');


    }

}
