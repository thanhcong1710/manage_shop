@extends('backend.layouts.master')

@section('title')
    {{ localize('Chính sách bán hàng') }} {{ getSetting('title_separator') }} {{ getSetting('system_title') }}
@endsection

@section('contents')
    <section class="tt-section pt-4">
        <div class="container">
            <div class="row mb-3">
                <div class="col-12">
                    <div class="card tt-page-header">
                        <div class="card-body d-lg-flex align-items-center justify-content-lg-between">
                            <div class="tt-page-title">
                                <h2 class="h5 mb-lg-0">{{ localize('Chính sách bán hàng') }}</h2>
                            </div>
                            <div class="tt-action">
                                {{-- @can('add_staffs') --}}
                                    <a href="{{ route('admin.pricePolice.create') }}" class="btn btn-primary"><i
                                            data-feather="plus"></i> {{ localize('Thêm chính sách') }}</a>
                                {{-- @endcan --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row g-4">
                <div class="col-12">
                    <div class="card mb-4" id="section-1">
                        <table class="table tt-footable border-top" data-use-parent-width="true">
                            <thead>
                                <tr>
                                    <th class="text-center">{{ localize('S/L') }}</th>
                                    <th>{{ localize('Name') }}</th>
                                    <th data-breakpoints="xs sm">{{ localize('Số lượng') }}</th>
                                    <th data-breakpoints="xs sm">{{ localize('Tỷ lệ chiết khấu') }}</th>
                                    <th data-breakpoints="xs sm">{{ localize('Trạng thái') }}</th>
                                    <th data-breakpoints="xs sm" class="text-end">{{ localize('Action') }}
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($pricePolices as $key => $pricePolice)
                                    <tr>
                                        <td class="text-center">
                                            {{ $key + 1 + ($pricePolices->currentPage() - 1) * $pricePolices->perPage() }}
                                        </td>
                                        <td>{{ $pricePolice->name }}</td>
                                        <td  class="text-right">
                                            {{ $pricePolice->num }}
                                        </td>
                                        <td  class="text-right">
                                            {{ $pricePolice->discount_rate }} %
                                        </td>
                                        <td>
                                            {{-- @can('ban_pricePolices') --}}
                                                <div class="form-check form-switch d-flex">
                                                    <input type="checkbox" onchange="updateStatus(this)"
                                                        class="form-check-input"
                                                        @if ($pricePolice->status) checked @endif
                                                        value="{{ $pricePolice->id }}">
                                                </div>
                                            {{-- @endcan --}}
                                        </td>
                                        <td class="text-end">
                                            <div class="dropdown tt-tb-dropdown">
                                                <button type="button" class="btn p-0" data-bs-toggle="dropdown"
                                                    aria-expanded="false">
                                                    <i data-feather="more-vertical"></i>
                                                </button>
                                                <div class="dropdown-menu dropdown-menu-end shadow">

                                                    {{-- @can('edit_pricePolices') --}}
                                                        <a class="dropdown-item"
                                                            href="{{ route('admin.pricePolice.edit', ['id' => $pricePolice->id, 'lang_key' => env('DEFAULT_LANGUAGE')]) }}&localize">
                                                            <i data-feather="edit-3" class="me-2"></i>{{ localize('Edit') }}
                                                        </a>
                                                    {{-- @endcan
                                                    @can('delete_pricePolices') --}}
                                                        <a href="#" class="dropdown-item confirm-delete"
                                                            data-href="{{ route('admin.pricePolice.delete', $pricePolice->id) }}"
                                                            title="{{ localize('Delete') }}">
                                                            <i data-feather="trash-2" class="me-2"></i>
                                                            {{ localize('Delete') }}
                                                        </a>
                                                    {{-- @endcan --}}
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <!--pagination start-->
                        <div class="d-flex align-items-center justify-content-between px-4 pb-4">
                            <span>{{ localize('Showing') }}
                                {{ $pricePolices->firstItem() }}-{{ $pricePolices->lastItem() }} {{ localize('of') }}
                                {{ $pricePolices->total() }} {{ localize('results') }}</span>
                            <nav>
                                {{ $pricePolices->appends(request()->input())->links() }}
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
    <script>
        "use strict";

        function updateStatus(el) {
            if (el.checked) {
                var status = 1;
            } else {
                var status = 0;
            }
            $.post('{{ route('admin.pricePolices.updateStatus') }}', {
                    _token: '{{ csrf_token() }}',
                    id: el.value,
                    status: status
                },
                function(data) {
                    if (data == 1) {
                        notifyMe('success', '{{ localize('Status updated successfully') }}');

                    } else {
                        notifyMe('danger', '{{ localize('Something went wrong') }}');
                    }
                });
        }
    </script>
@endsection
