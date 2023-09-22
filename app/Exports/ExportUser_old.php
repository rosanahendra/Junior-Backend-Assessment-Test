<?php

namespace App\Exports;

use App\Models\Commission_collective;
use Maatwebsite\Excel\Concerns\FromCollection;

class ExportUser implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return DB::table("select * from commission_collective where core_code = '$a'");
    }
}
