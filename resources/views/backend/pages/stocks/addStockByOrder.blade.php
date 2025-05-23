@extends('backend.layouts.master')

@section('title')
    {{ localize('Phiếu Xuất Kho') }} {{ getSetting('title_separator') }} {{ getSetting('system_title') }}
@endsection


@section('contents')
    <section class="tt-section pt-4">
        <div class="container">
            <div class="row mb-4 g-4">

                <!--left sidebar-->
                <div class="col-xl-12 order-2 order-md-2 order-lg-2 order-xl-1">
                    <form action="{{ route('admin.stocks.storeStockInOut') }}" method="POST" class="pb-650">
                        <input type="hidden" name="order_id" value="{{ $order_id }}" />
                        @csrf
                        <!--basic information start-->
                        <div class="card mb-4" id="section-1">
                            <div class="card-body">
                                <!-- submit button -->
                                <div class="row">
                                    <div class="col-9">
                                        <h5 class="mb-3">{{ localize('Phiếu Xuất Kho') }} - Đơn hàng <span class="text-accent">#SuOne:{{$order_id}}</span></h5>
                                        
                                    </div>
                                    <div class="col-3">
                                        <div class="mb-3">
                                            <button class="btn btn-primary" type="submit"> 
                                                <i data-feather="save" class="me-1"></i> {{ localize('Lưu phiếu') }}
                                            </button>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="mb-3">
                                            <label for="name" class="form-label">{{ localize('Kho') }}</label>
                                            <select class="select2 form-control" name="location_id" required>
                                                <option value="">{{ localize('Chọn kho') }}</option>
                                                @foreach ($locations as $location)
                                                    <option value="{{ $location->id }}" @if ($location->id == $location_id) selected  @endif >
                                                        {{ $location->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="mb-3">
                                            <label for="name" class="form-label">{{ localize('Loại phiếu') }}</label>
                                            <select class="select2 form-control" name="type" required disabled>
                                                <option value="">{{ localize('Chọn loại phiếu') }}</option>
                                                <option value="1" selected>Phiếu xuất kho</option>
                                                <option value="2">Phiếu nhập kho</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="mb-3">
                                            <label for="name" class="form-label">{{ localize('Ghi chú') }}</label>
                                            <textarea class="form-control" name="note"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <!-- submit button end -->

                                <div>
                                    <div class="vs-component vs-con-table stripe vs-table-primary">
                                      <div class="con-tablex vs-table--content">
                                        <div class="vs-con-tbody vs-table--tbody ">
                                            <table class="table tt-footable border-top" data-use-parent-width="true">
                                                <thead>
                                                    <tr>
                                                        <th class="text-center">{{ localize('#') }}</th>
                                                        <th>{{ localize('Tên sản phẩm') }}</th>
                                                        <th class="text-end">{{ localize('Số lượng tồn kho') }}</th>
                                                        <th data-breakpoints="xs sm"  class="text-end">{{ localize('Số lượng xuất') }}</th>
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
                                                            <td class="text-end">
                                                                {{ $product->stock_qty }}
                                                            </td>
                                                            <td class="text-end">
                                                                @foreach($orderItems AS $item)
                                                                    @if($item->product_variation_id == $product->id)
                                                                        @if($item->qty > $product->stock_qty)
                                                                        <strong style="color:red">{{$item->qty}}</strong>
                                                                        @else
                                                                        <strong style="color:green">{{$item->qty}}</strong>   
                                                                        @endif
                                                                    @else
                                                                    <strong>0</strong>   
                                                                    @endif
                                                               @endforeach
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
                        </div>
                        <!--basic information end-->

                        
                    </form>
                    
                </div>
                
            </div>
        </div>
    </section>
@endsection
