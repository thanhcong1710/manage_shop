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
                            <div id="chart-container"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('scripts')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/orgchart@2.1.9/dist/css/jquery.orgchart.min.css" />
<script src="https://cdn.jsdelivr.net/npm/orgchart@2.1.9/dist/js/jquery.orgchart.min.js"></script>
    <script>
        
        function getDataTree() {
            var report_type = $('#report_type').val();
            $.ajax({
                method: "POST",
                url: "{{ route('customer.dashboard.agency') }}",
                data: {
                    report_type: report_type,
                },
                success: function(response) {
                    $('#chart-container').empty();
                    var datascource = response;
                    var oc = $('#chart-container').orgchart({
                        'data': datascource,
                        'nodeContent': 'title',
                        'pan': true,
                        'zoom': true
                    });

                }
            })

        }
        $(function () {
            getDataTree();
        });
    </script>
    <style>
        #chart-container {
            font-family: Arial;
            height: 420px;
            border: 2px dashed #aaa;
            border-radius: 5px;
            overflow: auto;
            text-align: center;
        }
        .orgchart .node .title{
            width: 220px;
            font-size: 16px;
            height: 28px;
        }
        .orgchart .node .content{
            font-size: 13px;
            height: 50px;
        }
        .orgchart {
            background: #fff;
        }

        .orgchart td.left,
        .orgchart td.right,
        .orgchart td.top {
            border-color: #aaa;
        }

        .orgchart td>.down {
            background-color: #aaa;
        }

        .orgchart .middle-level .title {
            background-color: #006699;
        }

        .orgchart .middle-level .content {
            border-color: #006699;
        }

        .orgchart .product-dept .title {
            background-color: #009933;
        }

        .orgchart .product-dept .content {
            border-color: #009933;
        }
        #github-link {
            position: fixed;
            top: 0px;
            right: 10px;
            font-size: 3em;
        }
    </style>
@endsection