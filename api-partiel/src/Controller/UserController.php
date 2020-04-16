<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractBaseController
{
    private $em;
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * @Route("/register", name="register_one_user")
     */
    public function add_user(Request $request)
    {
        $data = json_decode($request->getContent(), true);
        $user = new User();
        $form = $this->createForm(UserType::class,$user);
        $form->submit($data);

        if($form->isValid()){
            $this->em->persist($user);
            $this->em-> flush();
            return $this->json(
                $user,
                Response::HTTP_CREATED,
                [],
                ["groups" => "user:detail"]
            );
        }
        $errors = $this->getFormErrors($form);
        return $this->json($errors);
    }

}


