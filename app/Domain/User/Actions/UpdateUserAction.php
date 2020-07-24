<?php
namespace App\Domain\User\Actions;

use App\Domain\User\Models\User;
use App\Domain\User\Repositories\UserRepository;
use Exception;
use Illuminate\Contracts\Hashing\Hasher;

class UpdateUserAction
{
    protected Hasher $hasher;

    public function execute(User $user, array $data): ?User
    {
        $this->db->beginTransaction();

        try {
            $user->update($data);

            $this->db->commit();

            return $user;
        } catch (Exception $e) {
            $this->logger->error($e);
            $this->db->rollback();
        }
    }
}
