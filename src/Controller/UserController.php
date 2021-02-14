<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Session\Session;




   /**
    * @IsGranted("IS_AUTHENTICATED_FULLY")
    */
class UserController extends AbstractController
{
    /**
     * @Route("/", name="user")
     */
    public function index(UserRepository $userRepository, Request $request): Response
    {
        return $this->render('user/index.html.twig', [
            'controller_name' => 'UserController',
            'users' => $userRepository->findAll(),
        ]);
    }

    /**
     * @Route("/user/delete-selected", name="delete_selected_users")
     */
    public function deleteCheckedUsers(Request $request, UserRepository $userRepository)
    {
      self::doAction($request, $userRepository, 'delete');
      return $this->redirectToRoute('index');
    }

    /**
      * @Route("/user/block-selected", name="block_selected_users")
      */
    public function blockCheckedUsers(Request $request, UserRepository $userRepository)
    {
      self::doAction($request, $userRepository, 'block');
      return $this->redirectToRoute('index');
    }

    /**
      * @Route("/user/unblock-selected", name="unblock_selected_users")
      */
    public function unblockCheckedUsers(Request $request, UserRepository $userRepository)
    {
      self::doAction($request, $userRepository, 'unblock');
      return $this->redirectToRoute('index');
    }

    public function doAction(Request $request, UserRepository $userRepository, string $method){
      $userIds = $request->request->get('checkboxes');
      $currentUserId = $this->getUser()->getId();
      foreach($userIds as $id){
        $user = $userRepository->find($id);
        self::defineAction($method, $user);
        $this->getDoctrine()->getManager()->flush();
        self::invalidateSession($currentUserId, $id);
      }
    }

    public function defineAction(string $method, $user){
      if ($method == 'delete'){
        $this->getDoctrine()->getManager()->remove($user);
      } else if ($method == 'block'){
        $user->setStatus('blocked');
      } else if ($method == 'unblock'){
        $user->setStatus('active');
      }
    }

    public function invalidateSession(int $currentUserId, int $id){
      if ($currentUserId == $id)
        {
          $session = $this->get('session');
          $session = new Session();
          $session->invalidate();
        }
    }
}
