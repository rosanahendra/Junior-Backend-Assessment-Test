<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Events\AfterSheet;
use Illuminate\Support\Facades\DB;

class ExportCommission_collective implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    use Exportable;
    protected $core_code;

    public function __construct($core_code) 
    {
        $this->core_code = $core_code;
    }

    public function collection()
    {
        return DB::table('commission_collective as a')
               ->join('bank as b', 'b.bank_id', '=', 'a.bank_id_to')
               ->select('a.memb_name_account as memb_name_account', 'b.bank_name as bank_name', 'a.memb_number_account as memb_number_account', 'a.coco_total as coco_total')
               ->where('a.core_code', $this->core_code)->get();
    }

    public function headings(): array
    {
        return ["Nama Pemilik Rekening", "Bank", "Nomor Rekening", "Total"];
    }
}
