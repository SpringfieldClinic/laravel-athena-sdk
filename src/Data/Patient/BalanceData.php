<?php

namespace ChrisReedIO\AthenaSDK\Data\Patient;

use ChrisReedIO\AthenaSDK\Data\AthenaData;

readonly class BalanceData extends AthenaData
{
    public function __construct(
        public ?string $departmentList = null,
        public ?float $balance = 0,
        public ?float $collectionsBalance = null,
        public ?bool $cleanBalance = true,
        public ?int $providerGroupId = 1,
    ) {}

    public static function fromArray(array $data): static
    {
        return new static(
            departmentList: $data['departmentlist'] ?? null,
            balance: $data['balance'] ? (float)$data['balance'] : 0,
            collectionsBalance: $data['collectionsbalance'] ? (float)$data['collectionsbalance'] : null,
            cleanBalance: self::toBool($data['cleanbalance'] ?? true),
            providerGroupId: $data['providergroupid'] ?? 1,
        );
    }
}
