<?php

namespace App\Exports;

use App\Classes\Enums\StatusEnum;
use App\Models\Customer;
use App\Models\CustomerAddress;
use App\Models\CustomerContact;
use App\Models\RequestFlow;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class RequestExport implements FromCollection, WithHeadings, ShouldAutoSize
{
    protected $exportData;
    protected $columns;
    protected $exportType;

    public function __construct(array $columns,$exportType,$exportData)
    {
        $this->columns = $columns;
        $this->exportType = $exportType;
        $this->exportData = $exportData;
    }

    public function collection()
    {
        return $this->exportData;
    }

//    public function headings(): array
//    {
//        // Define the custom column headings here
//        return ['Column 1', 'Column 2', 'Column 3'];
//    }

    public function headings(): array
    {
        switch ($this->exportType){
            case StatusEnum::TBC_EXPORT:
                return  [
                    StatusEnum::TBC_EXPORT_COLUMNS,
                    StatusEnum::TBC_EXPORT_COLUMNS_2
                    ];
            case StatusEnum::BOG_EXPORT:
            default:
                return StatusEnum::BOG_EXPORT_COLUMNS;
        }
    }

    public function map($row): array
    {
        return [
            'company_bank_account_number',      /*company bank account number*/
            '', '', // Leave Column 2,3 blank
//            $row->column3,
            'Static Value', // [Supplier.Bank Account]
            'Static Value', // [Supplier. Supplier Name]
            '',
            'cost of goods/services', //[always put "cost of goods/services"]
            '', //[request.amount in GEL]
            '', '', ''
        ];
    }

//
//    /**
//    * @return \Illuminate\Database\Eloquent\Builder
//     */
//    public function query()
//    {
//        switch ($this->exportData){
//            case StatusEnum::BOG_EXPORT:
//                return  RequestFlow::query()->select($this->columns);
//            case StatusEnum::TBC_EXPORT:
//                return  RequestFlow::query()->select($this->columns);
//        }
//    }
//    public function headings(): array
//    {
//        switch ($this->exportData){
//            case StatusEnum::TBC_EXPORT:
//                return  StatusEnum::TBC_EXPORT_COLUMNS;
//            case StatusEnum::BOG_EXPORT:
//            default:
//                return StatusEnum::BOG_EXPORT_COLUMNS;
//        }
//    }
//
//    public function styles(Worksheet $sheet)
//    {
//        return [
//            // Style the first row as bold text.
//            1    => ['font' => ['bold' => true]],
//        ];
//
//    }
//
//    public function collection()
//    {
//        // TODO: Implement collection() method.
//    }
}
