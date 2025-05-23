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
                            <h2 class="h5 mb-lg-0">Cập nhật khách hàng</h2>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <div class="row mb-4 g-4">

            <!--left sidebar-->
            <div class="col-xl-9 order-2 order-md-2 order-lg-2 order-xl-1">
                <form action="{{ route('admin.customer.update') }}" method="POST" class="pb-650">
                    @csrf
                    <input type="hidden" name="id" value="{{ $user->id }}">
                    <!--basic information start-->
                    <div class="card mb-4" id="section-1">
                        <div class="card-body">
                            <h5 class="mb-4">{{ localize('Basic Information') }}</h5>

                            <div class="mb-4">
                                <label for="name" class="form-label">Họ tên</label>
                                <input class="form-control" type="text" id="name" placeholder="" name="name" required value="{{ $user->name }}">
                            </div>


                            <div class="mb-4">
                                <label for="email" class="form-label">Email</label>
                                <input class="form-control" type="email" id="email" placeholder="" name="email" required value="{{ $user->email }}">
                            </div>

                            <div class="mb-4">
                                <label for="phone" class="form-label">Số điện thoại</label>
                                <input class="form-control" type="text" id="phone" placeholder="" name="phone" value="{{ $user->phone }}">
                            </div>

                            <div class="mb-4">
                                <label for="password" class="form-label">{{ localize('Password') }}</label>
                                <input class="form-control" type="password" id="password" placeholder="" name="password">
                            </div>

                            <div class="mb-4">
                                <label for="phone" class="form-label">Loại khách hàng</label>
                                <select class="select2 form-control" data-toggle="select2" name="type" value="{{ $user->type }}">
                                    <option value="0" @if ($user->type ==0) selected @endif >Khách lẻ</option>
                                    <option value="1" @if ($user->type ==1) selected @endif >Đại lý</option>
                                </select>
                            </div>
                            <div class="mb-4">
                                <label for="phone" class="form-label">Đại lý cha</label>
                                <select class="select2 form-control" data-toggle="select2" name="parent_id" value="{{ $user->parent_id }}">
                                    <option value="0">Chọn đại lý cha</option>
                                    @foreach ($users as $row)
                                    <option value="{{ $row->id }}" @if ($row->id== $user->parent_id) selected @endif>
                                        {{ $row->name }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-4">
                                <label for="init_number" class="form-label">Sản phẩm tích luỹ</label>
                                <input class="form-control" type="text" id="phone" placeholder="" name="init_number" value="{{ $user->init_number }}">
                            </div>
                            <div class="mb-4">
                                <label for="init_amount" class="form-label">Doanh số tích luỹ</label>
                                <input class="form-control" type="text" id="phone" placeholder="" name="init_amount" value="{{ $user->init_amount }}">
                            </div>
                        </div>
                    </div>
                    <!--basic information end-->

                    <!-- submit button -->
                    <div class="row">
                        <div class="col-12">
                            <div class="mb-4">
                                <button class="btn btn-primary" type="submit">
                                    <i data-feather="save" class="me-1"></i> Cập nhật khách hàng
                                </button>
                            </div>
                        </div>
                    </div>
                    <!-- submit button end -->

                </form>
            </div>

            <!--right sidebar-->
            <div class="col-xl-3 order-1 order-md-1 order-lg-1 order-xl-2">
                <div class="card tt-sticky-sidebar d-none d-xl-block">
                    <div class="card-body">
                        <h5 class="mb-4">{{ localize('Customer Information') }}</h5>
                        <div class="tt-vertical-step">
                            <ul class="list-unstyled">
                                <li>
                                    <a href="#section-1" class="active">{{ localize('Basic Information') }}</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection