<?php

namespace App\Exports;

use App\Models\Items;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ItemsExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Items::select('id', 'name', 'price')->get();
    }

    /**
     * Define the headings for the columns in the Excel file.
     */
    public function headings(): array
    {
        return ['ID', 'Name', 'Price'];
    }
}
