<?php

namespace App\Shop\Attributes\Repositories;

use App\Shop\Attributes\Attribute;
use App\Shop\Base\Interfaces\BaseRepositoryInterface;
use Illuminate\Support\Collection;

interface AttributeRepositoryInterface extends BaseRepositoryInterface
{
    public function createAttribute(array $data) : Attribute;

    public function updateAttribute(array $data) : bool;

    public function deleteAttribute() : ?bool;

    public function listAttributes($columns = array('*'), string $orderBy = 'id', string $sortBy = 'asc') : Collection;
}