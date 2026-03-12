<?php

namespace App\Imports;

use App\Models\Rpcppe;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Carbon\Carbon;

class RpcppeImport implements ToModel, WithStartRow
{
    public function startRow(): int { return 16; }

    public function model(array $row)
    {
        if (empty($row[0])) { return null; }

        $propertyNo = $row[2] ?? '';
        $prefix = strtoupper(trim(explode('-', $propertyNo)[0]));

        $mapping = [
            '201' => 'LAND', '202' => 'LAND IMPROVEMENT', '211' => 'BUILDING AND STRUCTURE',
            '215' => 'OTHER STRUCTURES', '221' => 'OFFICE EQUIPMENT', '208' => 'MEDICAL, DENTAL & LABORATORY EQUIPMENT',
            '241' => 'MOTOR VEHICLES', '236' => 'TECHNICAL & SCIENTIFIC EQUIPMENT', '240' => 'OTHER MACHINERIES & EQUIPMENT',
            '235' => 'SPORTS EQUIPMENT', '223' => 'INFORMATION AND COMM. TECH. EQUIPMENT', '229' => 'COMMUNICATION EQUIPMENT',
            '250' => 'HANDS TOOL', '255D' => 'INDUSTRIAL MACHINES & IMPLEMENTS', '254' => 'ARTESIAN WELLS',
            '222' => 'OFFICE FURNITURES', '10605120' => 'PRINTING EQUIPMENT', '10605010' => 'MACHINERY & EQUIPMENT',
            '10603060' => 'COMMUNICATION NETWORK', 'HV' => 'SEMI-EXPENDABLE (High Value)', 'LV' => 'SEMI-EXPENDABLE (Low Value)',
        ];

        return new Rpcppe([
            'article'                     => trim($row[0]),
            'description'                 => $row[1] ?? null,
            'property_no'                 => $row[2],
            'classification'              => $mapping[$prefix] ?? 'OTHERS',
            'unit_of_measure'             => $row[3] ?? null,
            'unit_value'                  => $this->cleanNumber($row[4] ?? 0),
            'quantity_per_property_card'  => (int)($row[5] ?? 0),
            'quantity_per_physical_count' => (int)($row[6] ?? 0),
            'shortage_overage_qty'        => (int)($row[7] ?? 0),
            'shortage_overage_value'      => $this->cleanNumber($row[8] ?? 0),
            'remarks'                     => $row[9] ?? null,
            'date_acquired'               => $this->transformDate($row[10] ?? null),
            'accountable_person'          => $row[11] ?? null,
            'location'                    => $row[13] ?? null,
            'division'                    => $row[14] ?? null,
            'section_unit'                => $row[15] ?? null,
        ]);
    }

    private function cleanNumber($value) { return (float) str_replace(',', '', $value ?? 0); }

    private function transformDate($value) {
        if (empty($value)) return null;
        try {
            return is_numeric($value) 
                ? \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($value)->format('Y-m-d')
                : Carbon::parse($value)->format('Y-m-d');
        } catch (\Exception $e) { return null; }
    }
}