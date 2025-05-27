<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ localize('INVOICE') }}</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta charset="UTF-8">
    <style type="text/css">
        @font-face {
            font-family: 'THSarabunNew';
            font-style: normal;
            font-weight: normal;
            src: url("{{ asset('fonts/' . $font_family) }}") format('truetype');
        }

        body {
            font-family: 'THSarabunNew';
        }


        * {
            box-sizing: border-box;

        }

        pre,
        p {
            padding: 0;
            margin: 0;

        }

        table {
            width: 100%;
            border-collapse: collapse;
            padding: 1px;

        }

        td,
        th {
            text-align: left;

        }

        .visibleMobile {
            display: none;

        }

        .hiddenMobile {
            display: block;

        }
    </style>
</head>

<body>
    {{-- header start --}}
    <table style="width: 100%; table-layout: fixed">
        <tr>
            <td colspan="4" style=" width: 300px; color: #323232; line-height: 1.5; vertical-align: top;">
                <p style="font-size: 12px;  font-weight: bold; line-height: 1; vertical-align: top; ">
                    Đơn vị: CÔNG TY TNHH TẬP ĐOÀN SUONE</p>
                <p style="font-size: 12px;  font-weight: bold; line-height: 1; vertical-align: top; ">
                    Bộ phận: Kho</p>
            </td>
            <td colspan="4"
                style="width: 300px; text-align: center; padding-left: 50px; line-height: 1.5; color: #323232;">
                <p style="font-size: 12px;font-weight: bold;  line-height: 1; vertical-align: top; ">
                    Mẫu số 02 - VT</p>
                <p style="font-size: 12px;  line-height: 24px; vertical-align: top;">
                    (Ban hành theo Thông tư số 133/2016/TT-BTC </p>
                <p style="font-size: 12px;  line-height: 24px; vertical-align: top;">
                    Ngày 26/08/2016 của Bộ Tài chính)</p>
                </p>
            </td>
        </tr>
        <tr>
            <td colspan="8"
                style=" width: 300px; color: #323232; text-align: center; line-height: 1.5; vertical-align: top;">
                <p style="font-size: 14px;  font-weight: bold; line-height: 1; vertical-align: top; ">
                    PHIẾU XUẤT KHO</p>
                <p style="font-size: 12px;  line-height: 1; vertical-align: top; ">
                    Ngày: {{$created_date}}</p>
                <p style="font-size: 12px; font-weight: bold;  line-height: 1; vertical-align: top; ">
                    Số: {{$invoice_id}}</p>
            </td>
        </tr>
        <tr>
            <td colspan="6">
            </td>
            <td colspan="2"
                style=" width: 300px; color: #323232; text-align: center; line-height: 1.5; vertical-align: top;">
                <p style="font-size: 12px;  line-height: 1; vertical-align: top; ">
                    Nợ: ............</p>
                <p style="font-size: 12px;  line-height: 1; vertical-align: top; ">
                    Có: ............</p>
            </td>
        </tr>
        <tr>
            <td colspan="5" style=" color: #323232; text-align: left; line-height: 1.5; vertical-align: top;">
                <p style="font-size: 12px;  line-height: 1; vertical-align: top; ">
                    - Họ và tên người nhận: {{optional($order->user)->name }}</p>
                <p style="font-size: 12px;  line-height: 1; vertical-align: top; ">
                    - Lý do xuất: <strong>Xuất bán</strong></p>
                <p style="font-size: 12px;  line-height: 1; vertical-align: top;">
                    - Xuất tại kho:  </p>
            </td>
            <td colspan="3" style="color: #323232; text-align: left; line-height: 1.5; vertical-align: top;">
                <p style="font-size: 12px;  line-height: 1; vertical-align: top; ">
                    - SĐT: {{optional($order->user)->phone }}</p>
            </td>
        </tr>
    </table>
    {{-- header end --}}


    {{-- item details start --}}
    <table width="100%" border="0" cellpadding="0" cellspacing="0" align="center" class="fullTable"
        bgcolor="#ffffff">
        <tbody>
            <tr>
                <td>
                    <table width="600" border="0" cellpadding="0" cellspacing="0" align="center"
                        class="fullTable" bgcolor="#ffffff">
                        <tbody>
                            <tr class="visibleMobile">
                                <td height="40"></td>
                            </tr>
                            <tr>
                                <td>
                                    <table width="100%" border="1" cellpadding="3" cellspacing="0" align="center"
                                        class="fullPadding table-products">
                                        <tbody>
                                            <tr>
                                                <th width="5%" align="center" rowspan="2">
                                                    STT
                                                </th>
                                                <th width="30%" align="center" rowspan="2">
                                                    Tên, nhãn hiệu, quy cách, phẩm chất vật tư, dụng cụ,sp, hàng hoá
                                                </th>
                                                <th width="5%" align="center" rowspan="2">
                                                    Mã số
                                                </th>
                                                <th width="10%" align="center" rowspan="2">
                                                    ĐVT
                                                </th>
                                                <th width="20%" align="center" colspan="2">
                                                    Số lượng
                                                </th>
                                                <th width="10%" align="center" rowspan="2">
                                                    Đơn giá
                                                </th>
                                                <th width="10%" align="center" rowspan="2">
                                                    Thành tiền
                                                </th>
                                                <th width="10%" align="center" rowspan="2">
                                                    Ghi chú
                                                </th>
                                            </tr>
                                            <tr>
                                                <td>Theo chứng từ</td>
                                                <td>Thực xuất</td>
                                            </tr>
                                            <tr>
                                                <td>A</td>
                                                <td>B</td>
                                                <td>C</td>
                                                <td>D</td>
                                                <td>1</td>
                                                <td>2</td>
                                                <td>3</td>
                                                <td>4</td>
                                                <td></td>
                                            </tr>
                                            @php
                                                $total_qty = 0;
                                            @endphp
                                            @foreach ($order->orderItems as $key => $item)
                                                @php
                                                    $product = $item->product_variation->productWithTrashed;
                                                    $total_qty += $item->qty;
                                                @endphp
                                                <tr>
                                                    <td>{{$key+1}}</td>
                                                    <td>
                                                        <div>{{ $product->collectLocalization('name') }}</div>
                                                    </td>
                                                    <td></td>
                                                    <td>Hộp</td>
                                                    <td>{{ $item->qty }}</td>
                                                    <td>{{ $item->qty }}</td>
                                                    <td>{{ formatPrice($item->unit_price, false,false,false) }}</td>
                                                    <td>{{ formatPrice($item->total_price, false,false,false) }}</td>
                                                    <td>{{$item->unit_price >0 ? '' : 'Tặng'}}</td>
                                                </tr>
                                            @endforeach
                                            <tr>
                                                <td></td>
                                                <td><b>Cộng</b></td>
                                                <td></td>
                                                <td></td>
                                                <td><b>{{$total_qty}}</b></td>
                                                <td><b>{{$total_qty}}</b></td>
                                                <td></td>
                                                <td><b>{{ formatPrice($total_amount, false,false,false) }}</b></td>
                                                <td></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
        </tbody>
    </table>

    {{-- footer start --}}
    <table width="100%" border="0" cellpadding="0" cellspacing="0" align="center" class="fullTable"
        bgcolor="#ffffff" style="margin-top: 20px">

        <tr>
            <td colspan="8"
                style=" width: 300px; color: #323232; text-align: left; line-height: 1.5; vertical-align: top;">
                <p style="font-size: 12px;  line-height: 1; vertical-align: top; ">
                    - Tổng số tiền: <i>{{ $total_amount_text }}</i></p>
                <p style="font-size: 12px;  line-height: 1; vertical-align: top;">
                    - Số chứng từ gốc kèm theo: .....................................................</p>
            </td>
        </tr>
    </table>
    <table width="100%" border="0" cellpadding="0" cellspacing="0" align="center" class="fullTable"
        bgcolor="#ffffff" style="margin-top: 20px">
        <tr>
            <td colspan="2"
                style=" width:130px; color: #323232; text-align: center; line-height: 1.5; vertical-align: top;">
                <p style="font-size: 12px;  line-height: 1; vertical-align: top; ">
                    Người lập phiếu</p>
                <p style="font-size: 12px;  line-height: 1; vertical-align: top; ">
                    <i>(Ký, họ tên)</i>
                </p>
            </td>
            <td colspan="2"
                style=" width:130px; color: #323232; text-align: center; line-height: 1.5; vertical-align: top;">
                <p style="font-size: 12px;  line-height: 1; vertical-align: top; ">
                    Người nhận hàng</p>
                <p style="font-size: 12px;  line-height: 1; vertical-align: top; ">
                    <i>(Ký, họ tên)</i>
                </p>
            </td>
            <td colspan="2"
                style=" width:130px; color: #323232; text-align: center; line-height: 1.5; vertical-align: top;">
                <p style="font-size: 12px;  line-height: 1; vertical-align: top; ">
                    Thủ kho</p>
                <p style="font-size: 12px;  line-height: 1; vertical-align: top; ">
                    <i>(Ký, họ tên)</i>
                </p>
            </td>
            <td colspan="2"
                style="color: #323232; text-align: center; line-height: 1.5; vertical-align: top;">
                <p style="font-size: 12px;  line-height: 1; vertical-align: top; ">
                    Kế toán trưởng</p>
                <p style="font-size: 12px;  line-height: 1; vertical-align: top; ">
                    <i>(Hoặc bộ phận có nhu cầu)</i>
                </p>
            </td>
            <td colspan="2"
                style=" width:130px; color: #323232; text-align: center; line-height: 1.5; vertical-align: top;">
                <p style="font-size: 12px;  line-height: 1; vertical-align: top; ">
                    Giám đốc</p>
                <p style="font-size: 12px;  line-height: 1; vertical-align: top; ">
                    <i>(Ký, họ tên)</i>
                </p>
            </td>
        </tr>
    </table>
    {{-- footer end --}}

</body>
<style>
    .table-products th,
    .table-products td {
        font-size: 12px;
        color: #000000;
        font-weight: normal;
        line-height: 1;
        vertical-align: middle;
        padding: 5px 10px;
        text-align: center;
    }
</style>

</html>
