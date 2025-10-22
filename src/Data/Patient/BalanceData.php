<?php

namespace ChrisReedIO\AthenaSDK\Data\Patient;

readonly class BalanceData extends AthenaData
{
    public function __construct(
        public string $departmentList = null,
        public float $balance = null,
        public bool $cleanBalance = true,
        public int $providerGroupId = null,
    ) {}

    public static function fromArray(array $data): static
    {
        return new static(
            departmentList: $data['departmentlist'] ?? null,
            balance: (float)$data['balance'] ?? null,
            cleanBalance: self::toBool($data['cleanbalance'] ?? null),
            providerGroupId: $data['providergroupid'] ?? null,
        );
    }
}
