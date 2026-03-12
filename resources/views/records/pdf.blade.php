<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <style>
        /* Force Legal Landscape and Strict Margins */
        @page { 
            size: 14in 8.5in; 
            margin: 0.3in; 
        }
        
        body { 
            font-family: 'Arial Narrow', Arial, sans-serif; 
            font-size: 7.5pt; 
            color: #1a1a1a; 
            line-height: 1.1; 
            margin: 0;
            -webkit-print-color-adjust: exact;
        }

        .print-container {
            width: 100%;
        }

        /* Header Styles */
        .report-header {
            width: 100%;
            margin-bottom: 10px;
        }
        .agency-info {
            font-size: 7.5pt;
            font-weight: bold;
        }

        /* Main Table Layout */
        table { 
            width: 100%; 
            border-collapse: collapse; 
            table-layout: fixed; /* Forces columns to stay within defined widths */
            margin-top: 5px;
        }

        th, td { 
            border: 1px solid #000;
            padding: 2px 3px; 
            word-wrap: break-word; 
            overflow: hidden;
        }

        th { 
            background-color: #f2f2f2;
            font-weight: bold;
            text-transform: uppercase;
            font-size: 6.8pt;
            text-align: center;
        }

        /* Column Width Definitions (Total 100%) */
        .col-code-new { width: 7%; }
        .col-code-old { width: 6%; }
        .col-class    { width: 18%; }
        .col-money    { width: 8.5%; }
        .col-total    { width: 11%; }

        /* Typography & Alignment */
        .text-right { text-align: right; }
        .text-center { text-align: center; }
        .font-bold { font-weight: bold; }
        
        /* Specialized Row Styles */
        .bg-fund { background-color: #f9f9f9 !important; font-weight: bold; }
        .bg-footer { background-color: #eeeeee !important; font-weight: bold; }
        
        .double-underline {
            border-bottom: 3px double #000;
            padding-bottom: 1px;
            display: inline-block;
            width: 90%;
        }

        /* Signatures Section */
        .sig-container { 
            margin-top: 25px; 
            width: 100%; 
        }
        .sig-box { 
            width: 45%; 
            display: inline-block; 
            vertical-align: top; 
        }
        .sig-name { 
            font-weight: bold; 
            text-decoration: underline; 
            text-transform: uppercase; 
            font-size: 9pt;
            margin-top: 35px;
            display: block;
        }
    </style>
</head>
<body>

<div class="print-container">
    <table style="border: none; width: 100%; margin-bottom: 5px;">
        <tr style="border: none;">
            <td style="border: none; width: 50%;" class="agency-info">
                DEPARTMENT OF SCIENCE AND TECHNOLOGY<br>
                Philippine Atmospheric, Geophysical and Astronomical Services Administration<br>
            </td>

        </tr>
    </table>

    <div style="text-align: center; margin-bottom: 15px;">
        <div style="font-weight: bold; font-size: 11pt;">INVENTORY OF FIXED ASSETS</div>
        <div style="font-size: 8pt;">As of December 31, {{ $record->year }}</div>
    </div>

    @php
        // Initialization of sums
        $f101_sum = ['b' => 0, 'tot' => 0];
        $mooe_sum = ['b' => 0, 'p' => 0, 'rf' => 0, 'rt' => 0, 'd' => 0, 'don' => 0, 'adj' => 0, 'tot' => 0];
        $landJica_sum = ['p' => 0, 'rf' => 0, 'rt' => 0, 'd' => 0, 'don' => 0, 'adj' => 0];
    @endphp

    <table>
        <thead>
            <tr>
                <th rowspan="2" class="col-code-new">New Acct Code</th>
                <th rowspan="2" class="col-code-old">Old Acct Code</th>
                <th rowspan="2" class="col-class">Classification</th>
                <th class="col-money">Beg. Balance</th>
                <th class="col-money">Purchases</th>
                <th class="col-money">Reclass From</th>
                <th class="col-money">Reclass To</th>
                <th class="col-money">Disposed</th>
                <th class="col-money">Donated</th>
                <th class="col-money">Adjustments</th>
                <th class="col-total">Total Balance</th>
            </tr>
            <tr style="font-size: 6.5pt;">
                <th>12/31/{{ $record->year - 1 }}</th>
                <th>CY {{ $record->year }}</th>
                <th>Other Accts</th>
                <th>Other Accts</th>
                <th>Current Year</th>
                <th>Current Year</th>
                <th>Add / (Less)</th>
                <th>12/31/{{ $record->year }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach($record->recaps as $r)
                @php
                    $row_total = ($r->beginning_balance + $r->purchases + $r->reclass_from) 
                               - ($r->reclass_to + $r->disposed + $r->donated) 
                               + $r->adjustments;

                    if($r->acct_code_new !== 'FUND-101' && $r->acct_code_new !== 'MOOE-101') {
                        $f101_sum['b'] += $r->beginning_balance;
                        $f101_sum['tot'] += $row_total;
                        $landJica_sum['p'] += $r->purchases;
                        $landJica_sum['rf'] += $r->reclass_from;
                        $landJica_sum['rt'] += $r->reclass_to;
                        $landJica_sum['d'] += $r->disposed;
                        $landJica_sum['don'] += $r->donated;
                        $landJica_sum['adj'] += $r->adjustments;
                    }

                    if($r->acct_code_new === 'MOOE-101') {
                        $mooe_sum = [
                            'b' => $r->beginning_balance, 'p' => $r->purchases, 'rf' => $r->reclass_from,
                            'rt' => $r->reclass_to, 'd' => $r->disposed, 'don' => $r->donated,
                            'adj' => $r->adjustments, 'tot' => $row_total
                        ];
                    }
                @endphp

                @if($r->acct_code_new === 'FUND-101')
                    <tr class="bg-fund">
                        <td class="text-center" colspan="2">FUND 101</td>
                        <td class="text-left"> (FUND 101)</td>
                        <td class="text-right">{{ number_format($f101_sum['b'], 2) }}</td>
                        <td colspan="6" class="text-center" style="font-size: 6pt; color: #777; letter-spacing: 1px;">* CONSOLIDATED VALUES *</td>
                        <td class="text-right font-bold">{{ number_format($f101_sum['tot'], 2) }}</td>
                    </tr>
                @else
                    <tr>
                        <td class="text-center">{{ $r->acct_code_new }}</td>
                        <td class="text-center">{{ $r->acct_code_old }}</td>
                        <td class="text-left" style="font-size: 7pt;">{{ $r->classification }}</td>
                        <td class="text-right">{{ $r->beginning_balance == 0 ? '-' : number_format($r->beginning_balance, 2) }}</td>
                        <td class="text-right">{{ $r->purchases == 0 ? '-' : number_format($r->purchases, 2) }}</td>
                        <td class="text-right">{{ $r->reclass_from == 0 ? '-' : number_format($r->reclass_from, 2) }}</td>
                        <td class="text-right">{{ $r->reclass_to == 0 ? '-' : number_format($r->reclass_to, 2) }}</td>
                        <td class="text-right">{{ $r->disposed == 0 ? '-' : number_format($r->disposed, 2) }}</td>
                        <td class="text-right">{{ $r->donated == 0 ? '-' : number_format($r->donated, 2) }}</td>
                        <td class="text-right">{{ $r->adjustments == 0 ? '-' : number_format($r->adjustments, 2) }}</td>
                        <td class="text-right font-bold">{{ number_format($row_total, 2) }}</td>
                    </tr>
                @endif
            @endforeach
        </tbody>
        <tfoot>
            <tr class="bg-footer">
                <td colspan="3" class="text-right">GRAND TOTAL</td>
                <td class="text-right">{{ number_format($f101_sum['b'] + $mooe_sum['b'], 2) }}</td>
                <td class="text-right">{{ number_format($landJica_sum['p'] + $mooe_sum['p'], 2) }}</td>
                <td class="text-right">{{ number_format($landJica_sum['rf'] + $mooe_sum['rf'], 2) }}</td>
                <td class="text-right">{{ number_format($landJica_sum['rt'] + $mooe_sum['rt'], 2) }}</td>
                <td class="text-right">{{ number_format($landJica_sum['d'] + $mooe_sum['d'], 2) }}</td>
                <td class="text-right">{{ number_format($landJica_sum['don'] + $mooe_sum['don'], 2) }}</td>
                <td class="text-right">{{ number_format($landJica_sum['adj'] + $mooe_sum['adj'], 2) }}</td>
                <td class="text-right">
                    <span class="double-underline">{{ number_format($f101_sum['tot'] + $mooe_sum['tot'], 2) }}</span>
                </td>
            </tr>
        </tfoot>
    </table>

    <div class="sig-container">
        <div class="sig-box">
            <div>Prepared by:</div>
            <span class="sig-name">RONALD REY R. MORANO</span>
            <div style="font-size: 8pt;">Administrative Officer V</div>
        </div>
        <div class="sig-box" style="float: right; text-align: right;">
            <div style="text-align: left; display: inline-block; width: 250px;">
                <div>Approved by:</div>
                <span class="sig-name">NATHANIEL T. SERVANDO, Ph.D.</span>
                <div style="font-size: 8pt;">Administrator</div>
            </div>
        </div>
    </div>
</div>

</body>
</html>