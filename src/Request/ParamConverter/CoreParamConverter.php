<?php
declare(strict_types=1);

namespace App\Request\ParamConverter;

use Exception;
use Survos\Providence\Model\Core;
use Survos\Providence\Services\ProfileService;
use Survos\Providence\XmlModel\XmlProfile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Sensio\Bundle\FrameworkExtraBundle\Request\ParamConverter\ParamConverterInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

class CoreParamConverter implements ParamConverterInterface
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
        return Core::class == $configuration->getClass();
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

//        if (isset($params['coreId']) && ($coreId = $request->attributes->get('coreId')))

        $coreId = $request->attributes->get('coreId');
        if ($coreId === 'undefined') {
            throw new Exception("Invalid coreId " . $coreId);
        }

        // Check, if route attributes exists
        if (null === $coreId ) {
            if (!isset($params['coreId'])) {
                return false; // no coreId in the route, so leave.  Could throw an exception.
            }
        }

        // Try to find the entity
        if (!$core = $this->profileService->getCore($coreId, true))
        {
            throw new NotFoundHttpException(sprintf('%s %s object not found.', $coreId, $configuration->getClass()));
        }

        // Map found core to the route's parameter

        $request->attributes->set($configuration->getName(), $core);
        return true;
    }

}
