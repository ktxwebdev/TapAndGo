<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use AppBundle\Document\Station;
use AppBundle\Form\StationType;

/**
 * Station controller.
 *
 * @Route("/city/{id}/station")
 */
class StationController extends Controller {

    /**
     * Displays a form to create a new Station document.
     *
     * @Route("/new", name="city_id_station_new")
     * @Template()
     *
     * @return array
     */
    public function newAction($id) {
        $document = new Station();
        $form = $this->createForm(StationType::class, $document);

        $dm = $this->getDocumentManager();
        $city = $dm->getRepository('AppBundle:City')->find($id);

        return array(
            'city' => $city,
            'document' => $document,
            'form' => $form->createView()
        );
    }

    /**
     * Creates a new Station document.
     *
     * @Route("/create", name="city_id_station_create")
     * @Method("POST")
     * @Template("AppBundle:Station:new.html.twig")
     *
     * @param Request $request
     *
     * @return array
     */
    public function createAction(Request $request, $id) {
        $document = new Station();
        $form = $this->createForm(StationType::class, $document);
        $form->bind($request);

        if ($form->isValid()) {
            $dm = $this->getDocumentManager();

            $city = $dm->getRepository('AppBundle:City')->find($id);
            $city->addStation($document);

            $dm->persist($document);
            $dm->persist($city);
            $dm->flush();

            return $this->redirect($this->generateUrl('city_show', array('id' => $id)));
        }

        return array(
            'document' => $document,
            'form' => $form->createView()
        );
    }

    /**
     * Finds and displays a Station document.
     *
     * @Route("/{idStation}/show", name="city_id_station_show")
     * @Template()
     *
     * @param string $id The document ID
     *
     * @return array
     *
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException If document doesn't exists
     */
    public function showAction($id, $idStation) {
        $dm = $this->getDocumentManager();

        $document = $dm->getRepository('AppBundle:Station')->find($idStation);

        if (!$document) {
            throw $this->createNotFoundException('Unable to find Station document.');
        }

        $deleteForm = $this->createDeleteForm($idStation);

        return array(
            'idCity' => $id,
            'document' => $document,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Station document.
     *
     * @Route("/{idStation}/edit", name="city_id_station_edit")
     * @Template()
     *
     * @param string $id The document ID
     *
     * @return array
     *
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException If document doesn't exists
     */
    public function editAction($id, $idStation) {
        $dm = $this->getDocumentManager();

        $document = $dm->getRepository('AppBundle:Station')->find($idStation);

        if (!$document) {
            throw $this->createNotFoundException('Unable to find Station document.');
        }

        $editForm = $this->createForm(StationType::class, $document);
        $deleteForm = $this->createDeleteForm($idStation);

        $city = $dm->getRepository('AppBundle:City')->find($id);

        return array(
            'city' => $city,
            'document' => $document,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing Station document.
     *
     * @Route("/{idStation}/update", name="city_id_station_update")
     * @Method("POST")
     * @Template("AppBundle:Station:edit.html.twig")
     *
     * @param Request $request The request object
     * @param string $id       The document ID
     *
     * @return array
     *
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException If document doesn't exists
     */
    public function updateAction(Request $request, $id, $idStation) {
        $dm = $this->getDocumentManager();

        $document = $dm->getRepository('AppBundle:Station')->find($idStation);

        if (!$document) {
            throw $this->createNotFoundException('Unable to find Station document.');
        }

        $deleteForm = $this->createDeleteForm($idStation);
        $editForm = $this->createForm(StationType::class, $document);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $dm->persist($document);
            $dm->flush();

            return $this->redirect($this->generateUrl('city_id_station_edit', array('id' => $id, 'idStation' => $idStation)));
        }

        return array(
            'document' => $document,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Station document.
     *
     * @Route("/{idStation}/delete", name="city_id_station_delete")
     * @Method("POST")
     *
     * @param Request $request The request object
     * @param string $id       The document ID
     *
     * @return array
     *
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException If document doesn't exists
     */
    public function deleteAction(Request $request, $id, $idStation) {
        $form = $this->createDeleteForm($idStation);
        $form->bind($request);

        if ($form->isValid()) {
            $dm = $this->getDocumentManager();
            $document = $dm->getRepository('AppBundle:Station')->find($idStation);

            if (!$document) {
                throw $this->createNotFoundException('Unable to find Station document.');
            }

            $city = $dm->getRepository('AppBundle:City')->find($id);

            $city->removeStation($document);

            $dm->persist($city);
            $dm->remove($document);
            $dm->flush();
        }

        return $this->redirect($this->generateUrl('city_show', array('id' => $id)));
    }

    private function createDeleteForm($idStation) {
        return $this->createFormBuilder(array('id' => $idStation))
                        ->add('id', 'hidden')
                        ->getForm()
        ;
    }

    /**
     * Returns the DocumentManager
     *
     * @return DocumentManager
     */
    private function getDocumentManager() {
        return $this->get('doctrine.odm.mongodb.document_manager');
    }

}
