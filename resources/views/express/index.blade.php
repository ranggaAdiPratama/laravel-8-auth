@extends('layouts.app', ['activePage' => 'express', 'titlePage' => __('Order Express')])
@push('css')
<style>
    .page {
        width: 145mm;
        min-height: 105mm;
        padding: 10mm;
        margin: 10mm auto;
        border: 1px #D3D3D3 solid;
        border-radius: 5px;
        background: white;
        box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
        font-size: 85%;
    }
</style>
@endpush
@section('content')

<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">

            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card ">
                    <div class="card-header card-header-primary">
                        <h4 class="card-title">
                            <button type="button" class="btn btn-rose btn-fab btn-round btn-tooltip form-create-button" rel="tooltip" title="" data-original-title="Tambah Orderan">
                                <i class="material-icons">add</i>
                                <div class="ripple-container"></div>
                            </button> {{ __('Order Express') }}
                        </h4>
                        <p class="card-category">{{ __('ALL ORDERS') }}</p>
                        <!-- <button class="btn btn-raised btn-round btn-default btn-block" data-toggle="modal" data-target="#signupModal">
                            <i class="material-icons">assignment</i>
                            SignUp
                            <div class="ripple-container"></div>
                        </button> -->
                    </div>
                    <div class="card-body ">
                        @if (\Session::has('success'))
                        <div class="alert alert-success">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <i class="material-icons">close</i>
                            </button>
                            <span>
                                <b> Success - </b> {!! \Session::get('success') !!}</span>
                        </div>
                        @endif
                        @if (\Session::has('error'))
                        <div class="alert alert-danger">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <i class="material-icons">close</i>
                            </button>
                            <span>
                                <b> Opps! - </b> {!! \Session::get('error') !!}</span>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
            <!-- FORM  -->
            <div class="col-md-12"  id ="form-create"  style="display: none;">
                <form method="post" action="{{route('create.express')}}" class="form-horizontal">
                    @csrf
                    <!-- category for reguler is 1  -->
                    <input type="hidden" name="category_id" value="2">
                    <div class="row">
                        <!-- Customer Fields -->
                        <div class="col-md-6">
                            <div class="card ">
                                <div class="card-header card-header-rose card-header-text">
                                    <div class="card-text">
                                        <h4 class="card-title">Customer Fields</h4>
                                    </div>
                                </div>
                                <div class="card-body ">

                                    <div class="row">
                                        <label class="col-sm-3 col-form-label">Pilih Customer</label>
                                        <div class="col-sm-12">
                                            <div class="form-group bmd-form-group">
                                                <select class="customers form-control" id="user_id" name="user_id" data-style="select-with-transition" title="Single Select" required="true">
                                                    <option value="" selected disabled> -- Select Customer -- </option>
                                                    @foreach($data as $dataCustomer)
                                                    <option value="{{$dataCustomer->id}}"> {{$dataCustomer->name}} </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                    </div>
                                    <hr />
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <div class="form-group bmd-form-group">
                                                <label class="bmd-label-floating">Receive Name</label>
                                                <input type="text" class="form-control" name="receiver_name" required="true">
                                                <span class="bmd-help">Penerima Paket.</span>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group bmd-form-group">
                                                <label class="bmd-label-floating">Receive Phone</label>
                                                <input type="number" class="form-control" name="receiver_phone" required="true" min=0>
                                                <span class="bmd-help">*wajib.</span>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group bmd-form-group">
                                                <label class="bmd-label-floating">Receive Phone2</label>
                                                <input type="number" class="form-control" name="receiver_phone2">
                                                <span class="bmd-help">*optional</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <label class="col-form-label">Select City</label>
                                        <div class="col-sm-12">
                                            <div class="form-group bmd-form-group">
                                                <select class="customers form-control" id="city" name="city" data-style="select-with-transition" title="city">
                                                    <option value="" selected disabled> -- Select City -- </option>
                                                    @foreach($city as $dataCity)
                                                    <option value="{{$dataCity->city_id}}"> {{$dataCity->nama}} </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <label class="col-sm-3 col-form-label">Select District</label>
                                        <div class="col-sm-12">
                                            <div class="form-group bmd-form-group">
                                                <select class="customers form-control" id="district" name="district" data-style="select-with-transition" title="Select district" disabled>
                                                    <option value="" selected disabled> -- Select District -- </option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <label class="col-sm-3 col-form-label">Select Village</label>
                                        <div class="col-sm-12">
                                            <div class="form-group bmd-form-group">
                                                <select class="customers form-control" id="village" name="village" data-style="select-with-transition" title="Select village" disabled>
                                                    <option value="" selected disabled> -- Select Village -- </option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="form-group bmd-form-group">
                                                <label class="bmd-label-floating">Receive Address</label>
                                                <textarea id="address" cols="30" rows="6" class="form-control" name="description_address"></textarea>
                                                <span class="bmd-help">*Masukan Alamat Rinci Penerima Paket.</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <label class="col-sm-5 col-form-label">Select Payment Methods</label>
                                        <div class="col-sm-12">
                                            <div class="form-group bmd-form-group">
                                                <select class="customers form-control" id="payment_method" name="payment_method" data-style="select-with-transition" title="Single Select">
                                                    <option value="" selected disabled> -- Select Payment Method -- </option>
                                                    @foreach($payment_method as $dataMethods)
                                                    <option value="{{$dataMethods->id}}"> {{$dataMethods->method}} </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Product Field -->
                        <div class="col-md-6">
                            <div class="card ">
                                <div class="card-header card-header-rose card-header-text">
                                    <div class="card-text">
                                        <h4 class="card-title">Product Fields</h4>
                                    </div>
                                </div>
                                <div class="card-body ">
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <div class="form-group bmd-form-group">
                                                <label class="bmd-label-floating">Product Name</label>
                                                <input type="text" class="form-control" name="name" required="true">
                                                <span class="bmd-help">Penerima Paket.</span>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group bmd-form-group">
                                                <label class="bmd-label-floating">Weight</label>
                                                <input type="number" class="form-control" name="weight" number="true" required="true" min=0>
                                                <span class="bmd-help">*wajib.</span>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group bmd-form-group">
                                                <label class="bmd-label-floating">Volume</label>
                                                <input type="number" class="form-control" name="volume" number="true" min=0>
                                                <span class="bmd-help">*optional</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group bmd-form-group">
                                                <label class="bmd-label-floating">Delivery Free</label>
                                                <input type="text" class="form-control" name="delivery_fee" id="delivery_fee" number="true" required="true" min=0 value="10.000" readonly>
                                                <span class="bmd-help">Biaya Pengiriman.</span>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group bmd-form-group">
                                                <label class="bmd-label-floating">Price</label>
                                                <input type="text" class="form-control" name="price" id="price" number="true" required="true" min=0>
                                                <span class="bmd-help">*wajib.</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group bmd-form-group">
                                                <label class="bmd-label-floating">Product Descriptions</label>
                                                <textarea name="description_order" id="description_order" cols="15" rows="5" class="form-control"></textarea>
                                                <span class="bmd-help">*Masukan Desktripsi Produk.</span>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <label class="col-form-label">Select Delivery Driver</label>
                                            <div class="col-sm-12">
                                                <div class="form-group bmd-form-group">
                                                    <select class="customers form-control" id="delivery_driver" name="delivery_driver" data-style="select-with-transition" title="delivery_driver">
                                                        <option value="" selected disabled> -- Select Driver -- </option>
                                                        @foreach($driver as $dataDriver)
                                                        <option value="{{$dataDriver->id}}"> {{$dataDriver->name}} </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 col-sm-6">
                                            <h4 class="title">Image Product</h4>
                                            <div class="fileinput fileinput-new text-center" data-provides="fileinput">
                                                <div class="fileinput-new thumbnail">
                                                    <img src="{{url('material2')}}/img/image_placeholder.jpg" alt="...">
                                                </div>
                                                <div class="fileinput-preview fileinput-exists thumbnail"></div>
                                                <div>
                                                    <span class="btn btn-rose btn-round btn-file">
                                                        <span class="fileinput-new">Select image</span>
                                                        <span class="fileinput-exists">Change</span>
                                                        <input type="file" name="photo">
                                                    </span>
                                                    <a href="#pablo" class="btn btn-danger btn-round fileinput-exists" data-dismiss="fileinput"><i class="fa fa-times"></i> Remove</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="col-md-12 col-sm-12 text-center">
                                        <input type="submit" value="Create Order" name="submit" class="btn btn-primary btn-lg">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <!-- ALL EXPRESS ORDER -->
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header card-header-primary card-header-icon">
                        <div class="card-icon">
                            <i class="material-icons">assignment</i>
                        </div>
                        <h4 class="card-title">All Order Express Today</h4>
                    </div>
                    <div class="card-body">
                        <div class="toolbar">
                            <div class="row">
                                <div class="col-md-5">
                                    <div class="card ">
                                        <div class="card-header card-header-rose card-header-text">
                                            <div class="card-icon">
                                                <i class="material-icons">settings</i>
                                            </div>
                                            <h4 class="card-title">Actions</h4>
                                        </div>
                                        <div class="card-body ">
                                            <div class="row">
                                                <!-- <button id="frm-example" class="btn btn-rose">Actions</button> -->
                                                <div class="dropdown">

                                                    <button class="btn btn-rose dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        Pilih Jenis Aksi
                                                    </button>
                                                    <div class="dropdown-menu scrollable-menu" aria-labelledby="dropdownMenuButton">
                                                        <a class="dropdown-item" href="#" id="change_driver">Change Pickup Driver</a>
                                                        <a class="dropdown-item" href="#" id="change_delivery_driver" data-id="UD">Change Delivery Driver</a>
                                                        <a class="dropdown-item" href="#" id="moveToPick">Move to Pickup</a>
                                                        <a class="dropdown-item" href="#" id="changeBailOut">Move to Picked Up</a>
                                                        <a class="dropdown-item" href="#" id="delivery_assign" data-id="DA">Move to Delivery Assigned</a>
                                                        <a class="dropdown-item" href="#" id="moveToDelivered">Move to Delivered</a>
                                                        <a class="dropdown-item" href="#" id="moveToCanceled">Move to Canceled</a>
                                                        <a class="dropdown-item" href="#" id="pickupCancelRefund">Cancel Pickup Order with Refund</a>
                                                        <a class="dropdown-item" href="#" id="deliverCancelRefund">Cancel delivery Order with Refund</a>
                                                        <a class="dropdown-item" href="#" id="printBarode">Print Barcode</a>
                                                    </div>
                                                </div>
                                                <a href="{{route('order.excelExpress')}}" class="btn btn-success"><i class="fa fa-file-excel-o" aria-hidden="true"></i> Export Excel</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="card ">
                                        <div class="card-header card-header-rose card-header-text">
                                            <div class="card-icon">
                                                <i class="material-icons">library_books</i>
                                            </div>
                                            <h4 class="card-title">Tanggal Order</h4>
                                        </div>
                                        <div class="card-body ">
                                            <div class="form-group">
                                                <input type="date" class="form-control" id="dates_order" name="dates_order">
                                                {{-- date('d/m/Y') --}}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="card ">
                                        <div class="card-header card-header-rose card-header-text">
                                            <div class="card-icon">
                                                <i class="material-icons">today</i>
                                            </div>
                                            <h4 class="card-title">Pilih Status Order</h4>
                                        </div>
                                        <div class="card-body ">
                                            <div class="form-group">
                                                <select class="selectpicker" data-size="7" data-style="btn btn-rose btn-round btn-sm" title="Single Select" id="status_order">
                                                    <option disabled selected>Pilih Status Order</option>
                                                    <option value="99">All Order</option>
                                                    <option value="1">Assigned</option>
                                                    <option value="2">Picking Up</option>
                                                    <option value="3">Picked Up</option>
                                                    <option value="4">Delivery Assigned</option>
                                                    <option value="5">Complete</option>
                                                    <option value="6">Canceled</option>
                                                    <option value="7">Retrur</option>
                                                    <option value="8">RE-Delivery</option>
                                                    <option value="9">Retrun Assigned</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--        Here you can write extra buttons/actions for the toolbar              -->
                        </div>
                        <div class="material-datatables">
                            <table id="datatables" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                                <thead>
                                    <tr>
                                        <th class="text-center disabled-sorting "></th>
                                        <th class="text-center disabled-sorting method"></th>
                                        <th>No Order</th>
                                        <th>Order Date</th>
                                        <th>Client</th>
                                        <th>Pick up Driver</th>
                                        <th>Delivery Driver</th>
                                        <th>Status</th>
                                        <th class="text-center disabled-sorting method"></th>
                                        <th class="disabled-sorting text-right">Actions</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th class="text-center"></th>
                                        <th class="text-center method"></th>
                                        <th>No Order</th>
                                        <th>Order Date</th>
                                        <th>Client</th>
                                        <th>Pick up Driver</th>
                                        <th>Delivery Driver</th>
                                        <th>Status</th>
                                        <th class="text-center disabled-sorting method"></th>
                                        <th class="text-right">Actions</th>
                                    </tr>
                                </tfoot>
                                <tbody>
                                    {{--@foreach($allReguler as $data)
                                    <tr>
                                        <td>
                                            <div class="form-check">
                                                <label class="form-check-label">
                                                    <input class="form-check-input" type="checkbox" value="">
                                                    <span class="form-check-sign">
                                                        <span class="check"></span>
                                                    </span>
                                                </label>
                                            </div>
                                        </td>
                                        <td>{{$data['no_order']}}</td>
                                    <td>{{$data['date']}}</td>
                                    <td>{{$data['client']}}</td>
                                    <td>{{$data['driver_name']}}</td>
                                    <td>{{$data['delivery_driver']}}</td>
                                    <td>{{$data['order_status']}}</td>
                                    <td class="text-right">
                                        <a href="#" class="btn btn-link btn-info btn-just-icon like"><i class="material-icons">visibility</i></a>
                                        <a href="#" class="btn btn-link btn-warning btn-just-icon edit"><i class="material-icons">mode_edit</i></a>
                                        <a href="#" class="btn btn-link btn-danger btn-just-icon remove"><i class="material-icons">close</i></a>
                                    </td>
                                    </tr>
                                    @endforeach--}}
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!-- end content-->
                </div>
                <!--  end card  -->
            </div>
            <!-- end col-md-12 -->
            <!-- Get Jobsheet -->
            <div class="col-md-12 checkout_barcode" id="barcode_section" style="display: none;">

            </div>
        </div>
    </div>
</div>

<!-- Register Modal -->
<div class="modal fade" id="signupModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-signup">
        <div class="modal-content">
            <div class="card card-signup card-plain">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="material-icons">clear</i></button>
                    <h2 class="modal-title card-title text-center" id="myModalLabel">Register</h2>
                </div>
                <div class="modal-body">
                    <div class="row">

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--  End Modal -->

<!-- Change driver Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="col-md-12">
                    <div class="card ">
                        <div class="card-header card-header-rose card-header-text">
                            <div class="card-icon">
                                <i class="material-icons">two_wheeler</i>
                            </div>
                            <h4 class="card-title">Pilih Driver</h4>
                        </div>
                        <div class="card-body ">
                            <div class="form-group bmd-form-group col-md-12 text-center">
                                <select class="customers form-control dropdown bootstrap-select show-tick list_driver_available" data-style="select-with-transition" title="Single Drover" required="true">
                                    <option value="" disabled selected>Pilih Driver</option>

                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="save_change_driver">Save changes</button>
            </div>
        </div>
    </div>
</div>
<!-- Change Delivery driver modal -->
@include('layouts.modals.update_delivery_driver')
@include('layouts.modals.change_bailout')
@endsection
@push('js')
<script src="https://gyrocode.github.io/jquery-datatables-checkboxes/1.2.12/js/dataTables.checkboxes.min.js"></script>

<script>
    // In your Javascript (external .js resource or <script> tag)
    $(document).ready(function() {
        var price = document.getElementById("price");
        var delivery_fee = document.getElementById("delivery_fee");
        $('#delivery_fee').val(formatRupiah('10.000',""));
        price.addEventListener("keyup", function(e) {
            // tambahkan 'Rp.' pada saat form di ketik
            // gunakan fungsi formatRupiah() untuk mengubah angka yang di ketik menjadi format angka
            price.value = formatRupiah(this.value,"");
        });
        delivery_fee.addEventListener("keyup", function(e) {
            // tambahkan 'Rp.' pada saat form di ketik
            // gunakan fungsi formatRupiah() untuk mengubah angka yang di ketik menjadi format angka
            delivery_fee.value = formatRupiah(this.value,"");
        });
        $('.customers').select2({
            width: '100%'
        });
        $('.form-create-button').click(function() {
            $('#form-create').toggle();
        });
        $('#city').on('change', function() {
            $.ajax({
                url: `{{route('city.id')}}`,
                data: {
                    city_id: this.value
                },
                dataType: 'json',
                beforeSend: function(xhr) {
                    $('#district').attr('disabled', true);
                    $('#village').attr('disabled', true);
                    $('#district').empty();
                },
                success: function(data) {
                    // district
                    $('#district').attr('disabled', false);
                    $('#district').append('<option value="" selected disabled> -- Select District -- </option>');
                    $.each(data, function(key, value) {
                        $("#district").append('<option value=' + value.id + '>' + value.nama + '</option>');
                    });
                    console.log(data);
                },
                error: function(data) {
                    // console.log(data);
                },
                type: 'GET'
            });
        });
        $('#district').on('change', function() {
            $.ajax({
                url: `{{route('district.id')}}`,
                data: {
                    district_id: this.value
                },
                dataType: 'json',
                beforeSend: function(xhr) {
                    $('#village').attr('disabled', true);
                    $('#village').empty();
                },
                success: function(data) {
                    // district
                    $('#village').attr('disabled', false);
                    $('#village').append('<option value="" selected disabled> -- Select Village -- </option>');
                    $.each(data, function(key, value) {
                        $("#village").append('<option value=' + value.id + '>' + value.nama + '</option>');
                    });
                    // console.log(data);
                },
                error: function(data) {
                    console.log(data);
                },
                type: 'GET'
            });
        });

        function format(d) {
           
            // `d` is the original data object for the row
            return '<table cellpadding="5" cellspacing="0" border="0" style="width:100%;background-color:#FFFFE0;">' +
                '<tr >' +
                '<td>District </td>' +
                '<td>Village</td>' +
                '<td>Receiver Address info:</td>' +                
                '</tr>' +
                '<tr style="background-color:#FFFFE0">' +
                '<td>' + d.receiver_district  +'</td>' +
                '<td>' + d.receiver_village +'</td>' +
                '<td>'+d.receiver_address+'</td>' +
                '</tr>' +
                '</table>';
        }

        var tables = $("#datatables").DataTable({
            serverSide: true,
            processing: true,
            ajax: {
                url: "{{route('all-express')}}",
                data: function(data) {
                    data.params = {
                            sac: "helo"
                        },
                        data.dates = $('input[name=dates_order]').val(),
                        data.status = $('#status_order').val()
                },
            },
            buttons: false,
            searching: true,
            scrollY: 500,
            scrollX: true,
            scrollCollapse: true,
            columnDefs: [{
                    'targets': 0,
                    orderable: false,
                    searchable: false,
                    'checkboxes': {
                        'selectRow': true
                    }
                },
                {
                    "targets": [1],
                    "visible": false,
                    "searchable": false
                },
                {
                    "targets": 'no-sort',
                    "orderable": false,
                }
            ],
            'select': {
                'style': 'multi',                
                selector: 'td:not(:last-child, :nth-child(8))'
            },
            columns: [{
                    targets: 0,
                    data: "id",
                    className: 'id printBarcode',
                    ordering: false,
                    searchable: false,
                    render: function(data, type, row) {
                        //use only `this` and change data to `data.cdId` this is for dmo only..
                        return ("<input type='checkbox' class='dt-checkboxes' name='update' style='zoom: 2.0;'>")
                    },
                },
                {
                    data: "payment_method_id",
                    className: 'method',
                    orderable: false,
                    searchable: false
                },
                {
                    data: "no_order",
                    className: 'no_order'
                },
                {
                    data: "date",
                    className: 'date'
                },
                {
                    data: "client",
                    className: 'client'
                },
                {
                    data: "driver_name",
                    className: 'driver_name'
                },
                {
                    data: "delivery_driver",
                    className: 'driver_name'
                },
                {
                    data: "order_status",
                    className: 'driver_name'
                },
                {
                    className: 'dt-control',
                    ordering: false,
                    data: null,
                    defaultContent: '',
                    
                    render: function(data, type, row) {
                        //use only `this` and change data to `data.cdId` this is for dmo only..
                        return ("<input type='button' class='dt-control btn btn-rose' name='detail' value='Address'>")
                    },
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                }
            ],
            drawCallback: function(settings) {
                $("input[type='checkbox']").on("change", function() {
                    var rows_selecteds = tables.column(0).checkboxes.selected();                    
                    if (rows_selecteds.length === 0) {
                        $("#barcode_section").hide();
                    } else {
                        $("#barcode_section").show();
                        viewBarcode(rows_selecteds.length);
                    }                   
                });

                // $('.dt-checkboxes').change(function() {
                //     if ($(this).is(":checked")) {
                //         console.log('oke');
                //     }
                //     // console.log('oke');
                // });
            }
        });
        $('#datatables tbody').on('click', 'td.dt-control', function() {
            console.log('oke');
            var tr = $(this).closest('tr');
            var row = tables.row(tr);

            if (row.child.isShown()) {
                // This row is already open - close it
                row.child.hide();
                tr.removeClass('shown');
            } else {
                // Open this row
                row.child(format(row.data())).show();
                tr.addClass('shown');
            }
        });
        $('input[name=dates_order]').on('change', function() {
            // console.log('cek');
            tables.draw();
        });
        $('#status_order').on('change', function() {
            // console.log('cek');
            tables.draw();
        });

        // Handle form submission event
        $('#frm-example').on('click', function(e) {
            console.log('cek');

            var rows_selected = tables.column(0).checkboxes.selected();

            // Iterate over all selected checkboxes
            $.each(rows_selected, function(index, rowId) {
                // Create a hidden element
                console.log(rowId);
                // $(form).append(
                //     $('<input>')
                //     .attr('type', 'hidden')
                //     .attr('name', 'id[]')
                //     .val(rowId)
                // );
            });
        });
        //get data driver available

        $('#change_driver').on('click', function(e) {
            var rows_selected = tables.column(0).checkboxes.selected();
            console.log(rows_selected.length);
            if (rows_selected.length === 0) {
                $('#exampleModal').modal("hide");
                swal("Cancelled", "Mohon Pilih 1 Order Terlebih dahulu", "error");
            } else if (rows_selected.length > 1) {
                $('#exampleModal').modal("hide");
                swal("Cancelled", "Mohon Maaf Hanya pilih 1 order untuk ganti Driver", "error");
            } else {
                $('#exampleModal').modal("show");
                $.ajax({
                    url: `{{route('all-express-driver')}}`,
                    data: {
                        order_id: 123
                    },
                    dataType: 'json',
                    beforeSend: function(xhr) {
                        $('.list_driver_available').attr('disabled', true);
                        $('.list_driver_available').empty();
                        $('.list_driver_available').append('<option value="" selected disabled> Loading get data .... </option>');
                    },
                    success: function(data) {
                        $('.list_driver_available').attr('disabled', false);
                        $('.list_driver_available').empty();
                        $('.list_driver_available').append('<option value="" selected disabled> -- Pilih Driver -- </option>');
                        $.each(data.data, function(key, value) {
                            $(".list_driver_available").append('<option value=' + value.id + '>' + value.name + '</option>');
                        });
                    },
                    error: function(data) {
                        // console.log(data);
                    },
                    type: 'GET'
                });
            }
        });

        $('#save_change_driver').on('click', function(e) {
            var rows_selected = tables.column(0).checkboxes.selected();
            var order_id = null;
            $.each(rows_selected, function(index, rowId) {
                // Create a hidden element
                order_id = rowId;
            });
            var newDriver = $('.list_driver_available').find(":selected").val();
            console.log(order_id, newDriver);
            $.ajax({
                url: `{{route('change-reguler-pickup')}}`,
                data: {
                    order_id: order_id,
                    driver_id: newDriver,
                    _token: "{{ csrf_token() }}",
                },
                dataType: 'json',
                beforeSend: function(xhr) {
                    $('#save_change_driver').html('');
                    $('#save_change_driver').html(`
                                    <span class="material-icons rotating"  role="status" >
                                    loop
                                    </span>
                                    Loading...
                        `);
                },
                success: function(data) {
                    $('#save_change_driver').html('');
                    $('#save_change_driver').html('Save changes');
                    if (data.status) {
                        md.showNotification('bottom', 'right', data.msg);
                        tables.draw();
                        $('#exampleModal').modal("hide");

                    } else {
                        md.showNotification('bottom', 'right', data.msg);
                        $('#exampleModal').modal("hide");
                    }
                    console.log(data);

                },
                error: function(data) {
                    md.showNotification('bottom', 'right', "Opps.. There is something Wrong!")
                    $('#exampleModal').modal("hide");
                    console.log(data);
                },
                type: 'POST'
            });
        });

        $('#change_delivery_driver').on('click', function(e) {
            var change_delivery_driver = $(this).data('id');
            changeDeliveryDriver(change_delivery_driver);
        });
        $('#delivery_assign').on('click', function(e) {
            var delivery_assign = $(this).data('id');
            changeDeliveryDriver(delivery_assign);
        });

        $('#save_delivery_driver').on('click', function(e) {
            var rows_selected = tables.column(0).checkboxes.selected();
            var order_id = null;
            $.each(rows_selected, function(index, rowId) {
                // Create a hidden element
                order_id = rowId;
            });
            var newDriver = $('#id_delivery_driver').find(":selected").val();
            console.log(order_id, newDriver);
            $.ajax({
                url: `{{route('change-reguler-deliver')}}`,
                data: {
                    order_id: order_id,
                    driver_id: newDriver,
                    _token: "{{ csrf_token() }}",
                },
                dataType: 'json',
                beforeSend: function(xhr) {
                    $('#save_delivery_driver').html('');
                    $('#save_delivery_driver').html(`
                                    <span class="material-icons rotating"  role="status" >
                                    loop
                                    </span>
                                    Loading...
                        `);
                },
                success: function(data) {
                    $('#save_delivery_driver').html('');
                    $('#save_delivery_driver').html('Save changes');
                    if (data.status) {
                        md.showNotification('bottom', 'right', data.msg);
                        tables.draw();
                        $('#changeDeliveryModal').modal("hide");

                    } else {
                        md.showNotification('bottom', 'right', data.msg);
                        $('#changeDeliveryModal').modal("hide");
                    }
                    // console.log(data);
                },
                error: function(data) {
                    md.showNotification('bottom', 'right', "Opps.. There is something Wrong!")
                    $('#changeDeliveryModal').modal("hide");
                    // console.log(data);
                },
                type: 'POST'
            });
        });
        
        $('#moveToPickedUp').on('click', function(e) {
            updateStatus(1);
        });
        $('#moveToPick').on('click', function(e) {
            postStatus(1);
        });
        $('#moveToDelivered').on('click', function(e) {
            postStatus(5);
        });
        $('#moveToCanceled').on('click', function(e) {
            postStatus(6);
        });
        $('#pickupCancelRefund').on('click', function(e) {
            postStatus(6,'','pickup');
        });
        $('#deliverCancelRefund').on('click', function(e) {
            postStatus(6,'','delivery');
        });
        
        $('#changeBailOut').on('click', function(e) {
            var rows_selecteds = tables.column(0).checkboxes.selected();
            var rowData = tables.rows({
                selected: true
            }).data();
            // console.log(rowData);
            if (rows_selecteds.length === 0) {
                swal("Cancelled", "Mohon Pilih 1 Order Terlebih dahulu", "error");
            } else {
                $('#changeBailoutModal').modal("show");
            }
        });
        //from Bailout Modal 
        $('#save_changes').on('click', function(e) {
            var selecteds = $('#id_bailout').find(":selected").val();
            console.log(selecteds);
            if (selecteds === '') {
                md.showNotification('top', 'right', "Opps.. Pilih dahulu Jenis Bailout")
                $('#id_bailout').focus();

                return false;
            } else {
                var rowData = tables.rows({
                    selected: true
                }).data();
                var data = [];
                $.each(rowData, function(index, rowId) {
                    // Create a hidden element
                    data.push({
                        id: rowId['id'],
                        method: rowId['payment_method_id'],
                        status: 3,
                        bailout: $('#id_bailout').find(":selected").val()
                    });
                });
                $.ajax({
                    url: `{{route('reguler-status')}}`,
                    data: {
                        datas: data,
                        _token: "{{ csrf_token() }}",
                    },
                    dataType: 'json',
                    beforeSend: function(xhr) {
                        $('#save_changes').html('');
                        $('#save_changes').html(`
                                    <span class="material-icons rotating"  role="status" >
                                    loop
                                    </span>
                                    Loading...
                        `);
                    },
                    success: function(data) {
                        $('#save_changes').html('');
                        $('#save_changes').html('Save changes');
                        if (data.status) {
                            md.showNotification('bottom', 'right', data.msg);
                            tables.draw();
                            $('#changeBailoutModal').modal("hide");
                        } else {
                            md.showNotification('bottom', 'right', data.msg);
                            tables.draw();
                            $('#changeBailoutModal').modal("hide");
                        }
                        // console.log(data);
                    },
                    error: function(data) {
                        md.showNotification('bottom', 'right', "Opps.. There is something Wrong!")
                        $('#changeBailoutModal').modal("hide");
                        // console.log(data);
                    },
                    type: 'POST'
                });
            }


        });

        $('#save_delivery_assign').on('click', function(e) {         
            var newDriver = $('#id_delivery_driver').find(":selected").val();
            console.log(newDriver);
            postStatus(4,newDriver);
        });

        $('#printBarode').on('click', function(e) {
            var rows_selecteds = tables.column(0).checkboxes.selected();
            var rowData = tables.rows({
                selected: true
            }).data();
            // console.log(rowData);
            if (rows_selecteds.length === 0) {
                swal("Cancelled", "Mohon Pilih 1 Order Terlebih dahulu", "error");
            } else {
                var dataRow = [];
                $.each(rowData, function(index, rowId) {
                    // Create a hidden element                 
                    dataRow.push(rowId);
                });
                 $.ajax({
                    url: `{{route('reguler-printBarcode')}}`,
                    data: {
                        datas:dataRow,
                        _token: "{{ csrf_token() }}",
                    },
                    beforeSend: function(xhr) {
                        swal({
                            title: 'Loading .....',
                            allowEscapeKey: false,
                            allowOutsideClick: false,
                            showCancelButton: false,
                            showConfirmButton: false
                        })
                    },
                    success: function(data) {
                      console.log(data);
                      swal.close()
                      $.print(data, {
                        globalStyles : false,
                        mediaPrint : false,
                    });
                    },
                    error: function(data) {
                        console.log(data);
                    },
                    type: 'POST'
                });
            }
           
        });
        //Functions
        const changeDeliveryDriver = (tipe_aksi) => {
            console.log(tipe_aksi);
            $('#save_delivery_driver').hide();
            $('#save_delivery_assign').hide();
            var rows_selected = tables.column(0).checkboxes.selected();
            // console.log(rows_selected.length);
            if (rows_selected.length === 0) {
                $('#changeDeliveryModal').modal("hide");
                swal("Cancelled", "Mohon Pilih 1 Order Terlebih dahulu", "error");
            } else if (rows_selected.length > 1) {
                $('#changeDeliveryModal').modal("hide");
                swal("Cancelled", "Mohon Maaf Hanya pilih 1 order untuk ganti Driver", "error");
            } else {
                $('#changeDeliveryModal').modal("show");
                $.ajax({
                    url: `{{route('all-express-driver')}}`,
                    data: {
                        order_id: 123
                    },
                    dataType: 'json',
                    beforeSend: function(xhr) {
                        $('.list_driver_available').attr('disabled', true);
                        $('.list_driver_available').empty();
                        $('.list_driver_available').append('<option value="" selected disabled> Loading get data .... </option>');
                    },
                    success: function(data) {
                        console.log(data.data);
                        $('.list_driver_available').attr('disabled', false);
                        $('.list_driver_available').empty();
                        $('.list_driver_available').append('<option value="" selected disabled> -- Pilih Driver -- </option>');
                        $.each(data.data, function(key, value) {
                            $(".list_driver_available").append('<option value=' + value.id + '>' + value.name + '</option>');
                        });
                        if (tipe_aksi === 'UD') {
                            $('#save_delivery_driver').show();
                            $('#save_delivery_assign').hide();
                        }else if(tipe_aksi === 'DA'){
                            $('#save_delivery_driver').hide();
                            $('#save_delivery_assign').show();
                        }
                    },
                    error: function(data) {
                        // console.log(data);
                    },
                    type: 'GET'
                });
            }
        }
        const postStatus = (statuses, drivers = '',canceled = '') => {
            var rows_selecteds = tables.column(0).checkboxes.selected();
            var rowData = tables.rows({
                selected: true
            }).data();
            // console.log(rowData);
            if (rows_selecteds.length === 0) {
                swal("Cancelled", "Mohon Pilih 1 Order Terlebih dahulu", "error");
            } else {
                var data = [];
                $.each(rowData, function(index, rowId) {
                    // Create a hidden element                 
                    data.push({
                        id: rowId['id'],
                        method: rowId['payment_method_id'],
                        driver:drivers,
                        cancel:canceled,
                        status: statuses
                    });
                });
                // console.log(data);
                $.ajax({
                    url: `{{route('reguler-status')}}`,
                    data: {
                        datas: data,
                        _token: "{{ csrf_token() }}",
                    },
                    dataType: 'json',
                    beforeSend: function(xhr) {
                        swal({
                            title: 'Loading .....',
                            allowEscapeKey: false,
                            allowOutsideClick: false,
                            showCancelButton: false,
                            showConfirmButton: false
                        })
                    },
                    success: function(data) {
                        swal.close()
                        if (data.status) {
                            md.showNotification('bottom', 'right', data.msg);
                            tables.draw();

                        } else {
                            md.showNotification('bottom', 'right', data.msg);
                            tables.draw();
                        }
                        // console.log(data);
                    },
                    error: function(data) {
                        swal.close()
                        md.showNotification('bottom', 'right', "Opps.. There is something Wrong!")
                        console.log(data);
                    },
                    type: 'POST'
                });
            }
        };
        const viewBarcode = (data_id) => {
            var rowData = tables.rows({
                selected: true
            }).data();
                var data = [];
                $.each(rowData, function(index, rowId) {
                    // Create a hidden element                 
                    data.push({
                        id: rowId['id'],
                        no_order: rowId['no_order'],
                                           
                    });
                });
                $.ajax({
                    url: `{{route('order.barcode')}}`,
                    data: {
                        datas: data,
                        _token: "{{ csrf_token() }}",
                    },
                    dataType: 'json',
                    beforeSend: function(xhr) {
                        swal({
                            title: 'Loading .....',
                            allowEscapeKey: false,
                            allowOutsideClick: false,
                            showCancelButton: false,
                            showConfirmButton: false,
                            closeOnClickOutside: false
                        })
                    },
                    success: function(data) {
                        swal.close()
                        $("#barcode_section").show();
	                    $('.checkout_barcode').html(data.html);
                        
                        // console.log(data);
                    },
                    error: function(data) {
                        swal.close()
                        md.showNotification('bottom', 'right', "Opps.. There is something Wrong!")
                        console.log(data);
                    },
                    type: 'GET'
                });
            console.log(data);
        }
    });
</script>
@endpush