<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\Annotations\View;
use FOS\RestBundle\Controller\Annotations\Post;
use FOS\RestBundle\Controller\Annotations\Put;
use FOS\RestBundle\Controller\Annotations\Delete;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserController extends AbstractFOSRestController
{


   /**
    * @Get(
    *      path = "/api/users/{id}",
    *      name = "app_users_read", 
    *      requirements = {"id"="\d+"}
    * )
    * @View()
    */
   public function readOne(User $user)
   {
      return $user;
   }

   /**
    * @Get(
    *      path = "/api/users/",
    *      name = "app_users_read", 
    *      requirements = {"id"="\d+"}
    * )
    * @View()
    * @ParamConverter("user", converter="fos_rest.request_body")
    * 
    */
   public function readAll(UserRepository $repo, User $user)
   {

      $users = $repo->findAll();

      return $users;
   }

   /**
    * @Post(
    *      path = "/api/users/",
    *      name = "app_users_create"
    * )
    * @View(StatusCode=201)
    * @ParamConverter("user", converter="fos_rest.request_body")
    * 
    */
   public function create(User $user, UserPasswordEncoderInterface $encoder)
   {

      $em = $this->getDoctrine()->getManager();
      $user->setPassword($encoder->encodePassword($user, $user->getPassword()));
      $em->persist($user);
      $em->flush();
      return $this->view($user, Response::HTTP_CREATED, ['Location' =>
      $this->generateUrl('app_users_read', ['id' => $user->getId(), UrlGeneratorInterface::ABSOLUTE_URL])]);
   }

   /**
    * @Put(
    *      path = "/api/users/{id}",
    *      name = "app_users_update",
    *      requirements = {"id"="\d+"}
    * )
    * View(serializerGroups={"Default"})
    * @ParamConverter("user", converter="fos_rest.request_body")
    */
   public function update($id, User $user, UserRepository $repo, UserPasswordEncoderInterface $encoder)
   {

      $olduser = $repo->find($id);
      $update = $olduser->setUsername($user->getUsername());
      $update = $olduser->setPassword($encoder->encodePassword($user,$user->getPassword()));
      $update = $olduser->setEmail($user->getEmail());



      $em = $this->getDoctrine()->getManager();

      $em->persist($update);
      $em->flush();



      return new Response('', 200);
   }

   /**
    * @Delete(
    *          path = "/api/users/{id}",
    *          name = "app_users_delete",
    *          requirements = {"id"="\d+"}
    * )
    * 
    * @View(StatusCode=Response::HTTP_NO_CONTENT)
    */
    public function delete(User $user)
    {
       $em = $this->getDoctrine()->getManager();
       $em->remove($user);
       $em->flush();
 
       return new Response('', 204);
    }
}
