<!DOCTYPE html>
<html>
<head>
    <title>RPCPPE Search Results</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background: #fff;
            color: #333;
        }

        h3, h4 {
            text-align: center;
            margin: 5px 0;
        }

        h3 {
            font-size: 20px;
            font-weight: bold;
            text-transform: uppercase;
            color: #222;
        }

        h4 {
            font-size: 14px;
            font-weight: normal;
            color: #666;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 12px;
            table-layout: auto;
            margin-top: 15px;
        }

        thead th {
            background: #dcecfd;
            color: rgb(0, 0, 0);
            text-align: center;
            padding: 8px 6px;
            border: 1px solid #ccc;
            font-weight: bold;
            font-size: 11px;
        }

        tbody td {
            border: 1px solid #ddd;
            padding: 6px 5px;
            vertical-align: top;
            word-break: break-word;
        }

        tbody tr:nth-child(even) {
            background: #f9f9f9;
        }

        tbody tr:hover {
            background: #f1f7ff;
        }

        /* Print-friendly styling */
        @media print {
            body {
                margin: 5mm;
                font-size: 11px;
            }
            table {
                font-size: 10px;
                border: 1px solid #000;
            }
            thead th {
                background: #e0e0e0 !important;
                color: #000 !important;
                -webkit-print-color-adjust: exact;
                border: 1px solid #000;
            }
            td, th {
                border: 1px solid #000;
                padding: 5px;
            }
            @page {
                size: A4 landscape;
                margin: 10mm;
            }
        }
    </style>
</head>
<body>
    <h3>Report on the Physical Count of Property Plant and Equipment</h3>
    <h4>Appendix 73</h4>

    <table>
        <thead>
            <tr>
                <th rowspan="2">Property No.</th>
                <th rowspan="2">Article</th>
                <th rowspan="2">Description</th>
                <th rowspan="2">Unit of Measure</th>
                <th rowspan="2">Unit Value</th>
                <th colspan="2">Quantity Per</th>
                <th colspan="2">Shortage / Overage</th>
                <th rowspan="2">Remarks</th>
                <th rowspan="2">Date Acquired</th>
                <th rowspan="2">Accountable Person</th>
                <th rowspan="2">Location</th>
                <th rowspan="2">PRSD</th>
                <th rowspan="2">Division</th>
                <th rowspan="2">Section / Unit</th>
                <th rowspan="2">Transferred To</th>
            </tr>
            <tr>
                <th>Card</th>
                <th>Physical</th>
                <th>Qty</th>
                <th>Value</th>
            </tr>
        </thead>
        <tbody>
            @forelse($items as $item)
            <tr>
                <td>{{ $item->property_no }}</td>
                <td>{{ $item->article }}</td>
                <td>{{ $item->description }}</td>
                <td>{{ $item->unit_of_measure }}</td>
                <td>{{ $item->unit_value }}</td>
                <td>{{ $item->quantity_per_property_card }}</td>
                <td>{{ $item->quantity_per_physical_count }}</td>
                <td>{{ $item->shortage_overage_qty }}</td>
                <td>{{ $item->shortage_overage_value }}</td>
                <td>{{ $item->remarks }}</td>
                <td>{{ $item->date_acquired }}</td>
                <td>{{ $item->accountable_person }}</td>
                <td>{{ $item->location }}</td>
                <td>{{ $item->ptsd }}</td>
                <td>{{ $item->division }}</td>
                <td>{{ $item->section_unit }}</td>
                <td>{{ $item->transfer_to }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="17" style="text-align:center; font-style:italic;">No records found</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>
