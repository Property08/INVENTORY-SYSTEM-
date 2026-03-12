<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>RPCPPE Report - Official Monochrome</title>
    <style>
        /* Classic Government Font - Clean and professional */
        body {
            font-family: Arial, Helvetica, sans-serif;
            margin: 0;
            padding: 0;
            color: #000;
            background-color: #fff;
        }

        @page {
            size: legal landscape;
            margin: 0.5in;
        }

        .wrapper {
            width: 100%;
        }

        /* Header Section */
        .report-header {
            text-align: center;
            margin-bottom: 20px;
            position: relative;
        }

        .appendix-label {
            position: absolute;
            top: 0;
            right: 0;
            font-weight: bold;
            font-size: 11px;
            font-style: italic;
        }

        .agency-name {
            font-size: 13px;
            text-transform: uppercase;
            margin-bottom: 2px;
        }

        .report-title {
            font-size: 16px;
            font-weight: bold;
            text-decoration: none;
            margin-top: 10px;
            border-bottom: 1px solid #000;
            display: inline-block;
            padding-bottom: 2px;
        }

        .sub-title {
            font-size: 14px;
            font-weight: bold;
            margin-top: 5px;
            text-transform: uppercase;
        }

        /* Table Design: Xerox-Friendly */
        table {
           width: 100%;
        border-collapse: separate; 
        border-spacing: 0;
        font-size: 8px; 
        border: 1px solid #000; 
        table-layout: auto; 
        }
        td {
        overflow: hidden;
        white-space: normal;
    }
        th, td {
            border: 1px solid #000;
            padding: 4px;
            word-wrap: break-word;
            vertical-align: top;
        }

        /* Header Styling - No more Blue */
        thead th {
            background-color: #e5e5e5; /* Very light gray for contrast */
            font-weight: bold;
            text-transform: uppercase;
            text-align: center;
            vertical-align: middle;
        }

        .col-num-row td {
            background-color: #fff;
            text-align: center;
            font-style: italic;
            font-size: 8px;
        }

        /* Alignment */
        .text-left { text-align: left; }
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .bold { font-weight: bold; }

        /* Alternating rows for readability (Gray instead of Blue) */
        tbody tr:nth-child(even) {
            background-color: #fafafa;
        }

        /* Signature Section */
        .signature-section {
            margin-top: 40px;
            width: 100%;
            display: table;
        }

        .sig-column {
            display: table-cell;
            width: 33%;
            text-align: left;
            padding-right: 20px;
        }

        .sig-line {
            margin-top: 40px;
            border-bottom: 1px solid #000;
            width: 90%;
            text-align: center;
            font-weight: bold;
            text-transform: uppercase;
            font-size: 11px;
        }

        .sig-label {
            font-size: 11px;
            padding-top: 5px;
        }

        /* Print Settings */
        @media print {
            body { margin: 0; }
            table { width: 100%; }
            .no-print { display: none; }
        }
    </style>
</head>
<body>

<div class="wrapper">
    <div class="report-header">
        <div class="appendix-label">Appendix 73</div>
        <div class="agency-name"><strong>PAGASA</strong></div>
        
        <div class="sub-title">REPORT ON THE PHYSICAL COUNT OF PROPERTY, PLANT AND EQUIPMENT</div>
        <div style="font-size: 11px; margin-top: 5px;">As of {{ date('F d, Y') }}</div>
    </div>

    <table>
        <thead>
            <tr>
                <th rowspan="2" style="width: 7%;">Property No.</th>
                <th rowspan="2" style="width: 8%;">Article</th>
                <th rowspan="2" style="width: 15%;">Description</th>
                <th rowspan="2" style="width: 5%;">Unit</th>
                <th rowspan="2" style="width: 7%;">Unit Value</th>
                <th colspan="2" style="width: 10%;">Quantity Per</th>
                <th colspan="2" style="width: 12%;">Shortage/Overage</th>
                <th rowspan="2" style="width: 10%;">Remarks</th>
                <th rowspan="2" style="width: 7%;">Date Acquired</th>
                <th rowspan="2" style="width: 8%;">Accountable Person</th>
                <th rowspan="2" style="width: 8%;">Transfer to</th>
                <th rowspan="2" style="width: 6%;">Location</th>
                <th rowspan="2" style="width: 5%;">Division</th>
                <th rowspan="2" style="width: 5%;">Section</th>
            </tr>
            <tr>
                <th>Card</th>
                <th>Physical</th>
                <th>Qty</th>
                <th>Value</th>
            </tr>
            <tr class="col-num-row">
                <td>1</td><td>2</td><td>3</td><td>4</td><td>5</td><td>6</td><td>7</td><td>8</td><td>9</td><td>10</td><td>11</td><td>12</td><td>13</td><td>14</td><td>15</td><td>16</td>
            </tr>
        </thead>
        <tbody>
            @forelse($items as $item)
            <tr>
                <td class="text-center">{{ $item->property_no }}</td>
                <td class="text-left bold">{{ $item->article }}</td>
                <td class="text-left">{{ $item->description }}</td>
                <td class="text-center">{{ $item->unit_of_measure }}</td>
                <td class="text-right">{{ number_format($item->unit_value, 2) }}</td>
                <td class="text-center">{{ $item->quantity_per_property_card }}</td>
                <td class="text-center">{{ $item->quantity_per_physical_count }}</td>
                <td class="text-center">{{ $item->shortage_overage_qty }}</td>
                <td class="text-right">{{ number_format($item->shortage_overage_value, 2) }}</td>
                <td class="text-left italic">{{ $item->remarks }}</td>
                <td class="text-center">{{ $item->date_acquired }}</td>
                <td class="text-left">{{ $item->accountable_person }}</td>
                <td class="text-left">{{ $item->transfer_to }}</td>
                <td class="text-center">{{ $item->location }}</td>
                <td class="text-center">{{ $item->division }}</td>
                <td class="text-center">{{ $item->section_unit }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="14" style="text-align: center; padding: 20px;">*** NOTHING FOLLOWS ***</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

</body>
</html>