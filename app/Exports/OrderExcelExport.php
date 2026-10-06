<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class OrderExcelExport implements FromQuery, WithHeadings, WithMapping, ShouldAutoSize, WithStyles
{
    protected $query;

    public function __construct($query)
    {
        $this->query = $query;
    }

    public function query()
    {
        return $this->query->with(['shipping', 'customer', 'status', 'user', 'payment', 'orderdetails']);
    }

    public function headings(): array
    {
        return [
            'Invoice ID',
            'Date',
            'Customer Name',
            'Customer Phone',
            'Delivery Address',
            'Delivery Area',
            'Order Type',
            'Products Summary',
            'Subtotal (TK)',
            'Shipping Charge (TK)',
            'Discount (TK)',
            'Total Amount (TK)',
            'Paid Partial (TK)',
            'Due Amount (TK)',
            'Payment Method',
            'Order Status',
            'Assigned Staff',
            'Note',
        ];
    }

    public function map($order): array
    {
        $productsSummary = $order->orderdetails->map(function ($d) {
            return $d->product_name . ' x' . $d->qty . ' (' . ($d->sale_price * $d->qty) . 'tk)';
        })->implode('; ');

        $due = max(0, $order->amount - ($order->paid_partial_payment_amount ?? 0));
        $subtotal = $order->orderdetails->sum(function ($d) {
            return $d->sale_price * $d->qty;
        });

        return [
            $order->invoice_id,
            $order->created_at ? $order->created_at->format('Y-m-d H:i') : '',
            $order->shipping ? $order->shipping->name : ($order->customer ? $order->customer->name : ''),
            $order->shipping ? $order->shipping->phone : '',
            $order->shipping ? $order->shipping->address : '',
            $order->shipping ? $order->shipping->area : '',
            $order->order_type ?? 'Online',
            $productsSummary,
            $subtotal,
            $order->shipping_charge ?? 0,
            $order->discount ?? 0,
            $order->amount,
            $order->paid_partial_payment_amount ?? 0,
            $due,
            $order->payment ? $order->payment->payment_method : 'Cash On Delivery',
            $order->status ? $order->status->name : ('Status ' . $order->order_status),
            $order->user ? $order->user->name : 'Unassigned',
            $order->note ?? '',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => [
                'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => ['rgb' => '4F46E5']
                ]
            ],
        ];
    }
}
