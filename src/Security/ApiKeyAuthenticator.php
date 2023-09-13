<?php

namespace App\Security;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;
use Symfony\Component\Security\Http\Authenticator\AbstractAuthenticator;
use Symfony\Component\Security\Http\Authenticator\Passport\Passport;

class ApiKeyAuthenticator extends AbstractAuthenticator
{
    private string $masterToken = 'EbJg6VsTNqxt6vUgIabS5BvepOqouQLSgmchWyRkYoyclutdRw98KznyM4YnZirl';

    public function supports(Request $request): ?bool
    {
        return $request->headers->has('X-AUTH-TOKEN');
    }

    public function authenticate(Request $request): Passport
    {
        if (null === ($apiToken = $request->headers->get('X-AUTH-TOKEN'))) {
            throw new CustomUserMessageAuthenticationException('No API token provided');
        }

        if ($this->masterToken === $apiToken) {
            return new SelfValidatingPassport(
                new UserBadge($apiToken, fn ($token) => new BaseUser(email: 'apiuser@bridge', roles: ['ROLE_API'], active: true))
            );
        }

        throw new CustomUserMessageAuthenticationException('Wrong API token provided');
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $firewallName): ?Response
    {
        return null;
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception): ?Response
    {
        $data = [
            'message' => strtr($exception->getMessageKey(), $exception->getMessageData()).$exception->getMessage(),
        ];

        return new JsonResponse($data, Response::HTTP_UNAUTHORIZED);
    }
}