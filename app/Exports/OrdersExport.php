<?php

namespace App\Exports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class OrdersExport implements FromCollection,WithHeadings, WithColumnWidths, WithStyles
{
    protected $orders;
    public function __construct($orders)
    {
        $this->orders = $orders;
    }

    public function collection()
    {
        return  collect($this->orders);
    }

    public function columnWidths(): array
    {
        return [
            'A' => 5,   // Cột A (ví dụ: ID)
            'B' => 25,  // Cột B (ví dụ: Name)
            'C' => 20,  // Cột C (ví dụ: Email)
            'D' => 15,
            'E' => 20,
            'F' => 20,
            'G' => 20,
            'H' => 20,
            'I' => 20,
            'J' => 20,
        ];
    }

    public function headings(): array
    {
        return [
            "STT",
            "Tên Khách hàng",
            "Tệp khách",
            "Mã đơn hàng",
            "Ngày tạo",
            "Tổng tiền hàng",
            "Phí ship",
            "Thành tiền",
            "Trạng thái thanh toán",
            "Trạng thái giao hàng",
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
