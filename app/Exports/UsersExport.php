<?php

namespace App\Exports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class UsersExport implements FromCollection,WithHeadings, WithColumnWidths, WithStyles
{
    protected $users;
    public function __construct($users)
    {
        $this->users = $users;
    }

    public function collection()
    {
        return  collect($this->users);
    }

    public function columnWidths(): array
    {
        return [
            'A' => 5,   // Cột A (ví dụ: ID)
            'B' => 25,  // Cột B (ví dụ: Name)
            'C' => 25,  // Cột C (ví dụ: Email)
            'D' => 25,
            'E' => 20,
            'F' => 20,
            'G' => 20,
            'H' => 20,
            'I' => 20,
            'J' => 20,
            'K' => 20,
            'L' => 20,
        ];
    }

    public function headings(): array
    {
        return [
            "STT",
            "Trưởng team",
            "NTD",
            "Họ và tên ĐL",
            "Mã ĐL",
            "SĐT",
            "Email",
            "Thời gian mua gần nhất",
            "Doanh số",
            "Tổng sản phẩm",
            "Doanh số team",
            "Tổng sản phẩm team"
        ];
    }

    public function styles(Worksheet $sheet)
    {
        // Áp dụng style cho hàng đầu tiên (1 = header row)
        return [
            1 => ['font' => ['bold' => true, 'uppercase' => false]], // Excel không có 'uppercase', nhưng bạn có thể chỉnh font nếu dùng macro
        ];
    }
}
