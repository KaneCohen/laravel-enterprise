<?php
namespace App\Domain\User\Repositories;

use App\Domain\User\Models\User;
use App\Infrastructure\EntityRepository;

class UserRepository extends EntityRepository
{
    protected $entity = User::class;
}
