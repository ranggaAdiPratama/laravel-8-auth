@extends('layouts.app', ['activePage' => 'driver-'.$slug, 'titlePage' => __('Driver '.$slug)])
@push('css')
<style>
    [role=button] {
        cursor: pointer
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
                    <div class="card-header card-header-rose">
                        <h4 class="card-title">
                            <button type="button" class="btn btn-warning btn-fab btn-round btn-tooltip form-create-button" rel="tooltip" title="" data-original-title="Tambah Orderan">
                                <i class="material-icons">add</i>
                                <div class="ripple-container"></div>
                            </button> {{ __('Driver '.$slug) }}
                        </h4>
                        <p class="card-category">{{ __('ALL Drivers') }}</p>
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

            <!-- ALL Driver-->
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header card-header-warning card-header-icon">
                        <div class="card-icon">
                            <i class="material-icons">assignment</i>
                        </div>
                        <h4 class="card-title">All Drivers {{$slug}}</h4>
                    </div>
                    <div class="card-body">
                        <div class="toolbar">
                            <div class="col-md-6">
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
                                                    Choose Actions
                                                </button>
                                                <div class="dropdown-menu scrollable-menu" aria-labelledby="dropdownMenuButton">
                                                    <a class="dropdown-item" href="#" id="choose_placement">Choose Placement</a>
                                                    <a class="dropdown-item" href="#" id="set_begining_balance">Set Begining Balance</a>
                                                </div>
                                            </div>
                                            <div class="dropdown">

                                                <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    Change Driver Status
                                                </button>
                                                <div class="dropdown-menu scrollable-menu" aria-labelledby="dropdownMenuButton">
                                                    <a class="dropdown-item" href="#" id="statusOnline">Change to Online</a>
                                                    <a class="dropdown-item" href="#" id="statusOffline">Change to Offline</a>
                                                </div>
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
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Distric Placement</th>
                                        <th>Village Placement</th>
                                        <th>Total Order</th>
                                        <th>Status</th>
                                        <th class="disabled-sorting text-right">Actions</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th class="text-center"></th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Distric Placement</th>
                                        <th>Village Placement</th>
                                        <th>Total Order</th>
                                        <th>Status</th>
                                        <th class="text-right">Actions</th>
                                    </tr>
                                </tfoot>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!-- end content-->
                </div>
                <!--  end card  -->
            </div>
            <!-- end col-md-12 -->
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
<div class="modal fade" id="placeModal" tabindex="-1" aria-labelledby="placeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="placeModalLabel">Change Driver Placement</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="col-md-12">
                    <div class="card ">
                        <div class="card-header card-header-rose card-header-text">
                            <div class="card-icon">
                                <i class="material-icons">apartment</i>
                            </div>
                            <h4 class="card-title">Pilih Driver</h4>
                        </div>
                        <div class="card-body ">
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
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="card ">
                        <div class="card-header card-header-rose card-header-text">
                            <div class="card-icon">
                                <i class="material-icons">pin_drop</i>
                            </div>
                            <h4 class="card-title">Select a District</h4>
                        </div>
                        <div class="card-body ">
                        <div class="col-sm-12">
                                            <div class="form-group bmd-form-group">
                                                <select class="customers form-control select2 " id="district" name="district" data-style="select-with-transition" title="Select district" disabled multiple="multiple">
                                                    <option value="" selected disabled> -- Select District -- </option>
                                                </select>
                                            </div>
                                        </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="card ">
                        <div class="card-header card-header-rose card-header-text">
                            <div class="card-icon">
                                <i class="material-icons">gps_fixed</i>
                            </div>
                            <h4 class="card-title">Select a Village</h4>
                        </div>
                        <div class="card-body ">
                        <div class="col-sm-12">
                                            <div class="form-group bmd-form-group">
                                                <select class="customers form-control" id="village" name="village" data-style="select-with-transition" title="Select village"  disabled multiple="multiple">
                                                    <option value="" selected disabled> -- Select Village -- </option>
                                                </select>
                                            </div>
                                        </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="save_placement_driver">Save changes</button>
            </div>
        </div>
    </div>
</div>

<!-- Set Begining Balance-->
<div class="modal fade" id="balanceModal" tabindex="-1" aria-labelledby="balanceModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="balanceModalLabel">Set Begining Balance</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="col-md-12">
                    <div class="card ">
                        <div class="card-header card-header-rose card-header-text">
                            <div class="card-icon">
                                <i class="material-icons">attach_money</i>
                            </div>
                            <h4 class="card-title">Set Value</h4>
                        </div>
                        <div class="card-body ">
                            <div class="col-sm-12">
                                <div class="form-group bmd-form-group">
                                    <label class="bmd-label-floating">Set Value</label>
                                    <input type="text" class="form-control" name="price" id="price" number="true" required="true" min=0>
                                    <span class="bmd-help">*wajib.</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="save_balance">Save changes</button>
            </div>
        </div>
    </div>
</div>
@endsection
@push('js')
<script src="https://gyrocode.github.io/jquery-datatables-checkboxes/1.2.12/js/dataTables.checkboxes.min.js"></script>

<script>
    // In your Javascript (external .js resource or <script> tag)
    $(document).ready(function() {
        var price = document.getElementById("price");
        price.addEventListener("keyup", function(e) {
            // tambahkan 'Rp.' pada saat form di ketik
            // gunakan fungsi formatRupiah() untuk mengubah angka yang di ketik menjadi format angka
            price.value = formatRupiah(this.value, "");
        });
        $('.form-create-button').click(function() {
            $('#form-create').toggle();
        });
        $('.village_list').click(function() {
            $('#signupModal').modal('show');
        });
        $('.customers').select2({
            width: '100%'
        });
        $(".panel-heading").parent('.panel').hover(
            function() {
                $(this).children('.collapse').collapse('show');
            },
            function() {
                $(this).children('.collapse').collapse('hide');
            }
        );
        var tables = $("#datatables").DataTable({
            serverSide: true,
            processing: true,
            deferRender: true,
            ajax: {
                url: "{{route('driver.'.$slug , ['id' => $slug])}}",
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
            // scrollY: 500,
            scrollX: true,
            // scrollCollapse: true,
            columnDefs: [{
                    'targets': 0,
                    orderable: false,
                    searchable: false,
                    'checkboxes': {
                        'selectRow': true
                    }
                },
                {
                    "targets": 'no-sort',
                    "orderable": false,
                }
            ],
            'select': {
                'style': 'multi'
            },
            columns: [{
                    data: "id",
                    className: 'id',
                    orderable: false,
                    searchable: false
                },
                {
                    data: "name",
                    className: 'name'
                },
                {
                    data: "email",
                    className: 'email'
                },
                {
                    data: "placement",
                    className: 'placement'
                },
                {
                    data: "district",
                    className: 'district'
                },
                {
                    data: "total_order",
                    className: 'total_order'
                },
                {
                    data: "statuses",
                    className: 'statuses'
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                }
            ]
        });
        $('#choose_placement').on('click', function(e) {
            var rows_selected = tables.column(0).checkboxes.selected();
            console.log(rows_selected.length);
            if (rows_selected.length === 0) {
                $('#placeModal').modal("hide");
                swal("Cancelled", "Mohon Pilih 1 Order Terlebih dahulu", "error");
            } else if (rows_selected.length > 1) {
                $('#placeModal').modal("hide");
                swal("Cancelled", "Mohon Maaf Hanya pilih 1 order untuk ganti Driver", "error");
            } else {
                $('#placeModal').modal("show");

            }
        });
        $('#set_begining_balance').on('click', function(e) {
            var rows_selected = tables.column(0).checkboxes.selected();
            console.log(rows_selected.length);
            if (rows_selected.length === 0) {
                $('#balanceModal').modal("hide");
                swal("Cancelled", "Mohon Pilih 1 Order Terlebih dahulu", "error");
            } else {
                $('#balanceModal').modal("show");

            }
        });
        $('#save_balance').on('click', function(e) {
            var price = $('#price').val();
            if (price === '') {
                swal("Cancelled", "Mohon Masukan Nominal", "error");
            } else {
                var rows_selecteds = tables.column(0).checkboxes.selected();
                var data = [];
                $.each(rows_selecteds, function(index, rowId) {
                    // Create a hidden element                 
                    data.push(rowId);
                });
                // console.log(data);
                $.ajax({
                    url: `{{route('driver.setBalance')}}`,
                    data: {
                        datas: data,
                        begin_balance: price,
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
        });


        $('#statusOnline').on('click', function(e) {
            e.preventDefault();
            changeOnlineStatus(1);
        });
        $('#statusOffline').on('click', function(e) {
            e.preventDefault();
            changeOnlineStatus(0);
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
                    // $('#district').append('<option value="" selected disabled> -- Select District -- </option>');
                    $.each(data, function(key, value) {
                        $("#district").append('<option value=' + value.id + '>' + value.nama + '</option>');
                    });
                    // console.log(data);
                },
                error: function(data) {
                    // console.log(data);
                },
                type: 'GET'
            });
        });
        $('#district').on('change', function() {
            // console.log($('#district').val());
            $.ajax({
                url: `{{route('district.id.bluk')}}`,
                data: {
                    district_id: $('#district').val()
                },
                dataType: 'json',
                beforeSend: function(xhr) {
                    $('#village').attr('disabled', true);
                    $('#village').empty();
                    $('#weight').val(0);
                },
                success: function(data) {
                    console.log(data);
                    // district
                    $('#village').attr('disabled', false);
                    //$('#village').append('<option value="" selected disabled> -- Select Village -- </option>');
                    $.each(data, function(key, value) {
                        $("#village").append('<option value=' + value.id + '>' + value.nama + '</option>');
                    });
                    console.log(data);
                },
                error: function(data) {
                    // console.log(data);
                },
                type: 'GET'
            });
        });
        $('#village').on('change', function() {
            let selectedCity = $('#city').find(":selected").val();
           
            // console.log(selectedCity);
            if (selectedCity !== '7371') {
                // this.countFee()
                $.ajax({
                    url: `{{route('specialDeliveryFee')}}`,
                    data: {
                        selectedVillage: this.value
                    },
                    dataType: 'json',
                    success: function(data) {
                        // console.log(data);
                        
                    },
                    error: function(data) {
                        console.log(data);
                    },
                    type: 'GET'
                });
            } else {
                $('#specialDeliveryFee').val(0);
                // this.countFee()
            }

        });
        $('#save_placement_driver').on('click', function() {
            var cities = $('#city').val();
            var dictricts = (($('#district').val() === '') ? '[]' : $('#district').val());
            var villages = (($('#village').val() === '') ? '[]' : $('#village').val());

            // console.table(cities,dictricts,villages);
            if ((cities === '') && (dictricts === '')) {
                swal("Cancelled", "Mohon Masukan Data", "error");
            } else {
                var rows_selecteds = tables.column(0).checkboxes.selected();
                var data = [];
                $.each(rows_selecteds, function(index, rowId) {
                    // Create a hidden element                 
                    data.push({
                        id: rowId,
                        city:cities,
                        dictrict:dictricts,
                        village:villages,                 
                    });
                });
                // console.log(data);
                $.ajax({
                    url: `{{route('driver.setPlacement')}}`,
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
        });
        
        const changeOnlineStatus = (status) => {
            var rows_selected = tables.column(0).checkboxes.selected();
            
            // console.log(rows_selected.length);
            if (rows_selected.length === 0) {
                $('#balanceModal').modal("hide");
                swal("Cancelled", "Mohon Pilih 1 Order Terlebih dahulu", "error");
            } else {
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, Update it!'
                }).then((result) => {
                    console.log(result);
                    if (result.value) {
                        var data = [];
                        $.each(rows_selected, function(index, rowId) {
                            // Create a hidden element                 
                            data.push(rowId);
                        });
                          // console.log(data);
                        $.ajax({
                            url: `{{route('profile.changeStatus')}}`,
                            data: {
                                datas: data,
                                valueStatus: status,
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
                                tables.draw();
                            },
                            type: 'POST'
                        });
                        // swal("Updated!", "Your file has been updated", "success");
                        
                    }
                })

            }
        }


    });
</script>
@endpush