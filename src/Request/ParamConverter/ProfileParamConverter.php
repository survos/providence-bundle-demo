<?php
declare(strict_types=1);

namespace App\Request\ParamConverter;

use App\Entity\Profile;

use Doctrine\Persistence\ManagerRegistry;
use Exception;
use Survos\Providence\Services\ProfileService;
use Survos\Providence\XmlModel\XmlProfile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Sensio\Bundle\FrameworkExtraBundle\Request\ParamConverter\ParamConverterInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

class ProfileParamConverter implements ParamConverterInterface
{
    public function __construct(
        private ProfileService $profileService)
    {
    }

    /**
     * {@inheritdoc}
     *
     * Check, if object supported by our converter
     */
    public function supports(ParamConverter $configuration): bool
    {
        return XmlProfile::class == $configuration->getClass();
    }

    /**
     * {@inheritdoc}
     *
     * Applies converting
     *
     * @throws \InvalidArgumentException When route attributes are missing
     * @throws NotFoundHttpException     When object not found
     * @throws Exception
     */
    public function apply(Request $request, ParamConverter $configuration): bool
    {
        $params = $request->attributes->get('_route_params');

//        if (isset($params['profileId']) && ($profileId = $request->attributes->get('profileId')))

        $profileId = $request->attributes->get('profileId');
        if ($profileId === 'undefined') {
            throw new Exception("Invalid profileId " . $profileId);
        }

        // Check, if route attributes exists
        if (null === $profileId ) {
            if (!isset($params['profileId'])) {
                return false; // no profileId in the route, so leave.  Could throw an exception.
            }
        }

        // Try to find the entity
        if (!$xmlprofile = $this->profileService->getXmlProfile($profileId, true))
        {
            throw new NotFoundHttpException(sprintf('%s %s object not found.', $profileId, $configuration->getClass()));
        }

        // Map found profile to the route's parameter

        $request->attributes->set($configuration->getName(), $xmlprofile);
        return true;
    }

}
