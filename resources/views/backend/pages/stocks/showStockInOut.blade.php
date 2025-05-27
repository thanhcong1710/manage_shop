@extends('backend.layouts.master')

@section('title')
    {{ localize('Thông tin phiếu xuất nhập kho') }} {{ getSetting('title_separator') }} {{ getSetting('system_title') }}
@endsection

@section('contents')
    <section class="tt-section pt-4">
        <div class="container">
            <div class="row mb-3">
                <div class="col-12">
                    <div class="card tt-page-header">
                        <div class="card-body d-lg-flex align-items-center justify-content-lg-between">
                            <div class="tt-page-title">
                                <h2 class="h5 mb-lg-0">{{ localize('Thông tin phiếu xuất nhập kho') }} - Mã: {{data_get($stockInOut ,'id')}}</h2>
                            </div>
                            <div class="tt-action">
                                @if($stockInOut->id)
                                <a href="{{ route('admin.stocks.printInvoice', $stockInOut->id) }}" target="__blank" class="btn btn-info">
                                    <i data-feather="printer" width="18"></i>
                                    {{ localize('In') }}
                                </a>
                                @endif
                                {{-- @can('add_staffs') --}}
                                <a href="{{ route('admin.stocks.indexStockInOut') }}" class="btn btn-dark"> 
                                    <i data-feather="log-out" class="me-1"></i> {{ localize('Thoát') }}
                                </a>
                                {{-- @endcan --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row g-4">
                <div class="col-12">
                    <div class="card mb-4" id="section-1" style="padding: 20px">
                        <div >
                            <div class="mb-2">
                                <p class="mb-1">Loại phiếu: <strong>{{data_get($stockInOut ,'type') ==1 ? "Phiếu xuất kho" : "Phiếu nhập kho"}}</strong></p>
                                <p class="mb-1">Thời gian tạo: {{data_get($stockInOut ,'created_at')}}</p>
                                <p class="mb-1">Người tạo: {{data_get($stockInOut ,'creator.name')}}</p>
                                <p class="mb-1">Ghi chú: {{data_get($stockInOut ,'note')}}</p>
                            </div>
                            <div class="vs-component vs-con-table stripe vs-table-primary">
                              <div class="con-tablex vs-table--content">
                                <div class="vs-con-tbody vs-table--tbody ">
                                    <table class="table tt-footable border-top" data-use-parent-width="true">
                                        <thead>
                                            <tr>
                                                <th class="text-center">{{ localize('#') }}</th>
                                                <th>{{ localize('Tên sản phẩm') }}</th>
                                                <th data-breakpoints="xs sm" class="text-end">{{ localize('Số lượng điều chỉnh') }}</th>
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
                                                        {{ $product->num }}
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
            </div>
        </div>
    </section>
@endsection

