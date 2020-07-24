<?php
namespace App\Domain\User\Actions;

use App\Domain\User\Events\UserRegistered;
use App\Domain\User\Models\User;
use Exception;
use Illuminate\Contracts\Hashing\Hasher;
use Illuminate\Database\DatabaseManager;
use Psr\Log\LoggerInterface;

class RegisterUserAction
{
    protected Hasher $hasher;
    protected DatabaseManager $db;
    protected LoggerInterface $logger;

    public function __construct(
        Hasher $hasher,
        DatabaseManager $db,
        LoggerInterface $logger
    ) {
        $this->hasher = $hasher;
        $this->db = $db;
        $this->logger = $logger;
    }

    public function execute(array $data)
    {
        $this->db->beginTransaction();

        try {
            $user = User::create([
                'first_name' => $data['email'],
                'last_name' => $data['last_name'],
                'middle_name' => $data['middle_name'],
                'email' => $data['email'],
                'password' => $this->hasher->make($data['password'] ?? ''),
            ]);

            $this->db->commit();

            event(new UserRegistered($user));

            return $user;
        } catch (Exception $e) {
            $this->logger->error($e);
            $this->db->rollback();
        }
    }
}
