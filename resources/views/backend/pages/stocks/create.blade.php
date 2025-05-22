@extends('backend.layouts.master')

@section('title')
    {{ localize('Add Stock') }} {{ getSetting('title_separator') }} {{ getSetting('system_title') }}
@endsection


@section('contents')
    <section class="tt-section pt-4">
        <div class="container">
            <div class="row mb-4 g-4">

                <!--left sidebar-->
                <div class="col-xl-12 order-2 order-md-2 order-lg-2 order-xl-1">
                    <form action="{{ route('admin.stocks.create') }}" method="GET" class="pb-650">
                        @csrf
                        <!--basic information start-->
                        <div class="card mb-4" id="section-1">
                            <div class="card-body">
                                <h5 class="mb-3">{{ localize('Thông tin kho hàng') }}</h5>
                                <!-- submit button -->
                                <div class="row">
                                    <div class="col-9">
                                        <div class="mb-3">
                                            <select class="select2 form-control" name="location_id" onchange="submit()" required>
                                                <option value="">{{ localize('Chọn kho') }}</option>
                                                @foreach ($locations as $location)
                                                    <option value="{{ $location->id }}" @if ($location->id == $location_id) selected  @endif >
                                                        {{ $location->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-3">
                                        <div class="mb-3">
                                            <a href="{{ route('admin.stocks.createStockInOut') }}" class="btn btn-primary"> 
                                                <i data-feather="plus" class="me-1"></i> {{ localize('Thêm phiếu xuất nhập kho') }}
                                            </a>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="vs-component vs-con-table stripe vs-table-primary">
                                          <div class="con-tablex vs-table--content">
                                            <div class="vs-con-tbody vs-table--tbody ">
                                                <table class="table tt-footable border-top" data-use-parent-width="true">
                                                    <thead>
                                                        <tr>
                                                            <th class="text-center">{{ localize('#') }}</th>
                                                            <th>{{ localize('Tên sản phẩm') }}</th>
                                                            <th data-breakpoints="xs sm">{{ localize('Số lượng tồn kho') }}</th>
                                                            </th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($products as $key => $product)
                                                            <tr>
                                                                <td class="text-center">
                                                                    {{ $key + 1  }}
                                                                </td>
                                                                
                                                                <td>
                                                                    {{ $product->name }}
                                                                </td>
                                                                <td>
                                                                    {{ $product->stock_qty }}
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                          </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- submit button end -->

                                
                            </div>
                        </div>
                        <!--basic information end-->

                        
                    </form>
                    
                </div>
                
            </div>
        </div>
    </section>
@endsection
