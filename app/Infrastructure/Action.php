<?php
namespace App\Infrastructure;

use Illuminate\Database\DatabaseManager;
use Psr\Log\LoggerInterface;

class Action
{
    protected DatabaseManager $db;
    protected LoggerInterface $logger;

    public function __construct(
        DatabaseManager $db,
        LoggerInterface $logger
    ) {
        $this->db = $db;
        $this->logger = $logger;
    }
}
