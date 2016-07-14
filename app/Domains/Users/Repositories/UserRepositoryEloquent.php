<?php

namespace App\Domains\Users\Repositories;

use App\Domains\Users\User;
use App\Domains\Users\Repositories;
use Prettus\Repository\Eloquent\BaseRepository;

class UserRepositoryEloquent extends BaseRepository implements UserRepositoryInterface
{
    /**
     * Register the model
     */
    public function model()
    {
        return User::class;
    }

}