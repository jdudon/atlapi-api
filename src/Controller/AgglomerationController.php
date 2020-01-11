<?php

namespace App\Controller;

use App\Entity\Agglomeration;
use App\Entity\Building;
use App\Entity\Map;
use App\Entity\User;
use App\Repository\AgglomerationRepository;
use App\Repository\MapRepository;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\Annotations\View;
use FOS\RestBundle\Controller\Annotations\Post;
use FOS\RestBundle\Controller\Annotations\Delete;
use FOS\RestBundle\Controller\Annotations\Put;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class AgglomerationController extends AbstractFOSRestController
{

   /**
    * @Get(
    *      path = "/api/agglomerations/{id}",
    *      name = "app_agglomerations_read", 
    *      requirements = {"id"="\d+"}
    * )
    * @View()
    */
   public function readOne(Agglomeration $agglomeration, Map $map, User $user)
   {

      return $agglomeration;
   }

   /**
    * @Get(
    *      path = "/api/agglomerations/",
    *      name = "app_agglomerations_readAll", 
    * )
    * @View()
    * @ParamConverter("user", converter="fos_rest.request_body")
    * @ParamConverter("map", converter="fos_rest.request_body")
    */
   public function readAll(AgglomerationRepository $repo, Map $map, User $user)
   {

      $agglomerations = $repo->findAll();

      return $agglomerations;
   }



   /**
    * @Post(
    *      path = "/api/agglomerations/",
    *      name = "app_agglomerations_create"
    * )
    * @View(StatusCode=201)
    * @ParamConverter("agglomeration", converter="fos_rest.request_body")
    * @ParamConverter("map", class="App\Entity\Map", converter="fos_rest.request_body")
    * @ParamConverter("user", class="App\Entity\User",converter="fos_rest.request_body")
    * 
    */
   public function create(Agglomeration $agglomeration, Map $map, User $user)
   {

      $em = $this->getDoctrine()->getManager();
      $em->persist($agglomeration);
      $em->flush();

      return $this->view($agglomeration, Response::HTTP_CREATED, ['Location' =>
      $this->generateUrl('app_agglomerations_read', ['id' => $agglomeration->getId(), UrlGeneratorInterface::ABSOLUTE_URL])]);
   }

   /**
    * @Delete(
    *          path = "/api/agglomerations/{id}",
    *          name = "app_agglomerations_delete",
    *          requirements = {"id"="\d+"}
    * )
    * 
    * @View(StatusCode=Response::HTTP_NO_CONTENT)
    */
   public function delete(Agglomeration $agglomeration)
   {
      $em = $this->getDoctrine()->getManager();
      $em->remove($agglomeration);
      $em->flush();

      return new Response('', 204);
   }

   /**
    * @Put(
    *      path = "/api/agglomerations/{id}",
    *      name = "app_agglomerations_update",
    *      requirements = {"id"="\d+"}
    * )
    * View(serializerGroups={"Default"})
    * @ParamConverter("agglomeration", converter="fos_rest.request_body")
    * @ParamConverter("map", converter="fos_rest.request_body")
    */
   public function update($id, Map $map, Agglomeration $agglomeration, AgglomerationRepository $repo)
   {

      $oldagglo = $repo->find($id);
      $update = $oldagglo->setName($agglomeration->getName());
      $update = $oldagglo->setSize($agglomeration->getSize());
      $update = $oldagglo->setLeader($agglomeration->getLeader());



      $em = $this->getDoctrine()->getManager();

      $em->persist($update);
      $em->flush();



      return new Response('', 200);
   }
}
