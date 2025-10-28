<?php

namespace ChrisReedIO\AthenaSDK\Data\Insurance;

use Carbon\Carbon;
use ChrisReedIO\AthenaSDK\Data\AthenaData;

readonly class InsuranceCopayData extends AthenaData
{
    public function __construct(
        public ?float $copay = null,
        public ?string $type = null,
    ) {}
    
    /**
     * Create an instance from the raw Athena API response array
     */
    public static function fromArray(array $data): static
    {
        return new static(
            copay: isset($data['copayamount']) ? (float)$data['copayamount'] : null,
            type: $data['copaytype'] ?? null,
        );
    }
}