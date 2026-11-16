<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Order Sales & Profit Report - Print</title>
    <style>
        * {
            box-sizing: border-box;
        }
        body {
            font-family: Arial, Helvetica, sans-serif;
            color: #111827;
            margin: 16px;
            font-size: 11px;
            line-height: 1.35;
        }
        .toolbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 14px;
            padding: 10px 12px;
            background: #f8fafc;
            border: 1px solid #cbd5e1;
            border-radius: 6px;
        }
        .btn {
            display: inline-block;
            padding: 6px 12px;
            font-size: 12px;
            font-weight: 600;
            text-decoration: none;
            border-radius: 4px;
            border: 1px solid transparent;
            cursor: pointer;
        }
        .btn-primary {
            background: #16a34a;
            color: #fff;
        }
        .btn-secondary {
            background: #fff;
            color: #334155;
            border-color: #cbd5e1;
        }
        .print-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            border-bottom: 2px solid #1e293b;
            padding-bottom: 10px;
            margin-bottom: 12px;
        }
        .print-header h1 {
            margin: 0 0 2px 0;
            font-size: 18px;
        }
        .print-header p {
            margin: 0;
            color: #475569;
            font-size: 11px;
        }
        .meta {
            text-align: right;
            font-size: 11px;
        }
        .filters {
            margin-bottom: 10px;
            color: #475569;
            font-size: 11px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        thead {
            display: table-header-group;
        }
        tfoot {
            display: table-row-group;
        }
        tr {
            page-break-inside: avoid;
            break-inside: avoid;
        }
        th, td {
            border: 1px solid #334155;
            padding: 4px 5px;
            vertical-align: top;
        }
        th {
            background: #f1f5f9;
            font-weight: 700;
            text-align: left;
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
        }
        .text-center { text-align: center; }
        .text-end { text-align: right; }
        .fw-bold { font-weight: 700; }
        .tfoot-total th {
            background: #f8fafc;
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
        }
        .tfoot-net th {
            background: #dcfce7;
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
        }
        @media print {
            body {
                margin: 0;
            }
            .no-print {
                display: none !important;
            }
        }
    </style>
</head>
<body>
    @php
        $startDate = request('start_date');
        $endDate = request('end_date');
        $reqStatus = request('order_status', 'delivered_completed');
        $selSt = $order_statuses->firstWhere('id', $reqStatus);
        $statusLabel = $reqStatus == 'all'
            ? 'All Statuses'
            : ($reqStatus == 'delivered_completed' ? 'Completed & Delivered' : ($selSt->name ?? 'Completed & Delivered'));
    @endphp

    <div class="toolbar no-print">
        <div>
            <strong>Full Print View</strong> &mdash; {{ $orders->total() }} entries loaded
        </div>
        <div>
            <button type="button" class="btn btn-primary" onclick="window.print()">Print Now</button>
            <a href="{{ route('admin.order_report', request()->except(['print', 'page'])) }}" class="btn btn-secondary">Back to Report</a>
        </div>
    </div>

    <div class="print-header">
        <div>
            <h1>{{ $generalsetting->name ?? 'OnekkisuBD' }}</h1>
            <p>Order Sales &amp; Profit Statement ({{ $orders->total() }} entries)</p>
        </div>
        <div class="meta">
            <div>Generated On: <strong>{{ date('d M, Y h:i A') }}</strong></div>
            <div>Net Sales: <strong>৳{{ number_format($total_sales - $discounts, 2) }}</strong> | Net Profit: <strong>৳{{ number_format($total_sales - $totalPurchase - $discounts, 2) }}</strong></div>
        </div>
    </div>

    <div class="filters">
        @if(request('keyword')) <span><strong>Search:</strong> "{{ request('keyword') }}" &bull; </span> @endif
        <span><strong>Status:</strong> {{ $statusLabel }} &bull; </span>
        @if(request('user_id'))
            @php $selUsr = $users->firstWhere('id', request('user_id')); @endphp
            <span><strong>Assigned:</strong> {{ $selUsr->name ?? 'Selected' }} &bull; </span>
        @endif
        <span><strong>Date Range:</strong> {{ $startDate ? date('d M, Y', strtotime($startDate)) : 'All Time' }} to {{ $endDate ? date('d M, Y', strtotime($endDate)) : 'Present' }}</span>
    </div>

    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Order ID</th>
                <th>Date</th>
                <th>Customer</th>
                <th>Phone</th>
                <th>Address</th>
                <th>Product Name</th>
                <th class="text-center">Qty</th>
                <th class="text-end">Purchase</th>
                <th class="text-end">Sale Price</th>
                <th class="text-end">Item Total</th>
                <th class="text-end">Profit</th>
                <th class="text-center">Status</th>
                <th class="text-center">Order Type</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($orders as $value)
                @php
                    $order = $value->order;
                    $unitPurchase = ($value->purchase_price && $value->purchase_price > 0)
                        ? (float) $value->purchase_price
                        : (float) ($value->product->purchase_price ?? 0);
                    $unitSale = (float) ($value->sale_price ?? 0);
                    $qty = (int) ($value->qty ?? 1);
                    $itemTotal = $qty * $unitSale;
                    $itemPurchaseTotal = $qty * $unitPurchase;
                    $itemProfit = $itemTotal - $itemPurchaseTotal;
                    $customerName = $value->shipping ? $value->shipping->name : ($order && $order->customer ? $order->customer->name : 'N/A');
                    $customerPhone = $value->shipping ? $value->shipping->phone : ($order && $order->customer ? $order->customer->phone : 'N/A');
                    $customerAddress = $value->shipping ? $value->shipping->address : ($order && $order->customer ? $order->customer->address : 'N/A');
                    $statusName = ($order && $order->status) ? $order->status->name : 'Unknown';
                @endphp
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td class="fw-bold">{{ $order ? '#' . $order->invoice_id : 'N/A' }}</td>
                    <td>{{ $value->created_at ? $value->created_at->format('d M, Y') : ($order && $order->created_at ? $order->created_at->format('d M, Y') : '') }}</td>
                    <td>{{ $customerName }}</td>
                    <td>{{ $customerPhone }}</td>
                    <td>{{ Str::limit($customerAddress, 45) }}</td>
                    <td>
                        {{ $value->product_name }}
                        @if($value->product_size || $value->product_color)
                            <br><small>{{ implode(' / ', array_filter([$value->product_size, $value->product_color])) }}</small>
                        @endif
                    </td>
                    <td class="text-center fw-bold">{{ $qty }}</td>
                    <td class="text-end">৳{{ number_format($unitPurchase, 2) }}</td>
                    <td class="text-end">৳{{ number_format($unitSale, 2) }}</td>
                    <td class="text-end fw-bold">৳{{ number_format($itemTotal, 2) }}</td>
                    <td class="text-end fw-bold">৳{{ number_format($itemProfit, 2) }}</td>
                    <td class="text-center">{{ $statusName }}</td>
                    <td class="text-center">{{ $order && $order->order_type ? ucfirst($order->order_type) : 'Online' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="14" class="text-center">No order records found matching the specified criteria.</td>
                </tr>
            @endforelse
        </tbody>
        <tfoot>
            <tr class="tfoot-total">
                <th colspan="7" class="text-end">Total Items Sold:</th>
                <th class="text-center">{{ number_format($total_item) }}</th>
                <th class="text-end">Cost: ৳{{ number_format($totalPurchase, 2) }}</th>
                <th colspan="2" class="text-end">Gross Sales: ৳{{ number_format($total_sales, 2) }}</th>
                <th colspan="3" class="text-center">Discount: ৳{{ number_format($discounts, 2) }}</th>
            </tr>
            <tr class="tfoot-net">
                <th colspan="8" class="text-end">Net Sales (Revenue):</th>
                <th colspan="3">৳{{ number_format($total_sales - $discounts, 2) }}</th>
                <th colspan="2" class="text-end">Total Net Profit:</th>
                <th class="text-center">৳{{ number_format($total_sales - $totalPurchase - $discounts, 2) }}</th>
            </tr>
        </tfoot>
    </table>

    <script>
        window.addEventListener('load', function () {
            window.print();
        });
    </script>
</body>
</html>
