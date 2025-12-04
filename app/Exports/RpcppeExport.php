<?php

namespace App\Exports;

use App\Models\Rpcppe;
use Maatwebsite\Excel\Concerns\FromCollection;

class RpcppeExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Rpcppe::all();
    }
}
