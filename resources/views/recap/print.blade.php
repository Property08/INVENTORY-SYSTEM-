<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>RECAP/SUMMARY  REPORT</title>
        <style>
            body {
                font family: "DejaVu Sans", sans-serif;
                font-size: 12px;
            }

            table{
                width:100%;
                border-collapse: collapse;
            }

            th, td{
                border:1px solid #000;
                padding: 4px;
                text-align: center;
            }

            th{
                background:#f0f0f0;
            }
            </style>
    </head>

        <body>
            <h2 style="text-align: center; text-size-lg; font-family: 'Times New Roman', Times, serif;">RECAP/SUMMARY REPORT</h2>
            <br>
            <h3 style="text-align: justify; text-size-md; font-style: italic;">PHILIPPINE ATMOSPHERIC, GEOPHYSICAL AND ASTRONOMICAL SERVICES ADMINISTRATION</h3>

            <table>
                <thead>
                   <tr class="bg-gray-200 text-left">
                <th class="border border-gray-300 p-2" colspan="2">Acct.Code</th>
                <th class="p-2 border" rowspan="2">Classification Code</th>
                <th class="p-2 border" rowspan="2">Total as of/ Beginning Balance</th>
                <th class="p-2 border" rowspan="2">Purchases</th>
                <th class="p-2 border" rowspan="2">Reclassified from other accounts</th>
                <th class="p-2 border" rowspan="2">Reclassified to Other Accounts</th>
                <th class="p-2 border" rowspan="2">Disposed</th>
                <th class="p-2 border" rowspan="2">Donated</th>
                <th class="p-2 border" rowspan="2">Cancelled / Adjustment</th>
                <th class="p-2 border" rowspan="2">Total as...</th>
                
            </tr>
            <tr class="bg-gray-200 text-left">
                <th class="p-2 border">Old</th>
                <th class="p-2 border">New</th>
            </tr>
        </thead>
        <tbody>
                    @forelse($recap as $asset)
                        <tr>
                            <td class="p-2 border">{{ $asset->acct_code_old }}</td>
                    <td class="p-2 border">{{ $asset->acct_code_new }}</td>
                    <td class="p-2 border">{{ $asset->classification_code }}</td>
                    <td class="p-2 border">{{ number_format($asset->beginning_balance, 2) }}</td>
                    <td class="p-2 border">{{ number_format($asset->purchase_2024, 2) }}</td>
                    <td class="p-2 border">{{ number_format($asset->reclassified_from_other, 2) }}</td>
                    <td class="p-2 border">{{ number_format($asset->reclassified_to_other, 2) }}</td>
                    <td class="p-2 border">{{ number_format($asset->disposed, 2) }}</td>
                    <td class="p-2 border">{{ number_format($asset->donated, 2) }}</td>
                    <td class="p-2 border">{{ number_format($asset->cancelled_adjustment, 2) }}</td>
                    <td class="p-2 border">{{ number_format($asset->total_2024, 2) }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="11" style="text-align: center;">No records found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>