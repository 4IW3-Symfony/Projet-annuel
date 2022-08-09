<?php 

namespace App\Verification;

use DateTime;
use App\Entity\User;
use Symfony\Component\HttpFoundation\File\Exception\AccessDeniedException;

class VerificationAccess
{

    public function Verification_edit_moto($moto_id,$utilisateur){
        
        /** @var User $user */
        $user = $utilisateur->getRoles();
        if($user[0] == "ROLE_USER"){
            if($moto_id != $utilisateur->getId())
            {
                dump($utilisateur->getId());
                dump($moto_id);
                throw new AccessDeniedException("Vous n'avez pas l'acces!!!");
            }
            else{
                return "" ;
            }
        }
        else{
            return "";
        }

        
        

    }

    function isValid($date, $format = 'Y-m-d'){
        $dt = DateTime::createFromFormat($format, $date);
        if ($dt && $dt->format($format) === $date)
        {
            return "";
        }
        else{
            throw $this->createNotFoundException("Date non valide!!!");
        }
      }
}

?>