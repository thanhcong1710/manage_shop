@extends('backend.layouts.master')

@section('title')
    {{ localize('Orders') }} {{ getSetting('title_separator') }} {{ getSetting('system_title') }}
@endsection

@section('contents')
    <section class="tt-section pt-4">
        <div class="container">
            <div class="row mb-3">
                <div class="col-12">
                    <div class="card tt-page-header">
                        <div class="card-body d-lg-flex align-items-center justify-content-lg-between">
                            <div class="tt-page-title">
                                <h2 class="h5 mb-lg-0">{{ localize('Orders') }}</h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row g-4">
                <div class="col-12">
                    <div class="card mb-4" id="section-1">
                        <form class="app-search" action="{{ Request::fullUrl() }}" method="GET">
                            <div class="card-header border-bottom-0">
                                <div class="row justify-content-between g-3">
                                    <div class="col-auto flex-grow-1 d-none">
                                        <div class="tt-search-box">
                                            <div class="input-group">
                                                <span class="position-absolute top-50 start-0 translate-middle-y ms-2"> <i
                                                        data-feather="search"></i></span>
                                                <input class="form-control rounded-start w-100" type="text"
                                                    id="search" name="search"
                                                    placeholder="{{ localize('Search by name/phone') }}"
                                                    @isset($searchKey)
                                                value="{{ $searchKey }}"
                                                @endisset>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-auto flex-grow-1">
                                        <div class="input-group mb-3">
                                            @if (getSetting('order_code_prefix') != null)
                                                <div class="input-group-prepend">
                                                    <span
                                                        class="input-group-text rounded-end-0">{{ getSetting('order_code_prefix') }}</span>
                                                </div>
                                            @endif
                                            <input type="text" class="form-control" placeholder="{{ localize('code') }}"
                                                name="code" id="searchCode"
                                                @isset($searchCode)
                                                value="{{ $searchCode }}"
                                                @endisset>
                                        </div>
                                    </div>
                                    <div class="col-auto">
                                        <select class="form-select select2" name="payment_status"
                                            data-minimum-results-for-search="Infinity" id="payment_status">
                                            <option value="">{{ localize('Payment Status') }}</option>
                                            <option value="{{ paidPaymentStatus() }}"
                                                @if (isset($paymentStatus) && $paymentStatus == paidPaymentStatus()) selected @endif>
                                                {{ localize('Paid') }}</option>
                                            <option value="{{ unpaidPaymentStatus() }}"
                                                @if (isset($paymentStatus) && $paymentStatus == unpaidPaymentStatus()) selected @endif>
                                                {{ localize('Unpaid') }}</option>
                                        </select>
                                    </div>


                                    @if (request()->routeIs('admin.orders.index'))
                                        <div class="col-auto">
                                            <select class="form-select select2" name="delivery_status"
                                                data-minimum-results-for-search="Infinity" id="update_delivery_status">
                                                <option value="">{{ localize('Delivery Status') }}</option>
                                                <option value="order_placed"
                                                    @if (isset($deliveryStatus) && $deliveryStatus == orderPlacedStatus()) selected @endif>
                                                    {{ localize('Order Placed') }}</option>
                                                <option value="pending" @if (isset($deliveryStatus) && $deliveryStatus == orderPendingStatus()) selected @endif>
                                                    {{ localize('Pending') }}
                                                <option value="processing"
                                                    @if (isset($deliveryStatus) && $deliveryStatus == orderProcessingStatus()) selected @endif>
                                                    {{ localize('Processing') }}
                                                <option value="delivered" @if (isset($deliveryStatus) && $deliveryStatus == orderDeliveredStatus()) selected @endif>
                                                    {{ localize('Delivered') }}
                                                <option value="cancelled"
                                                    @if (isset($deliveryStatus) && $deliveryStatus == orderCancelledStatus()) selected @endif>
                                                    {{ localize('Cancelled') }}
                                                </option>
                                            </select>
                                        </div>
                                    @endif

                                    <div class="col-auto flex-grow-2">
                                        <div class="input-group">
                                            <input type="text" style="min-width: 280px;" name="searchDate"  value="{{$searchDate}}" class="form-select" id="dateRangePicker" placeholder="Chọn khoảng ngày tạo">
                                        </div>
                                    </div>

                                    {{-- <div class="col-auto">
                                        <select class="form-select select2" name="is_pos_order"
                                            data-minimum-results-for-search="Infinity" id="is_pos_order">
                                            <option value="0" @if (isset($posOrder) && $posOrder == 0) selected @endif>
                                                {{ localize('Online Orders') }}
                                            </option>
                                            <option value="1" @if (isset($posOrder) && $posOrder == 1) selected @endif>
                                                {{ localize('POS Orders') }}
                                            </option>
                                        </select>
                                    </div> --}}
                                    <div class="col-auto">
                                        <button type="submit" class="btn btn-info">
                                            <i data-feather="search" width="18"></i>
                                            {{ localize('Search') }}
                                        </button>
                                        <button type="button" class="btn btn-primary" onclick="exportDataOrder()"> <i
                                            data-feather="download"></i> {{ localize('Export') }}</button>
                                    </div>
                                </div>
                            </div>
                        </form>

                        <table class="table tt-footable border-top align-middle" data-use-parent-width="true">
                            <thead>
                                <tr>
                                    <th class="text-center">{{ localize('S/L') }}
                                    </th>
                                    <th>{{ localize('Order Code') }}</th>
                                    <th data-breakpoints="xs sm md">{{ localize('Customer') }}</th>
                                    <th>{{ localize('Thời gian tạo') }}</th>
                                    <th data-breakpoints="xs">{{ localize('Items') }}</th>
                                    <th data-breakpoints="xs sm">{{ localize('Payment') }}</th>
                                    <th data-breakpoints="xs sm">{{ localize('Status') }}</th>
                                    {{-- <th data-breakpoints="xs sm">{{ localize('Type') }}</th> --}}
                                    {{-- @if (count($locations) > 0)
                                        <th data-breakpoints="xs sm">{{ localize('Location') }}</th>
                                    @endif --}}
                                    <th data-breakpoints="xs sm" class="text-end">{{ localize('Action') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($orders as $key => $order)
                                    <tr>
                                        <td class="text-center">
                                            {{ $key + 1 + ($orders->currentPage() - 1) * $orders->perPage() }}</td>

                                        <td class="fs-sm">
                                            {{ getSetting('order_code_prefix') }}{{ $order->orderGroup->order_code }}
                                        </td>

                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="avatar avatar-md">
                                                    <img class="rounded-circle"
                                                        src="{{ uploadedAsset(optional($order->user)->avatar) }}"
                                                        alt="avatar"
                                                        onerror="this.onerror=null;this.src='{{ staticAsset('backend/assets/img/placeholder-thumb.png') }}';" />
                                                </div>
                                                <div class="ms-2">
                                                    <h6 class="fs-sm mb-0">{{ optional($order->user)->name }}</h6>
                                                    <span class="text-muted fs-sm">
                                                        {{ optional($order->user)->phone ?? '-' }}</span>
                                                </div>
                                            </div>
                                        </td>

                                        <td>
                                            <span class="fs-sm">{{ date('Y-m-d H:i:s', strtotime($order->created_at)) }}</span>
                                        </td>

                                        <td class="tt-tb-price">
                                            <span class="fw-bold">
                                                {{ $order->orderItems()->count() }}
                                            </span>
                                        </td>

                                        <td>
                                            @if ($order->payment_status == unpaidPaymentStatus())
                                                <span class="badge bg-soft-danger rounded-pill text-capitalize">
                                                    {{ localize($order->payment_status) }}
                                                </span>
                                            @else
                                                <span class="badge bg-soft-primary rounded-pill text-capitalize">
                                                    {{ localize($order->payment_status) }}
                                                </span>
                                            @endif
                                        </td>


                                        <td>
                                            @if ($order->delivery_status == orderDeliveredStatus())
                                                <span class="badge bg-soft-primary rounded-pill text-capitalize">
                                                    {{ localize($order->delivery_status) }}
                                                </span>
                                            @elseif($order->delivery_status == orderCancelledStatus())
                                                <span class="badge bg-soft-danger rounded-pill text-capitalize">
                                                    {{ localize(Str::title(Str::replace('_', ' ', $order->delivery_status))) }}
                                                </span>
                                            @else
                                                <span class="badge bg-soft-info rounded-pill text-capitalize">
                                                    {{ localize(Str::title(Str::replace('_', ' ', $order->delivery_status))) }}
                                                </span>
                                            @endif
                                        </td>

                                        {{-- <td>
                                            <span
                                                class="badge rounded-pill text-capitalize {{ $order->shipping_delivery_type == getScheduledDeliveryType() ? 'bg-soft-warning' : 'bg-secondary' }}">
                                                {{ Str::title(Str::replace('_', ' ', $order->shipping_delivery_type)) }}
                                            </span>
                                        </td> --}}

                                        {{-- @if (count($locations) > 0)
                                            <td>
                                                <span class="badge rounded-pill text-capitalize bg-secondary">
                                                    @if ($order->location)
                                                        {{ $order->location->name }}
                                                    @else
                                                        {{ localize('N/A') }}
                                                    @endif
                                                </span>
                                            </td>
                                        @endif --}}

                                        <td class="text-end">
                                            @if (request()->routeIs('admin.deliverymen.cancel-request'))
                                                <a data-note="{{ $order->note }}"
                                                    class="btn btn-sm p-0 tt-view-details note" data-bs-toggle="tooltip"
                                                    data-bs-placement="top" title="View Notes">
                                                    <i data-feather="edit-2"></i>
                                                </a>
                                            @endif
                                           
                                            @can('manage_orders')
                                                <a href="{{ route('admin.orders.show', $order->id) }}"
                                                    class="btn btn-sm p-0 tt-view-details" data-bs-toggle="tooltip"
                                                    data-bs-placement="top" title="View Details">
                                                    <i data-feather="eye"></i>
                                                </a>
                                                <a href="{{ route('admin.orders.printInvoice', $order->id) }}"
                                                    class="btn btn-sm p-0 tt-priint-details" target="__blank" data-bs-toggle="tooltip"
                                                    data-bs-placement="top" title="{{ localize('Print Invoice') }}">
                                                    <i data-feather="printer"></i>
                                                </a>
                                            @endcan
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <!--pagination start-->
                        <div class="d-flex align-items-center justify-content-between px-4 pb-4">
                            <span>{{ localize('Showing') }}
                                {{ $orders->firstItem() }}-{{ $orders->lastItem() }} {{ localize('of') }}
                                {{ $orders->total() }} {{ localize('results') }}</span>
                            <nav>
                                {{ $orders->appends(request()->input())->links() }}
                            </nav>
                        </div>
                        <!--pagination end-->
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="modal fade" id="note" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ localize('Rejection Note') }}</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p id="note"></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary"
                        data-bs-dismiss="modal">{{ localize('Close') }}</button>
                </div>
            </div>
        </div>
    </div>
@endsection


@section('scripts')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script>
        flatpickr("#dateRangePicker", {
            mode: "range",
            dateFormat: "Y-m-d"
        });
        $(function() {
            $(document).on('click', '.note', function() {
                const modal = $('#note')

                modal.find('#note').text($(this).data('note'));

                modal.modal('show')
            })
        })
        function exportDataOrder(){
            var code = $('#searchCode').val();
            var payment_status = $('#payment_status').val();
            var delivery_status = $('#update_delivery_status').val();
            var searchDate = $('#dateRangePicker').val();
            window.open("{{ route('admin.orders.export') }}"+'?code='+code+'&payment_status='+payment_status+'&delivery_status='+delivery_status+'&searchDate='+searchDate, '_blank');
        }
    </script>
@endsection