<?php

namespace App\Security;

use App\Entity\User;
use Symfony\Component\Security\Core\Exception\BadCredentialsException;
use Symfony\Component\Security\Http\AccessToken\AccessTokenHandlerInterface;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;
class ApiTokenHandler implements AccessTokenHandlerInterface
{

    private string $masterToken = 'EbJg6VsTNqxt6vUgIabS5BvepOqouQLSgmchWyRkYoyclutdRw98KznyM4YnZirl';

    public function getUserBadgeFrom(#[\SensitiveParameter] string $accessToken): UserBadge
    {

        dump($accessToken);

        if ($accessToken === $this->masterToken) {
            return new UserBadge($accessToken, fn ($token) => new User(email: 'andreas@lagocki.de', roles: ['ROLE_ADMIN']));
        }

        throw new BadCredentialsException();

    }
}