<?php

namespace App\Controller;

use App\Entity\Map;
use App\Entity\User;
use App\Repository\MapRepository;
use Doctrine\ORM\EntityManager;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\Annotations\View;
use FOS\RestBundle\Controller\Annotations\Post;
use FOS\RestBundle\Controller\Annotations\Delete;
use FOS\RestBundle\Controller\Annotations\Put;
use JMS\Serializer\SerializerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Validator\ConstraintViolationList;

class MapController extends AbstractFOSRestController
{

    /**
     * @Get(
     *      path = "/api/maps/{id}",
     *      name = "app_maps_read", 
     *      requirements = {"id"="\d+"}
     * )
     * @View()
     */
    public function readOne(Map $map, User $user)
    {

        return $map;
    }

    /**
     * @Get(
     *      path = "/api/maps/",
     *      name = "app_maps_read", 
     *      requirements = {"id"="\d+"}
     * )
     * @View()
     * @ParamConverter("user", converter="fos_rest.request_body")
     * 
     */
    public function readAll(MapRepository $repo, User $user)
    {

        $maps = $repo->findAll();

        return $maps;
    }



    /**
     * @Post(
     *      path = "/api/maps/",
     *      name = "app_maps_create"
     * )
     * @View(StatusCode=201)
     * @ParamConverter("map", converter="fos_rest.request_body")
     * @ParamConverter("user", converter="fos_rest.request_body")
     * 
     */
    public function createMap(Map $map, User $user)
    {

        $em = $this->getDoctrine()->getManager();
        $em->persist($map);
        $em->flush();
        return $this->view($map, Response::HTTP_CREATED, ['Location' =>
        $this->generateUrl('app_maps_read', ['id' => $map->getId(), UrlGeneratorInterface::ABSOLUTE_URL])]);
    }

    /**
     * @Delete(
     *          path = "/api/maps/{id}",
     *          name = "app_maps_delete",
     *          requirements = {"id"="\d+"}
     * )
     * 
     * @View(StatusCode=Response::HTTP_NO_CONTENT)
     */
    public function delete(Map $map)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($map);
        $em->flush();

        return new Response('', 204);
    }

    /**
     * @Put(
     *      path = "/api/maps/{id}",
     *      name = "app_maps_update",
     *      requirements = {"id"="\d+"}
     * )
     * View(serializerGroups={"Default"})
     * @ParamConverter("map", converter="fos_rest.request_body")
     * @ParamConverter("user", converter="fos_rest.request_body")
     * 
     */
    public function update($id, Map $map, User $user, Request $req, MapRepository $repo)
    {

        $oldmap = $repo->find($id);
        $update = $oldmap->setName($map->getName());
        $update = $oldmap->setBiomes($map->getBiomes());
        $update = $oldmap->setUniverseType($map->getUniverseType());
        $update = $oldmap->setInterestPoints($map->getInterestPoints());



        $em = $this->getDoctrine()->getManager();

        $em->persist($update);
        $em->flush();



        return new Response('', 200);
    }
}
