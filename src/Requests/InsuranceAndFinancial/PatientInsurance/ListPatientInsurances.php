<?php

namespace ChrisReedIO\AthenaSDK\Requests\InsuranceAndFinancial\PatientInsurance;

use ChrisReedIO\AthenaSDK\Data\Insurance\InsuranceData;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;

/**
 * ListPatientInsurances
 *
 * Retrieves all patient insurances for a specific patient Note: This endpoint may rely on specific
 * settings to be enabled in athenaNet Production to function properly that are not required in other
 * environments. Please see <a
 * href="/api/resources/best-practices-and-troubleshooting#Handling_Beta_APIs">Permissioned Rollout of
 * APIs</a> for more information if you are experiencing issues.
 */
class ListPatientInsurances extends Request
{
    protected Method $method = Method::GET;

    public function resolveEndpoint(): string
    {
        return "/patients/{$this->patientid}/insurances";
    }

    /**
     * @param  int  $patientid  patientid
     * @param  null|int  $departmentid  If set, we will use the department id in an attempt to find the local patient.
     * @param  null|bool  $ignorerestrictions  Set to true to allow ability to find patients with record restrictions and blocked patients. No effect if the CLTH_DP_NEW_BTG_MDP_RESTRICTIONS toggle is enabled.
     * @param  null|bool  $showcancelled  If set, include cancelled and expired insurances.
     * @param  null|bool  $showfullssn  If set, will show full SSN instead of a masked number.
     */
    public function __construct(
        protected int $patientid,
        protected ?int $departmentid = null,
        protected ?bool $ignorerestrictions = null,
        protected ?bool $showcancelled = null,
        protected ?bool $showfullssn = null,
    ) {}

    public function defaultQuery(): array
    {
        return array_filter([
            'departmentid' => $this->departmentid,
            'ignorerestrictions' => $this->ignorerestrictions,
            'showcancelled' => $this->showcancelled,
            'showfullssn' => $this->showfullssn,
        ]);
    }

    public function createDtoFromResponse(Response $response): array
    {
        return array_map(
            fn ($item) => InsuranceData::fromArray($item),
            $response->json()['insurances'] ?? []
        );
    }
}
