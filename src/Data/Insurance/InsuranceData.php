<?php

namespace ChrisReedIO\AthenaSDK\Data\Insurance;

use Carbon\Carbon;
use ChrisReedIO\AthenaSDK\Data\AthenaData;

readonly class InsuranceData extends AthenaData
{
    public function __construct(
        public ?int $patient_id = null,

        // Insurance provider information
        public ?string $irc_name = null,
        public ?string $insurance_phone = null,
        public ?string $insurance_payer_name = null,
        public ?string $insurance_plan_name = null,
        public ?string $insurance_package_payer_id = null,
        public ?int $insurance_package_id = null,
        public ?string $insurance_type = null,
        public ?string $insurance_product_type = null,
        public ?int $irc_id = null,
        
        // Policy holder information
        public ?string $insurance_policy_holder = null,
        public ?string $insurance_policy_holder_first_name = null,
        public ?string $insurance_policy_holder_middle_name = null,
        public ?string $insurance_policy_holder_last_name = null,
        public ?string $insurance_policy_holder_address1 = null,
        public ?string $insurance_policy_holder_city = null,
        public ?string $insurance_policy_holder_state = null,
        public ?string $insurance_policy_holder_zip = null,
        public ?string $insurance_policy_holder_country_code = null,
        public ?string $insurance_policy_holder_country_iso3166 = null,
        public ?Carbon $insurance_policy_holder_dob = null,
        public ?string $insurance_policy_holder_sex = null,
        
        // Insurance package address
        public ?string $insurance_package_address1 = null,
        public ?string $insurance_package_city = null,
        public ?string $insurance_package_state = null,
        public ?string $insurance_package_zip = null,
        
        // Insurance identification
        public ?string $insurance_id = null,
        public ?string $insurance_id_number = null,
        public ?string $insured_id_number = null,
        
        // Relationship and entity information
        public ?string $relationship_to_insured = null,
        public ?int $relationship_to_insured_id = null,
        public ?int $insured_entity_type_id = null,
        
        // Eligibility information
        public ?string $eligibility_status = null,
        public ?Carbon $eligibility_last_checked = null,
        public ?string $eligibility_reason = null,
        public ?string $eligibility_message = null,
        public ?int $recent_eligibility_track_id = null,
        
        // Policy information
        public ?string $case_policy_type_name = null,
        public ?int $sequence_number = null,
        public ?Carbon $issue_date = null,
        
        // Notes and additional information
        public ?string $note = null,
        
        // Audit fields
        public ?string $created_by = null,
        public ?string $last_updated_by = null,
        public ?Carbon $last_updated = null,

        public ?array $copays = null,
    ) {}
    
    /**
     * Create an instance from the raw Athena API response array
     */
    public static function fromArray(array $data): static
    {
        return new static(
            patient_id: isset($data['patientid']) ? (int) $data['patientid'] : null,

            // Insurance provider information
            irc_name: $data['ircname'] ?? null,
            insurance_phone: $data['insurancephone'] ?? null,
            insurance_payer_name: $data['insurancepayername'] ?? null,
            insurance_plan_name: $data['insuranceplanname'] ?? null,
            insurance_package_payer_id: $data['insurancepackagepayerid'] ?? null,
            insurance_package_id: isset($data['insurancepackageid']) ? (int) $data['insurancepackageid'] : null,
            insurance_type: $data['insurancetype'] ?? null,
            insurance_product_type: $data['insuranceproducttype'] ?? null,
            irc_id: isset($data['ircid']) ? (int) $data['ircid'] : null,
            
            // Policy holder information
            insurance_policy_holder: $data['insurancepolicyholder'] ?? null,
            insurance_policy_holder_first_name: $data['insurancepolicyholderfirstname'] ?? null,
            insurance_policy_holder_middle_name: $data['insurancepolicyholdermiddlename'] ?? null,
            insurance_policy_holder_last_name: $data['insurancepolicyholderlastname'] ?? null,
            insurance_policy_holder_address1: $data['insurancepolicyholderaddress1'] ?? null,
            insurance_policy_holder_city: $data['insurancepolicyholdercity'] ?? null,
            insurance_policy_holder_state: $data['insurancepolicyholderstate'] ?? null,
            insurance_policy_holder_zip: $data['insurancepolicyholderzip'] ?? null,
            insurance_policy_holder_country_code: $data['insurancepolicyholdercountrycode'] ?? null,
            insurance_policy_holder_country_iso3166: $data['insurancepolicyholdercountryiso3166'] ?? null,
            insurance_policy_holder_dob: self::parseDate($data['insurancepolicyholderdob'] ?? null),
            insurance_policy_holder_sex: $data['insurancepolicyholdersex'] ?? null,
            
            // Insurance package address
            insurance_package_address1: $data['insurancepackageaddress1'] ?? null,
            insurance_package_city: $data['insurancepackagecity'] ?? null,
            insurance_package_state: $data['insurancepackagestate'] ?? null,
            insurance_package_zip: $data['insurancepackagezip'] ?? null,
            
            // Insurance identification
            insurance_id: $data['insuranceid'] ?? null,
            insurance_id_number: $data['insuranceidnumber'] ?? null,
            insured_id_number: $data['insuredidnumber'] ?? null,
            
            // Relationship and entity information
            relationship_to_insured: $data['relationshiptoinsured'] ?? null,
            relationship_to_insured_id: isset($data['relationshiptoinsuredid']) ? (int) $data['relationshiptoinsuredid'] : null,
            insured_entity_type_id: isset($data['insuredentitytypeid']) ? (int) $data['insuredentitytypeid'] : null,
            
            // Eligibility information
            eligibility_status: $data['eligibilitystatus'] ?? null,
            eligibility_last_checked: self::parseDate($data['eligibilitylastchecked'] ?? null),
            eligibility_reason: $data['eligibilityreason'] ?? null,
            eligibility_message: $data['eligibilitymessage'] ?? null,
            recent_eligibility_track_id: isset($data['recenteligibilitytrackid']) ? (int) $data['recenteligibilitytrackid'] : null,
            
            // Policy information
            case_policy_type_name: $data['casepolicytypename'] ?? null,
            sequence_number: isset($data['sequencenumber']) ? (int) $data['sequencenumber'] : null,
            issue_date: self::parseDate($data['issuedate'] ?? null),
            
            // Notes and additional information
            note: $data['note'] ?? null,
            
            // Audit fields
            created_by: $data['createdby'] ?? null,
            last_updated_by: $data['lastupdatedby'] ?? null,
            last_updated: self::parseDate($data['lastupdated'] ?? null),

            copays: array_map(
                fn ($item) => InsuranceCopayData::fromArray($item),
                $data['copays'] ?? []
            ),
        );
    }
    
    /**
     * Parse date string from MM/DD/YYYY format to Carbon instance
     */
    private static function parseDate(?string $dateString): ?Carbon
    {
        if (empty($dateString)) {
            return null;
        }
        
        try {
            // Try to parse MM/DD/YYYY format first
            return Carbon::createFromFormat('m/d/Y', $dateString);
        } catch (\Exception $e) {
            try {
                // Fallback to general parsing
                return Carbon::parse($dateString);
            } catch (\Exception $e) {
                return null;
            }
        }
    }
}