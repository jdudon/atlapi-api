<?php

namespace App\Controller;

use App\Entity\Agglomeration;
use App\Entity\Building;
use App\Entity\Map;
use App\Entity\User;
use App\Repository\BuildingRepository;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\Annotations\View;
use FOS\RestBundle\Controller\Annotations\Post;
use FOS\RestBundle\Controller\Annotations\Delete;
use FOS\RestBundle\Controller\Annotations\Put;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class BuildingController extends AbstractFOSRestController
{

   /**
    * @Get(
    *      path = "/api/buildings/{id}",
    *      name = "app_buildings_read", 
    *      requirements = {"id"="\d+"}
    * )
    * @View()
    */
   public function readOne(Building $building, Agglomeration $agglomeration, User $user)
   {

      return $building;
   }

   /**
    * @Get(
    *      path = "/api//buildings/",
    *      name = "app_buildings_readAll", 
    * )
    * @View()
    * @ParamConverter("user", converter="fos_rest.request_body")
    * @ParamConverter("agglomerations", converter="fos_rest.request_body")
    */
   public function readAll(BuildingRepository $repo, Agglomeration $agglomeration, User $user)
   {

      $buildings = $repo->findAll();

      return $buildings;
   }



   /**
    * @Post(
    *      path = "/api/buildings/",
    *      name = "app_buildings_create"
    * )
    * @View(StatusCode=201)
    * @ParamConverter("building", converter="fos_rest.request_body")
    * @ParamConverter("agglomeration", class="App\Entity\Agglomeration", converter="fos_rest.request_body")
    * @ParamConverter("map", class="App\Entity\Map", converter="fos_rest.request_body")
    * @ParamConverter("user", class="App\Entity\User",converter="fos_rest.request_body")
    * 
    */
   public function create(Building $building,Agglomeration $agglomeration, Map $map, User $user)
   {

      $em = $this->getDoctrine()->getManager();
      $em->persist($building);
      $em->flush();

      return $this->view($building, Response::HTTP_CREATED, ['Location' =>
      $this->generateUrl('app_buildings_read', ['id' => $building->getId(), UrlGeneratorInterface::ABSOLUTE_URL])]);
   }

   /**
    * @Delete(
    *          path = "/api/buildings/{id}",
    *          name = "app_buildings_delete",
    *          requirements = {"id"="\d+"}
    * )
    * 
    * @View(StatusCode=Response::HTTP_NO_CONTENT)
    */
   public function delete(Building $building)
   {
      $em = $this->getDoctrine()->getManager();
      $em->remove($building);
      $em->flush();

      return new Response('', 204);
   }

   /**
    * @Put(
    *      path = "/api/buildings/{id}",
    *      name = "app_buildings_update",
    *      requirements = {"id"="\d+"}
    * )
    * View(serializerGroups={"Default"})
    * @ParamConverter("building", converter="fos_rest.request_body")
    * @ParamConverter("agglomeration", converter="fos_rest.request_body")
    */
   public function update($id, Building $building, Agglomeration $agglomeration, BuildingRepository $repo)
   {

      $oldbuilding = $repo->find($id);
      $update = $oldbuilding->setName($building->getName());
      $update = $oldbuilding->setSize($building->getSize());
      $update = $oldbuilding->setFunction($building->getFunction());
      $update = $oldbuilding->setLeader($building->getLeader());



      $em = $this->getDoctrine()->getManager();

      $em->persist($update);
      $em->flush();



      return new Response('', 200);
   }
}
