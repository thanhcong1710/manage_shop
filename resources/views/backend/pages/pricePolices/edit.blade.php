@extends('backend.layouts.master')
@section('title')
{{ localize('Update Employee Staff') }} {{ getSetting('title_separator') }} {{ getSetting('system_title') }}
@endsection

@section('contents')
<section class="tt-section pt-4">
    <div class="container">
        <div class="row mb-3">
            <div class="col-12">
                <div class="card tt-page-header">
                    <div class="card-body d-lg-flex align-items-center justify-content-lg-between">
                        <div class="tt-page-title">
                            <h2 class="h5 mb-lg-0">Cập nhật chính sách bán hàng</h2>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <div class="row mb-4 g-4">

            <!--left sidebar-->
            <div class="col-xl-9 order-2 order-md-2 order-lg-2 order-xl-1">
                <form action="{{ route('admin.pricePolice.update') }}" method="POST" class="pb-650">
                    @csrf
                    <input type="hidden" name="id" value="{{ $pricePolice->id }}">
                    <!--basic information start-->
                    <div class="card mb-4" id="section-1">
                        <div class="card-body">
                            <h5 class="mb-4">{{ localize('Basic Information') }}</h5>

                            <div class="mb-4">
                                <label for="name" class="form-label">Chính sách<span class="text-danger ms-1">*</span></label>
                                <input class="form-control" type="text" id="name" placeholder="" name="name" required value="{{ $pricePolice->name }}">
                            </div>


                            <div class="mb-4">
                                <label for="num" class="form-label">Số lượng<span class="text-danger ms-1">*</span></label>
                                <input class="form-control" type="number" id="num" placeholder="" name="num" required value="{{ $pricePolice->num }}">
                            </div>

                            <div class="mb-4">
                                <label for="discount_rate" class="form-label">Tỷ lệ chiết khấu %<span class="text-danger ms-1">*</span></label>
                                <input class="form-control" type="number" id="discount_rate" placeholder="" name="discount_rate" value="{{ $pricePolice->discount_rate }}">
                            </div>
                        </div>
                    </div>
                    <!--basic information end-->

                    <!-- submit button -->
                    <div class="row">
                        <div class="col-12">
                            <div class="mb-4">
                                <button class="btn btn-primary" type="submit">
                                    <i data-feather="save" class="me-1"></i> Cập nhật chính sách
                                </button>
                            </div>
                        </div>
                    </div>
                    <!-- submit button end -->

                </form>
            </div>
        </div>
    </div>
</section>
@endsection