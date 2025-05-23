@extends('backend.layouts.master')

@section('title')
    {{ localize('Xuất nhập kho') }} {{ getSetting('title_separator') }} {{ getSetting('system_title') }}
@endsection

@section('contents')
    <section class="tt-section pt-4">
        <div class="container">
            <div class="row mb-3">
                <div class="col-12">
                    <div class="card tt-page-header">
                        <div class="card-body d-lg-flex align-items-center justify-content-lg-between">
                            <div class="tt-page-title">
                                <h2 class="h5 mb-lg-0">{{ localize('Xuất nhập kho') }}</h2>
                            </div>
                            <div class="tt-action">
                                {{-- @can('add_staffs') --}}
                                <a href="{{ route('admin.stocks.createStockInOut') }}" class="btn btn-primary"> 
                                    <i data-feather="plus" class="me-1"></i> {{ localize('Thêm phiếu xuất nhập kho') }}
                                </a>
                                {{-- @endcan --}}
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
                                    <div class="col-auto flex-grow-1">
                                        <div class="tt-search-box">
                                            <div class="input-group">
                                                <span class="position-absolute top-50 start-0 translate-middle-y ms-2"> <i
                                                        data-feather="search"></i></span>
                                                <input class="form-control rounded-start w-100" type="text"
                                                    id="search" name="search" placeholder="{{ localize('Nhập mã đơn hàng để tìm kiếm') }}"
                                                    @isset($searchKey)
                                        value="{{ $searchKey }}"
                                        @endisset>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-auto flex-grow-2">
                                        <div class="input-group">
                                            <input type="text" style="min-width: 280px;" name="searchDate"  value="{{$searchDate}}" class="form-select" id="dateRangePicker" placeholder="Chọn khoảng ngày tạo">
                                        </div>
                                    </div>
                                    <div class="col-auto">
                                        <div class="input-group">
                                            <select class="form-select select2" name="type"
                                                data-minimum-results-for-search="Infinity">
                                                <option value="">{{ localize('Chọn loại phiếu') }}</option>

                                                <option value="1"
                                                    @isset($type)
                                                     @if ($type == 1) selected @endif
                                                    @endisset>
                                                    {{ localize('Xuất kho') }}</option>

                                                <option value="2"
                                                    @isset($type)
                                                     @if ($type == 2) selected @endif
                                                    @endisset>
                                                    {{ localize('Nhập kho') }}</option>

                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-auto">
                                        <button type="submit" class="btn btn-primary">
                                            <i data-feather="search" width="18"></i>
                                            {{ localize('Search') }}
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>

                        <table class="table tt-footable border-top" data-use-parent-width="true">
                            <thead>
                                <tr>
                                    <th class="text-center">{{ localize('#') }}</th>
                                    <th>{{ localize('Mã phiếu') }}</th>
                                    <th>{{ localize('Mã đơn hàng') }}</th>
                                    <th>{{ localize('Loại') }}</th>
                                    <th>{{ localize('Thời gian') }}</th>
                                    <th>{{ localize('Người tạo') }}</th>
                                    <th>{{ localize('Ghi chú') }}</th>
                                    <th data-breakpoints="xs sm md" class="text-end">{{ localize('Action') }}
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($stockInOuts as $key => $row)
                                    <tr>
                                        <td class="text-center">
                                            {{ $key + 1 + ($stockInOuts->currentPage() - 1) * $stockInOuts->perPage() }}</td>
                                        </td>
                                        <td>
                                            {{ ($row->type == 1 ? '#PX-' : '#PN-' ).$row->id}}
                                        </td>
                                        <td>
                                            @if($row->order_id)
                                            <span>#SuOne: {{ $row->order_id}}</span>
                                            @endif
                                        </td>
                                        <td>
                                            {{ $row->type == 1 ? 'Xuất kho' : 'Nhập Kho' }}
                                        </td>
                                        <td>
                                            {{ $row->created_at }}
                                        </td>
                                        <td>
                                            {{ data_get($row, 'creator.name') }}
                                        </td>
                                        <td>
                                            {{ $row->note }}
                                        </td>
                                        <td class="text-end">
                                            <a href="{{ route('admin.stocks.showStockInOut', $row->id) }}"
                                                class="btn btn-sm p-0 tt-view-details" data-bs-toggle="tooltip"
                                                data-bs-placement="top" title="View Details">
                                                <i data-feather="eye"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <!--pagination start-->
                        <div class="d-flex align-items-center justify-content-between px-4 pb-4">
                            <span>{{ localize('Showing') }}
                                {{ $stockInOuts->firstItem() }}-{{ $stockInOuts->lastItem() }} {{ localize('of') }}
                                {{ $stockInOuts->total() }} {{ localize('results') }}</span>
                            <nav>
                                {{ $stockInOuts->appends(request()->input())->links() }}
                            </nav>
                        </div>
                        <!--pagination end-->
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('scripts')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script>
    flatpickr("#dateRangePicker", {
      mode: "range",
      dateFormat: "Y-m-d"
    });
  </script>
@endsection
