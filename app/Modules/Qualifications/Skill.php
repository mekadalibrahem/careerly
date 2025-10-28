<?php

namespace App\Modules\Qualifications;

class Skill extends Qualification
{
    function create(array $data): bool|array
    {
        
        return true;
    }
    function update(array $data): bool|array
    {
        return true;
    }
    function delete(int $id): bool|array
    {
        return true;
    }
}
