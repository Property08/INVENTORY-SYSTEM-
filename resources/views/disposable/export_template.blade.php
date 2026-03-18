<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <style>
        /* PDF Specific Styles */
        body { font-family: 'Helvetica', sans-serif; font-size: 10px; color: #334155; }
        .pdf-header { text-align: center; margin-bottom: 20px; }
        .pdf-header h1 { margin: 0; color: #0f172a; text-transform: uppercase; font-size: 18px; }
        
        .stats-container { width: 100%; margin-bottom: 15px; border-spacing: 10px; border-collapse: separate; }
        .stats-box { background: #f1f5f9; padding: 10px; border-radius: 5px; text-align: center; border: 1px solid #e2e8f0; }
        
        table { width: 100%; border-collapse: collapse; }
        th { padding: 8px; font-size: 9px; }
        td { padding: 6px; border: 1px solid #000000; vertical-align: middle; }
        
        .footer { position: fixed; bottom: -30px; left: 0; right: 0; height: 30px; text-align: right; font-size: 8px; color: #94a3b8; }
    </style>
</head>
<body>
    <div class="pdf-header">
        <h1>Waste Material Record</h1>
        <p style="margin: 0; color: #64748b;">Official Inventory Disposal Registry</p>
    </div>

    <table class="stats-container">
        <tr>
            <td class="stats-box"><strong>Total Items:</strong> {{ $disposables->count() }}</td>
            <td class="stats-box"><strong>Total Quantity:</strong> {{ $disposables->sum('quantity') }}</td>
            <td class="stats-box"><strong>Date Generated:</strong> {{ now()->format('M d, Y') }}</td>
        </tr>
    </table>

    <table>
        <thead>
           <tr>
                <th style="background-color: #0070c0; color: #ffffff; font-weight: bold; border: 1px solid #000000; text-align: center; width: 100px;">Property Num.</th>
                <th style="background-color: #0070c0; color: #ffffff; font-weight: bold; border: 1px solid #000000; text-align: center; width: 50px;">QTY</th>
                <th style="background-color: #0070c0; color: #ffffff; font-weight: bold; border: 1px solid #000000; text-align: center; width: 150px;">Unit Value</th>
                <th style="background-color: #0070c0; color: #ffffff; font-weight: bold; border: 1px solid #000000; text-align: center; width: 150px;">Article</th>
                <th style="background-color: #0070c0; color: #ffffff; font-weight: bold; border: 1px solid #000000; text-align: center; width: 250px;">Description</th>
                <th style="background-color: #0070c0; color: #ffffff; font-weight: bold; border: 1px solid #000000; text-align: center; width: 150px;">Accountability Name</th>
                <th style="background-color: #0070c0; color: #ffffff; font-weight: bold; border: 1px solid #000000; text-align: center; width: 100px;">Date Acquired</th>
                <th style="background-color: #0070c0; color: #ffffff; font-weight: bold; border: 1px solid #000000; text-align: center; width: 100px;">Year Disposed</th>
                <th style="background-color: #0070c0; color: #ffffff; font-weight: bold; border: 1px solid #000000; text-align: center; width: 100px;">WMR Num.</th>
            </tr>
        </thead>
        <tbody>
            @foreach($disposables as $item)
                <tr>
                    <td style="text-align: left;">{{ $item->property_number }}</td>
                    <td style="text-align: left; font-style: italic;">{{ $item->description }}</td>
                    <td style="text-align: center;">{{ $item->quantity }}</td>
                    <td style="text-align: left;">{{ strtoupper($item->name) }}</td>
                    <td style="text-align: center;">
                        {{ $item->DateAcquired ? \Carbon\Carbon::parse($item->DateAcquired)->format('m/d/Y') : '-' }}
                    </td>
                    <td style="text-align: center;">{{ $item->year }}</td>
                    <td style="text-align: center; font-weight: bold;">{{ $item->WMR_num }}</td>
                </tr>
            @endforeach
            
            @for ($i = 0; $i < 3; $i++)
                <tr>
                    <td style="height: 25px;"></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
            @endfor
        </tbody>
    </table>

    <div class="footer">
        Generated via System Registry | {{ now()->format('Y-m-d H:i') }}
    </div>
</body>
</html>
