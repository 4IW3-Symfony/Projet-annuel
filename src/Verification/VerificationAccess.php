<?php 

namespace App\Verification;

use DateTime;
use App\Entity\User;

class VerificationAccess
{

    public function Verification_edit_moto($moto_id,$utilisateur){
        
        /** @var User $user */
        $user = $utilisateur->getRoles();
        if($user[0] == "ROLE_USER"){
            if($moto_id != $utilisateur->getId())
            {
                throw $this->createNotFoundException("Vous n'avez pas l'acces!!!");
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