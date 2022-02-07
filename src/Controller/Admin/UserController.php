<?php 
namespace App\Controller\Admin;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;



#[Route('admin/user')]
class UserController extends AbstractController{

    #[Route('/', name: 'user_index')]
    public function index(UserRepository $user) :Response { 
        return $this->render('admin/user/index.html.twig', [
            'users' => $user->findAll(),
        ]);

    }
}


?>
