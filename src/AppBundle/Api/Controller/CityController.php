<?php

namespace AppBundle\Api\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Request\ParamFetcherInterface;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * @Rest\RouteResource("City")
 * @Rest\NamePrefix("tap_and_go_api_cities_")
 */
class CityController extends FOSRestController {

    /**
     * Returns a paginated list of cities.
     *
     * @ApiDoc(
     *  resource=true,
     *  section="Citys",
     *  description="Get the city list",
     *  output={"class"="Sonata\CityBundle\Model\CityInterface", "groups"="list"},
     * )
     *
     * @Rest\QueryParam(name="page", requirements="\d+", default="1", description="Page for cities list pagination (1-indexed)")
     * @Rest\QueryParam(name="count", requirements="\d+", default="10", description="Number of cities by page")
     * @Rest\QueryParam(name="orderBy", map=true, requirements="ASC|DESC", nullable=true, strict=true, default="",description="Query cities order by clause (key is field, value is direction")
     * @Rest\QueryParam(name="Name", nullable=true, description="Name")
     *
     * @Rest\Get("/cities/", name="list", options={ "method_prefix" = false })
     * @Rest\View(serializerGroups={"city-list"}, serializerEnableMaxDepthChecks=true)
     *
     * @param ParamFetcherInterface $paramFetcher
     *
     * @return CityInterface[]
     */
    public function getListCityAction(ParamFetcherInterface $paramFetcher) {
        $supportedFilters = array(
            'name' => '',
        );

        $page = $paramFetcher->get('page') - 1;
        $count = $paramFetcher->get('count');
        $orderBy = $paramFetcher->get('orderBy');

        if (isset($orderBy[0]) || ($orderBy == "")) {
            $orderBy = array('dateCreation' => 'DESC');
        }

        $filters = array_intersect_key($paramFetcher->all(), $supportedFilters);

        foreach ($filters as $key => $value) {
            if (null === $value || (is_array($value) && empty($value))) {
                unset($filters[$key]);
            }
        }

        return $this->getDoctrine()->getManager()->getRepository('AppBundle:City')->getCityListApi($filters, $orderBy, $count, $page);
    }

}
