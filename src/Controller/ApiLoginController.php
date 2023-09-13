<?php
/*
 * Andreas Lagocki - Photographer
 *
 * Copyright (C) Andreas Lagocki  - All Rights Reserved
 * Unauthorized copying of this file, via any medium is strictly
 *  prohibited Proprietary and confidential.
 *
 * @author Andreas Lagocki <andreas@lagocki.de>
 */

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\User;
use Symfony\Component\Security\Http\Attribute\CurrentUser;

// https://symfony.com/doc/current/security.html JSON Login
class ApiLoginController extends AbstractController
{
    #[Route('/api/login', name: 'api_login')]
    public function index(#[CurrentUser] ?User $user): Response
    {

        if (null === $user) {
            return $this->json([
                'message' => 'missing credentials',
                ], Response::HTTP_UNAUTHENTICATED);
        }

        $token = ''; // somehow create an API token for $user

        return $this->json([
            'user'  => $user->getUserIdentifier(),
            'token' => $token,
        ]);
    }
}
