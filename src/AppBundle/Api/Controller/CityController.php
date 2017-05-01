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
     *  section="City",
     *  description="Get the city list",
     *  output={"class"="Sonata\CityBundle\Model\CityInterface", "groups"="list"},
     * )
     *
     * @Rest\QueryParam(name="page", requirements="\d+", default="1", description="Page for cities list pagination (1-indexed)")
     * @Rest\QueryParam(name="limit", requirements="\d+", default="10", description="Number of cities by page")
     *
     * @Rest\Get("/cities", name="list", options={ "method_prefix" = false })
     * @Rest\View(serializerGroups={"city-list"}, serializerEnableMaxDepthChecks=true)
     *
     * @param ParamFetcherInterface $paramFetcher
     *
     * @return CityInterface[]
     */
    public function getListCityAction(ParamFetcherInterface $paramFetcher) {

        $page = $paramFetcher->get('page') - 1;
        $limit = $paramFetcher->get('limit');

        $citiesList = $this->get('doctrine_mongodb')->getManager()->getRepository('AppBundle:City')->getCityListApi($limit, $page);

        //Reformat output
        $citiesListOutput = array();
        foreach ($citiesList as $id => $data) {
            $city = array();
            $city['id'] = $id;
            $city['name'] = $data['name'];
            $city['latitude'] = $data['coordinates']['latitude'];
            $city['longitude'] = $data['coordinates']['longitude'];

            $citiesListOutput[] = $city;
        }

        return $citiesListOutput;
    }

}
