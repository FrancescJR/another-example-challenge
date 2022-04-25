<?php

use PHPUnit\Framework;


echo "hello world\n";


class OwnedVehicle {
    public function __construct(
        public readonly string $personId,
        public readonly string $vehicleId
    )
    {
    }
}

class Policy {
    public function __construct(
        public readonly string $personId,
        public readonly string $vehicleId
    )
    {
    }
}

class UpsellOpportunity {
    public function __construct(
        private string $personId,
        private string $vehicleId
    )
    {
    }

    public static function fromOwnedVehicle(OwnedVehicle $ownedVehicle): self
    {
        return new self(
            $ownedVehicle->personId,
            $ownedVehicle->vehicleId
        );
    }
}


class getOwnedVehiclesService {
    /**
     * @param array $personIds
     * @return OwnedVehicle[]
     */
    function get_owned_vehicles(array $personIds): array
    {
        echo "the entry is:";
        print_r($personIds);
        return [
            new OwnedVehicle('P1', 'V8'),
            new OwnedVehicle('P2', 'V6'),
            new OwnedVehicle('P1', 'V3')
        ];
    }
}


function convertOwnedVehicleToPolicy(OwnedVehicle $ownedVehicle)
{
    return new Policy($ownedVehicle->personId, $ownedVehicle->vehicleId);
}


class findPotentialUpsellService
{
    public function __construct(getOwnedVehiclesService $service) {

    }

    /**
     * @param Policy[] $policies
     * @return UpsellOpportunity[]
     */
    function find_potential_upsells(array $policies): array
    {
        $ids = [];
        foreach ($policies as $policy) {
            $ids[$policy->personId] = '';
        }
        $ids = array_keys($ids);

        $allOwnedVehicles = get_owned_vehicles($ids);

        $upsellingOpportunities = array_map('convertOwnedVehicleToPolicy', $allOwnedVehicles);
        return array_filter($upsellingOpportunities, function (Policy $policy) use ($policies) {
            return !in_array($policy, $policies);
        });
    }
}

//$policy1 = new Policy('P1', 'V8');
//$policy2 = new Policy('P2', 'V6');
$policies = [
    new Policy('P1', 'V8'),
    new Policy('P2', 'V6'),
    new Policy('P1', 'V7'),
];

$potentialUpsells = find_potential_upsells($policies);

foreach($potentialUpsells as $potentialUpsell) {
    print_r($potentialUpsell);
}

$expectedResponse = [
    new UpsellOpportunity('P1', 'V3')
];

Framework\assertEquals($expectedResponse, $potentialUpsells);








