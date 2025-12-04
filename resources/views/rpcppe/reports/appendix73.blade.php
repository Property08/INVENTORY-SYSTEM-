<!DOCTYPE html>
<html>
<head>
    <title>Appendix 73 - RPCPPE Report</title>
    <style>
        @page { size: legal landscape; margin: 0.25in; }
        body { font-family: "Times New Roman", serif; font-size: 10pt; }
        .header { text-align: center; margin-bottom: 12px; }
        table { width: 100%; border-collapse: collapse; }
        th, td {
            border: 1px solid black; padding: 4px; text-align: center; font-size: 9pt;
        }
        th { background: #e5e7eb; font-weight: bold; }
        .signatories td {
            border: none; padding-top: 30px; text-align: center; font-size: 10pt;
        }
    </style>
</head>
<body>
<div class="header">
    <p><strong>Appendix 73</strong></p>
    <h4>REPORT ON THE PHYSICAL COUNT OF PROPERTY, PLANT AND EQUIPMENT</h4>
    <p>(Type of Property, Plant and Equipment)</p>
</div>

<p>Fund Cluster: __________________________</p>
<p>
    For which (Name of Accountable Officer) ______________________
    (Official Designation) ______________________
    of (Entity Name) ______________________ is accountable,
    having assumed such accountability on (Date of Assumption) ______________________
</p>

<table>
    <thead>
        <tr>
            <th>ARTICLE</th>
            <th>DESCRIPTION</th>
            <th>PROPERTY NUMBER</th>
            <th>UNIT OF MEASURE</th>
            <th>UNIT VALUE</th>
            <th>QTY PER PROPERTY CARD</th>
            <th>QTY PER PHYSICAL COUNT</th>
            <th>SHORT/OVER QTY</th>
            <th>SHORT/OVER VALUE</th>
            <th>REMARKS</th>
        </tr>
    </thead>
    <tbody>
        @forelse($items as $item)
        <tr>
            <td>{{ $item->article }}</td>
            <td>{{ $item->description }}</td>
            <td>{{ $item->property_no }}</td>
            <td>{{ $item->unit_of_measure }}</td>
            <td>{{ number_format($item->unit_value, 2) }}</td>
            <td>{{ $item->quantity_per_property_card }}</td>
            <td>{{ $item->quantity_per_physical_count }}</td>
            <td>{{ $item->shortage_overage_qty }}</td>
            <td>{{ $item->shortage_overage_value }}</td>
            <td>{{ $item->remarks }}</td>
        </tr>
        @empty
        <tr><td colspan="10">No records found.</td></tr>
        @endforelse
    </tbody>
</table>

<br><br>
<table class="signatories" width="100%">
    <tr>
        <td>
            Certified Correct by:<br><br>
            _________________________<br>
            Inventory Committee Chair & Members
        </td>
        <td>
            Approved by:<br><br>
            _________________________<br>
            Head of Agency/Entity
        </td>
        <td>
            Verified by:<br><br>
            _________________________<br>
            COA Representative
        </td>
    </tr>
</table>
</body>
</html>
