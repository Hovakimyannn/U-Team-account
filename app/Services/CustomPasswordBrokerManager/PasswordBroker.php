<?php

namespace App\Services\CustomPasswordBrokerManager;

use App\Repositories\ResetPasswordRepository;
use Illuminate\Auth\Passwords\PasswordBroker as PassBroker;
use Illuminate\Auth\Passwords\TokenRepositoryInterface;
use Illuminate\Contracts\Auth\UserProvider;
use Illuminate\Database\Eloquent\Model;

class PasswordBroker extends PassBroker
{
    /**
     * @var \App\Repositories\ResetPasswordRepository
     */
    protected ResetPasswordRepository $resetPasswordRepository;

    /**
     * @param \Illuminate\Auth\Passwords\TokenRepositoryInterface $tokens
     * @param \Illuminate\Contracts\Auth\UserProvider             $users
     * @param \App\Repositories\ResetPasswordRepository           $resetPasswordRepository
     */
    public function __construct(TokenRepositoryInterface $tokens, UserProvider $users, ResetPasswordRepository $resetPasswordRepository)
    {
        $this->resetPasswordRepository = $resetPasswordRepository;
        parent::__construct($tokens, $users);
    }

    /**
     * @param array $credentials
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function getUser(array $credentials) : ?Model
    {
        return $this->resetPasswordRepository->findModelByEmail($credentials['email']);
    }
}