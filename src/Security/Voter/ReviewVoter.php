<?php

namespace App\Security\Voter;

use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Security;
use App\Entity\Review;
use App\Entity\User;

class ReviewVoter extends Voter
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
        // replace with your own logic
        // https://symfony.com/doc/current/security/voters.html
        return in_array($attribute, [self::EDIT, self::VIEW, self::DELETE])
            && $subject instanceof \App\Entity\Review;
    }

    protected function voteOnAttribute(string $attribute, $subject, TokenInterface $token): bool
    {
        $user = $token->getUser();
        // if the user is anonymous, do not grant access
        if (!$user instanceof UserInterface) {
            return false;
        }

        $review = $subject;
        // ... (check conditions and return true to grant permission) ...
        switch ($attribute) {
            case self::VIEW:
                return $this->canView($review, $user);
            case self::EDIT:
                return $this->canEdit($review, $user);
            case self::DELETE:
                return $this->canDelete($review, $user);
        }

        throw new \LogicException('This code should not be reached!');
    }

    private function canView(Review $review, User $user): bool
    {
        // if they can edit, they can view
        if ($this->canEdit($review, $user)) {
            return true;
        }
    }

    private function canEdit(Review $review, User $user): bool
    {
        return $user === $review->getCustomer();
    }

    private function canDelete(Review $review, User $user): bool
    {
        if($user === $review->getCustomer() || $this->security->isGranted('ROLE_ADMIN')) {
            return true;
        }
        return false;
    }
}
