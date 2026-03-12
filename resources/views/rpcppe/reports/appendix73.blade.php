<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <style>
        /* ===== PDF & PRINT SETUP ===== */
        @page {
            size: 14in 8.5in; /* Legal Landscape */
            margin: 0.4in;
        }

        body {
            margin: 0;
            padding: 0;
            font-family: "Times New Roman", Times, serif;
            font-size: 10pt;
            width: 100%;
        }

        /* ===== CONTAINER TO FORCE FULL WIDTH ===== */
        .report-wrapper {
            width: 100%;
            margin: 0 auto;
        }

        /* Appendix Label */
        .appendix {
            text-align: right;
            font-weight: bold;
            font-style: italic;
            margin-bottom: 5px;
        }

        /* Header Section */
        .header {
            text-align: center;
            margin-bottom: 15px;
        }

        .header h2 {
            margin: 0;
            font-size: 14pt;
            text-transform: uppercase;
        }

        .info-lines {
            width: 100%;
            margin-bottom: 10px;
        }

        .underline {
            border-bottom: 1px solid black;
            display: inline-block;
            padding: 0 5px;
            font-weight: bold;
        }

        /* ===== THE TABLE FIX ===== */
       table.main-report {
        width: 100%;
        border-collapse: separate; /* Mas mabilis i-render kaysa sa collapse */
        border-spacing: 0;
        table-layout: auto; /* Hayaan ang Dompdf na mag-calculate naturally */
    }

    table.main-report th, 
    table.main-report td {
        border-right: 1px solid black;
        border-bottom: 1px solid black;
        padding: 4px 2px;
        word-wrap: break-word;
        font-size: 8pt; /* Bahagyang paliitin para magkasya lahat sa isang row */
    }

    /* Lagyan ng border ang left at top para mabuo ang grid */
    table.main-report {
        border-left: 1px solid black;
        border-top: 1px solid black;
    }

    /* Iwasan ang sobrang kapal na borders sa PDF headers */
    thead th {
        background-color: #f2f2f2;
        font-weight: bold;
    }

        /* Column Width Distribution (%) */
        .w-article { width: 10%; }
        .w-desc    { width: 22%; }
        .w-prop    { width: 12%; }
        .w-unit    { width: 6%; }
        .w-val     { width: 9%; }
        .w-qty     { width: 6%; }
        .w-rem     { width: 10%; }

        /* Signatories using Table for alignment fix */
        .sig-table {
            width: 100%;
            margin-top: 50px;
            border: none;
        }

        .sig-table td {
            border: none;
            width: 33.33%;
            text-align: center;
            vertical-align: top;
        }

        .sig-line {
            display: block;
            margin: 0 auto;
            width: 80%;
            border-bottom: 1px dashed black; /* Or solid */
            margin-top: 40px;
            font-weight: bold;
        }
    </style>
</head>
<body>

<div class="report-wrapper">
    <div class="appendix">Appendix 73</div>

    <div class="header">
        <h2>Report on the Physical Count of Property, Plant and Equipment</h2>
        <p>(Type of Property, Plant and Equipment)</p>
    </div>

    <div class="info-lines">
        <table style="width: 100%; border: none;">
            <tr style="border: none;">
                <td style="border: none;">Fund Cluster: <span class="underline" style="min-width: 150px;">{{ $fund_cluster ?? '' }}</span></td>
                <td style="border: none; text-align: right;">As of: <span class="underline" style="min-width: 120px;">{{ date('F d, Y') }}</span></td>
            </tr>
        </table>
        <p style="margin-top: 10px;">
            For which <span class="underline">{{ $accountable_person ?? '________________' }}</span>, <span class="underline">{{ $designation ?? '________________' }}</span> of <span class="underline">{{ $entity_name ?? '________________' }}</span> is accountable, having assumed such accountability on <span class="underline">{{ $assumption_date ?? '________________' }}</span>.
        </p>
    </div>

    <table class="main-report">
        <thead>
            <tr>
                <th rowspan="2" class="w-article">Article</th>
                <th rowspan="2" class="w-desc">Description</th>
                <th rowspan="2" class="w-prop">Property Number</th>
                <th rowspan="2" class="w-unit">Unit of Measure</th>
                <th rowspan="2" class="w-val">Unit Value</th>
                <th colspan="2">Quantity</th>
                <th colspan="2" style="width: 14%;">Shortage/Overage</th>
                <th rowspan="2" class="w-rem">Remarks</th>
            </tr>
            <tr>
                <th class="w-qty">Per Prop. Card</th>
                <th class="w-qty">Per Physical</th>
                <th style="width: 6%;">Qty</th>
                <th style="width: 8%;">Value</th>
            </tr>
        </thead>
        <tbody>
            @forelse($items as $item)
            <tr>
                <td class="bold">{{ $item->article }}</td>
                <td style="text-align: left; font-size: 9pt;">{{ $item->description }}</td>
                <td>{{ $item->property_no }}</td>
                <td>{{ $item->unit_of_measure }}</td>
                <td style="text-align: right;">{{ number_format($item->unit_value, 2) }}</td>
                <td>{{ $item->quantity_per_property_card }}</td>
                <td>{{ $item->quantity_per_physical_count }}</td>
                <td>{{ $item->shortage_overage_qty }}</td>
                <td style="text-align: right;">{{ number_format($item->shortage_overage_value, 2) }}</td>
                <td style="text-align: left;">{{ $item->remarks }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="10">*** Nothing Follows ***</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <table class="sig-table">
        <tr>
            <td>
                Certified Correct by:<br>
                <span class="sig-line"></span>
                Inventory Committee Chair
            </td>
            <td>
                Approved by:<br>
                <span class="sig-line"></span>
                Head of Agency/Entity
            </td>
            <td>
                Verified by:<br>
                <span class="sig-line"></span>
                COA Representative
            </td>
        </tr>
    </table>
</div>

</body>
</html>