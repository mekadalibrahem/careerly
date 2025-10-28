<?php

namespace App\Modules\Qualifications;

abstract class Qualification
{

    abstract function create(array $data): bool|array;
    abstract function update(array $data): bool|array;
    abstract function delete(int $id): bool|array;
}
