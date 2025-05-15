@extends('frontend.default.layouts.master')

@section('title')
    {{ localize('Customer Dashboard') }} {{ getSetting('title_separator') }} {{ getSetting('system_title') }}
@endsection

@section('contents')
    <section class="my-account pt-6 pb-120">
        <div class="container">

            @include('frontend.default.pages.users.partials.customerHero')

            <div class="row g-4">
                <div class="col-xl-3">
                    @include('frontend.default.pages.users.partials.customerSidebar')
                </div>

                <div class="col-xl-9">
                    <div class="card">
                        <div class="card-header border-bottom-0">
                            <div class="row justify-content-between g-3">
                                <div class="col-auto flex-grow-1">
                                    <h6 class="mt-4">Thống kê đại lý</h6>
                                </div>
                                <div class="col-auto">
                                    <div class="input-group">
                                        <select class="form-select select2" name="report_type" onchange="getDataTree()" id="report_type" data-minimum-results-for-search="Infinity">
                                            <option value="1" selected>Tháng hiện tại</option>
                                            <option value="2">Tháng trước</option>
                                            <option value="3">Tất cả</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card-body bg-white ">
                            <div id="category-tree"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('scripts')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jstree/3.3.12/themes/default/style.min.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jstree/3.3.12/jstree.min.js"></script>
    <script>
        
        function getDataTree(){
            var report_type = $('#report_type').val();
            $.ajax({
                method: "POST",
                url: "{{ route('customer.dashboard.agency') }}",
                data: {
                    report_type: report_type,
                },
                success: function(response) {
                    const treeData = response
                    if ($('#category-tree').jstree(true)) {
                        $('#category-tree').jstree('destroy');
                    }
                    $('#category-tree').jstree({
                        'core': {
                        'data': treeData
                        }
                    });
                }
            })

        }
        $(function () {
            getDataTree();
        });
    </script>
    <style>
        .jstree-default .jstree-node{
            font-size: 16px;
        }
        .jstree-default .jstree-anchor{
            margin: 2px;
        }
        .jstree-icon.jstree-themeicon-custom {
            width: 16px;
            height: 16px;
            background-size: 100% !important; /* Hoặc 'cover' hoặc '100%' */
        }
    </style>
@endsection