<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PPERecap;
use App\Models\Record;
use Illuminate\Support\Facades\DB;

class PPERecapController extends Controller
{
    private function ppeAccountMap() {
        return [
            '10601000' => ['old' => '201', 'classification' => 'Land'],
            '10602990' => ['old' => '202', 'classification' => 'Land Improvement'],
            '10604010' => ['old' => '211', 'classification' => 'Building and Structure'],
            '10604990' => ['old' => '215', 'classification' => 'Other Structures'],
            '10605020' => ['old' => '221', 'classification' => 'Office Equipment'],
            '10605110' => ['old' => '233', 'classification' => 'Medical, Dental & Laboratory Equipment'],
            '10606010' => ['old' => '241', 'classification' => 'Motor Vehicles'],
            '10605140' => ['old' => '236', 'classification' => 'Technical & Scientific Equipment'],
            '10605990' => ['old' => '240', 'classification' => 'Other Machineries & Equipment'],
            '10605130' => ['old' => '235', 'classification' => 'Sports Equipment'],
            '10605030' => ['old' => '223', 'classification' => 'Information and Communication Tech. Equipment'],
            '10605070' => ['old' => '229', 'classification' => 'Communication Equipment'],
            '10699990' => ['old' => '250', 'classification' => 'Other Property Plant & Equipment'],
            'IME-250'  => ['old' => '250', 'classification' => '*Industrial Machines & Equipment'],
            'HT-250'   => ['old' => '250', 'classification' => '*Hand Tools'],
            '225-E'    => ['old' => '254', 'classification' => 'Artesian Wells'],
            '10607010' => ['old' => '222', 'classification' => 'Office Furniture'],
            '10605120' => ['old' => null, 'classification' => 'Printing Equipment'],
            '10605010' => ['old' => null, 'classification' => 'Machinery & Equipment'],
            '10603060' => ['old' => null, 'classification' => 'Communication Network'],
            'GIA-13'   => ['old' => null, 'classification' => 'GIA-13'],
            '218'      => ['old' => null, 'classification' => 'Donation - JICA'],
            'FUND-101' => ['old' => null, 'classification' => 'Fund 101'],
            'MOOE-101' => ['old' => null, 'classification' => 'MOOE (F-101)'],
        ];
    }

    public function index($year = null) {
        $year = $year ?? date('Y');
        $records = [];
        foreach ($this->ppeAccountMap() as $newCode => $info) {
            $records[] = new PPERecap([
                'acct_code_new' => $newCode,
                'acct_code_old' => $info['old'],
                'classification' => $info['classification'],
                'beginning_balance' => 0, 'purchases' => 0, 'reclass_from' => 0,
                'reclass_to' => 0, 'disposed' => 0, 'donated' => 0, 'adjustments' => 0,
            ]);
        }
        return view('recap.index', compact('records', 'year'));
    }

    private function cleanDecimal($value) {
        return (float) str_replace(',', '', $value ?? 0);
    }

    public function store(Request $request) {
        $data = $request->validate(['data' => 'required|array'])['data'];

        try {
            DB::transaction(function () use ($data) {
                $record = Record::create([
                    'year' => $data[0]['year'],
                    'title' => 'Inventory Recap Summary ' . $data[0]['year'],
                    'pdf_path' => '',
                    'excel_path' => ''
                ]);

                foreach ($data as $row) {
                    $b   = $this->cleanDecimal($row['beginning_balance']);
                    $p   = $this->cleanDecimal($row['purchases']);
                    $rf  = $this->cleanDecimal($row['reclass_from']);
                    $rt  = $this->cleanDecimal($row['reclass_to']);
                    $d   = $this->cleanDecimal($row['disposed']);
                    $do  = $this->cleanDecimal($row['donated']);
                    $adj = $this->cleanDecimal($row['adjustments']);
                    $total = ($b + $p + $rf) - ($rt + $d + $do) + $adj;

                    PPERecap::create([
                        'record_id'         => $record->id,
                        'acct_code_new'     => $row['acct_code_new'],
                        'acct_code_old'     => $row['acct_code_old'] ?? null,
                        'classification'    => $row['classification'] ?? '',
                        'year'              => $row['year'],
                        'beginning_balance' => $b,
                        'purchases'         => $p,
                        'reclass_from'      => $rf,
                        'reclass_to'        => $rt,
                        'disposed'          => $d,
                        'donated'           => $do,
                        'adjustments'       => $adj,
                        'total'             => $total
                    ]);
                }
            });

            return redirect()->route('ppe-recap.index')->with('success', 'Recap data saved successfully!');

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error saving data: ' . $e->getMessage());
        }
    }
}