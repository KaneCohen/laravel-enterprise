<?php
namespace App\Domain\User\Resources;

use App\Infrastructure\Resource;

class UserResource extends Resource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
        ];
    }
}
