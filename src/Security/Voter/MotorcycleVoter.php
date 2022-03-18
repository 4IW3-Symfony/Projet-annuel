<?php

namespace App\Security\Voter;

use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Security;
use App\Entity\Motorcycle;
use App\Entity\User;

class MotorcycleVoter extends Voter
{
    const VIEW = 'view';
    const EDIT = 'edit';
    const DELETE = 'delete';
    
    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }
    protected function supports(string $attribute, $subject): bool
    {
        return in_array($attribute, [self::EDIT, self::VIEW, self::DELETE])
            && $subject instanceof \App\Entity\Motorcycle;
    }

    protected function voteOnAttribute(string $attribute, $subject, TokenInterface $token): bool
    {
        $user = $token->getUser();
        // if the user is anonymous, do not grant access
        if (!$user instanceof UserInterface) {
            return false;
        }

        $motorcycle = $subject;
        // ... (check conditions and return true to grant permission) ...
        switch ($attribute) {
            case self::VIEW:
                return $this->canView($motorcycle, $user);
            case self::EDIT:
                return $this->canEdit($motorcycle, $user);
            case self::DELETE:
                return $this->canDelete($motorcycle, $user);
        }

        throw new \LogicException('This code should not be reached!');
    }

    private function canView(Motorcycle $motorcycle, User $user): bool
    {
        // if they can edit, they can view
        if ($this->canEdit($motorcycle, $user)) {
            return true;
        }
    }

    private function canEdit(Motorcycle $motorcycle, User $user): bool
    {
        return $user === $motorcycle->getUser();
    }

    private function canDelete(Motorcycle $motorcycle, User $user): bool
    {
        if($user === $motorcycle->getUser() || $this->security->isGranted('ROLE_ADMIN')) {
            return true;
        }
        return false;
    }
}
