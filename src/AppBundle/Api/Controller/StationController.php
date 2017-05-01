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
 * @Rest\RouteResource("Station")
 * @Rest\NamePrefix("tap_and_go_api_stations_")
 */
class StationController extends FOSRestController {

    /**
     * Returns a paginated list of stations.
     *
     * @ApiDoc(
     *  resource=true,
     *  section="Stations",
     *  description="Get the stations list",
     *  output={"class"="Sonata\StationBundle\Model\StationInterface", "groups"="list"},
     * )
     *
     * @Rest\QueryParam(name="page", requirements="\d+", default="1", description="Page for stations list pagination (1-indexed)")
     * @Rest\QueryParam(name="limit", requirements="\d+", default="10", description="Number of stations by page")
     *
     * @Rest\Get("/stations/{cityId}", name="station-list", options={ "method_prefix" = false })
     * @Rest\View(serializerGroups={"station-list"}, serializerEnableMaxDepthChecks=true)
     *
     * @param ParamFetcherInterface $paramFetcher
     *
     * @return StationInterface[]
     */
    public function getListStationAction(ParamFetcherInterface $paramFetcher, $cityId) {

        $page = $paramFetcher->get('page') - 1;
        $limit = $paramFetcher->get('limit');

        $stationsList = $this->get('doctrine_mongodb')->getManager()->getRepository('AppBundle:Station')->getStationListApi($limit, $page, $cityId);

        //Reformat output
        $stationsListOutput = array();
        foreach ($stationsList as $id => $data) {

            $station = array();
            $station['id'] = $id;
            $station['creationDate'] = $data['creationDate']->toDateTime()->format(\DateTime::ISO8601);
            $station['lastUpdate'] = $data['lastUpdate']->toDateTime()->format(\DateTime::ISO8601);
            $station['name'] = $data['name'];
            $station['address'] = $data['address'];
            $station['description'] = $data['description'];
            $station['latitude'] = $data['coordinates']['latitude'];
            $station['longitude'] = $data['coordinates']['longitude'];
            $station['bikesCapacity'] = $data['bikesCapacity'];
            $station['bikesAvailable'] = $data['bikesAvailable'];

            $stationsListOutput[] = $station;
        }

        return $stationsListOutput;
    }

    /**
     * Get the nearest stations list
     *
     * @ApiDoc(
     *  resource=true,
     *  section="Stations",
     *  description="Get the nearest station list",
     *  output={"class"="Sonata\StationBundle\Model\StationInterface", "groups"="list"},
     * )
     *
     * @Rest\QueryParam(name="lat", description="Latitude", nullable=false)
     * @Rest\QueryParam(name="lng", description="Longitude", nullable=false)
     * @Rest\QueryParam(name="radius", default="10", description="Radius", nullable=false)
     * @Rest\QueryParam(name="limit", requirements="\d+", default="10", description="Number of stations by page")
     *
     * @Rest\Get("/stations-near", name="station-near-list", options={ "method_prefix" = false })
     * @Rest\View(serializerGroups={"station-near-list"}, serializerEnableMaxDepthChecks=true )
     *
     * @param ParamFetcherInterface $paramFetcher
     *
     * @return StationInterface[]
     */
    public function getListStationNearAction(ParamFetcherInterface $paramFetcher) {

        $lat = $paramFetcher->get('lat');
        $lng = $paramFetcher->get('lng');
        $radius = $paramFetcher->get('radius');
        $limit = $paramFetcher->get('limit');

        return $this->get('doctrine_mongodb')->getManager()->getRepository('AppBundle:Station')->getStationListNearApi($lat, $lng, $radius, $limit);
    }

    /**
     * Remove a bike from a station
     *
     * @ApiDoc(
     *  resource=true,
     *  section="Stations",
     *  description="Remove a bike from a station",
     *  output={"class"="Sonata\StationBundle\Model\StationInterface", "groups"="list"},
     * )
     *
     * @Rest\Get("/stations/{stationId}/take", name="station-bike-take", options={ "method_prefix" = false })
     * @Rest\View(serializerGroups={"station-bike-take"}, serializerEnableMaxDepthChecks=true )
     *
     * @param ParamFetcherInterface $paramFetcher
     *
     * @return StationInterface[]
     */
    public function getStationBikeTakeAction(ParamFetcherInterface $paramFetcher, $stationId) {

        $manager = $this->get('doctrine_mongodb')->getManager();

        $stationRepository = $this->get('doctrine_mongodb')->getManager()->getRepository('AppBundle:Station');

        $station = $stationRepository->findOneById($stationId);

        if (is_null($station)) {
            return array('result' => false);
        }

        $bikeAvailable = $station->getBikesAvailable();

        // Remove a bike for the station
        $bikeAvailable = $bikeAvailable - 1;

        if ($bikeAvailable < 0) {
            return array('result' => false);
        } else {
            $station->setBikesAvailable($bikeAvailable);

            $manager->persist($station);
            $manager->flush();

            return array('result' => true);
        }
    }

    /**
     * Add a bike in a station
     *
     * @ApiDoc(
     *  resource=true,
     *  section="Stations",
     *  description="Add a bike in a station",
     *  output={"class"="Sonata\StationBundle\Model\StationInterface", "groups"="list"},
     * )
     *
     * @Rest\Get("/stations/{stationId}/drop", name="station-bike-drop", options={ "method_prefix" = false })
     * @Rest\View(serializerGroups={"station-bike-drop"}, serializerEnableMaxDepthChecks=true )
     *
     * @param ParamFetcherInterface $paramFetcher
     *
     * @return StationInterface[]
     */
    public function getStationBikeDropAction(ParamFetcherInterface $paramFetcher, $stationId) {

        $manager = $this->get('doctrine_mongodb')->getManager();

        $stationRepository = $this->get('doctrine_mongodb')->getManager()->getRepository('AppBundle:Station');

        $station = $stationRepository->findOneById($stationId);

        if (is_null($station)) {
            return array('result' => false);
        }

        $bikeCapacity = $station->getBikesCapacity();
        $bikeAvailable = $station->getBikesAvailable();

        // Add a bike for the station
        $bikeAvailable = $bikeAvailable + 1;

        if ($bikeAvailable > $bikeCapacity) {
            return array('result' => false);
        } else {

            $station->setBikesAvailable($bikeAvailable);

            $manager->persist($station);
            $manager->flush();

            return array('result' => true);
        }
    }

}
