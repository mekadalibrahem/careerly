<?php

namespace App\Modules\Works\Entities\Dto;

use App\Modules\Works\Enums\WorkStatusEnum;

final readonly class WorkRegistrationDto
{


    public function __construct(
        public string $name,
        public string $description,
        public string $company,
        public string $location,
        public string $type,
        public string $salary_range,
        public string $requirements,
        public string $benefits,
        public string $status,

    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            name: $data["name"],
            description: $data["description"],
            company: $data["company"],
            location: $data["location"],
            type: $data["type"],
            salary_range: $data["salary_range"],
            requirements: $data["requirements"],
            benefits: $data["benefits"],
            status: $data["status"] ?? WorkStatusEnum::ACTIVE(),

        );
    }
    public function toArray(): array
    {
        return [
            "name" => $this->name,
            "description" => $this->description,
            "company" => $this->company,
            "location" => $this->location,
            "type" => $this->type,
            "salary_range" => $this->salary_range,
            "requirements" => $this->requirements,
            "benefits" => $this->benefits,
            "status" => $this->status,

        ];
    }
}
