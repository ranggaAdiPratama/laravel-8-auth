@extends('layouts.app', ['activePage' => 'wallet', 'titlePage' => __('Driver Wallet')])
@push('css')
<style>
    [role=button] {
        cursor: pointer
    }

    .modal-lg {
        width: 900px !important
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
                            </button> {{ __('Driver Wallet') }}
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
                        <h4 class="card-title">All Drivers Wallet</h4>
                    </div>
                    <div class="card-body">
                        <div class="toolbar">

                            <!--        Here you can write extra buttons/actions for the toolbar              -->
                        </div>
                        <div class="col-lg-12 col-md-12">
                            <div class="card">
                                <div class="card-header card-header-tabs card-header-rose">
                                    <div class="nav-tabs-navigation">
                                        <div class="nav-tabs-wrapper">
                                            <span class="nav-tabs-title">Driver Wallet :</span>
                                            <ul class="nav nav-tabs" data-tabs="tabs">
                                                <li class="nav-item">
                                                    <a class="nav-link active" href="#profile" data-toggle="tab">
                                                        <i class="material-icons">code</i> Reguler
                                                        <div class="ripple-container"></div>
                                                    </a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link" href="#messages" data-toggle="tab">
                                                        <i class="material-icons">grade</i> Express
                                                        <div class="ripple-container"></div>
                                                    </a>
                                                </li>
                                              
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="tab-content">
                                        <div class="tab-pane active" id="profile">
                                            <!-- Section Data Reguler Driver -->
                                            <div class="toolbar">
                                                <div class="row">
                                                    <div class="col-md-6">
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

                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <table id="datatable-reg" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                                                <thead>
                                                    <tr>
                                                        <th class="text-center disabled-sorting "></th>
                                                        <th>Date</th>
                                                        <th>Driver</th>
                                                        <th>Status</th>
                                                        <th>Balance</th>
                                                        <th class="disabled-sorting text-right">Actions</th>
                                                    </tr>
                                                </thead>
                                                <tfoot>
                                                    <tr>
                                                        <th class="text-center disabled-sorting "></th>
                                                        <th>Date</th>
                                                        <th>Driver</th>
                                                        <th>Status</th>
                                                        <th>Balance</th>
                                                        <th class="disabled-sorting text-right">Actions</th>
                                                    </tr>
                                                </tfoot>
                                                <tbody>

                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="tab-pane" id="messages" style="width:100%">
                                            <!-- Section Data Reguler Driver -->
                                            <table id="datatable-exp" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                                                <thead style="width:100%">
                                                    <tr>
                                                        <th class="text-center disabled-sorting no-sort"></th>
                                                        <th>Date</th>
                                                        <th>Driver</th>
                                                        <th>Status</th>
                                                        <th>Balance</th>
                                                        <th class="disabled-sorting text-right">Actions</th>
                                                    </tr>
                                                </thead>
                                                <tfoot>
                                                    <tr>
                                                        <th class="text-center disabled-sorting no-sort"></th>
                                                        <th>Date</th>
                                                        <th>Driver</th>
                                                        <th>Status</th>
                                                        <th>Balance</th>
                                                        <th class="disabled-sorting text-right">Actions</th>
                                                    </tr>
                                                </tfoot>
                                                <tbody>

                                                </tbody>
                                            </table>
                                        </div>
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
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
                            <input type="hidden" name="wallet_id" id="wallet_id">
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

<!-- Detail Saldo-->
<div class="modal fade" id="detailModal" tabindex="-1" aria-labelledby="balanceModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="balanceModalLabel">Set Begining Balance</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-7 col-md-12">
                        <div class="card">
                            <div class="card-header card-header-text card-header-warning">
                                <div class="card-text">
                                    <h4 class="card-title">Wallet</h4>
                                    <p class="card-category">Data Berisi Detail Wallet pada tanggal : </p>
                                </div>
                            </div>
                            <div class="card-body table-responsive">
                                <table id="datatable-detail" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                                    <thead class="text-warning">
                                        <th>Tanggal</th>
                                        <th>Deskripsi</th>
                                        <th>Jenis Transaksi</th>
                                        <th>Nominal</th>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-5 col-md-12">
                        <div class="card">
                            <div class="card-header card-header-icon card-header-rose">
                                <div class="card-icon">
                                    <i class="material-icons">assignment</i>
                                </div>
                                <h4 class="card-title ">Summary</h4>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table">
                                        <tbody>
                                            <tr>
                                                <td>
                                                    Begining Balance
                                                </td>
                                                <td>
                                                    <span id="begining_balance"></span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    Total Debit
                                                </td>
                                                <td>
                                                    <span id="debit"></span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    Total Credit
                                                </td>
                                                <td>
                                                    <span id="credit"></span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    Ending Balance
                                                </td>
                                                <td>
                                                    <span id="ending_balance"></span>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
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
        $('[data-toggle="tooltip"]').tooltip({
            container: 'body'
        });

        var tables_reg = $("#datatable-reg").DataTable({
            autoWidth: false,
            serverSide: true,
            processing: true,
            deferRender: true,
            ajax: {
                url: "{{route('all-wallet-reguler')}}",
                data: function(data) {
                    data.params = {
                            sac: "helo"
                        },
                        data.dates = $('input[name=dates_order]').val(),
                        data.status = $('#status_order').val(),
                        data.type = 'reguler'
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
                'style': 'multi',
                'selector': 'td:first-child',
                selector: 'td:not(:last-child)'
            },
            columns: [{
                    data: "wallet_id",
                    className: 'wallet_id no-sort',
                    searchable: false
                },
                {
                    data: "wallet_date",
                    className: 'wallet_date'
                },
                {
                    data: "driver_name",
                    className: 'driver_name'
                },
                {
                    data: "statuses",
                    className: 'statuses'
                },
                {
                    data: "balance",
                    className: 'ending_balance text-center'
                },
                {
                    data: 'action',
                    name: 'action',
                    className: 'text-right',
                    orderable: false,
                    searchable: false
                }
            ],
            drawCallback: function(settings) {
                $('[data-toggle="tooltip"]').tooltip();
                $("[rel='tooltip']").tooltip({
                    placement: 'left'
                });
            }
        });

        var tables_exp = $("#datatable-exp").DataTable({
            autoWidth: false,
            serverSide: true,
            processing: true,
            deferRender: true,
            ajax: {
                url: "{{route('all-wallet-reguler')}}",
                data: function(data) {
                    data.params = {
                            sac: "helo"
                        },
                        data.dates = $('input[name=dates_order]').val(),
                        data.status = $('#status_order').val(),
                        data.type = 'express'
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
                'style': 'multi',
                'selector': 'td:not(:last-child)'
            },
            columns: [{
                    data: "wallet_id",
                    className: 'wallet_id no-sort',
                    searchable: false
                },
                {
                    data: "wallet_date",
                    className: 'wallet_date'
                },
                {
                    data: "driver_name",
                    className: 'driver_name'
                },
                {
                    data: "statuses",
                    className: 'statuses'
                },
                {
                    data: "balance",
                    className: 'ending_balance text-center'
                },
                {
                    data: 'action',
                    name: 'action',
                    className: 'text-right',
                    orderable: false,
                    searchable: false
                }
            ],
            drawCallback: function(settings) {
                $('[data-toggle="tooltip"]').tooltip();
                $("[rel='tooltip']").tooltip({
                    placement: 'left'
                });
            }
        });
        $('[data-toggle="tab"]').on('click', function() {
            tables_exp.columns.adjust().draw();
            // tables_reg.columns.adjust().draw();
        });
        
        $("#datatable-reg").on("click", ".add_saldo", function() {
            console.log($(this).data("id"));

            $('#balanceModal').modal("show");
            $('#wallet_id').val("");
            $('#wallet_id').val($(this).data("id"));
        });
        var dataTable_detail = $("#datatable-detail").DataTable({
            "orderable": false,
            "searching": false,
            "ordering": false
        });
        $("#datatable-reg").on("click", ".detail_saldo", function() {
            console.log($(this).data("id"));
            var id = $(this).data("id");
            $.ajax({
                url: "{{url('wallet/')}}/" + id,
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
                        $('#detailModal').modal("show");


                        dataTable_detail.clear().draw();
                        $.each(data.data, function(index, value) {
                            console.log(value);
                            // use data table row.add, then .draw for table refresh
                            dataTable_detail.row.add([value.date, value.description, value.type, value.amount]).draw();
                        });
                        $('#begining_balance').text('');
                        $('#begining_balance').text(data.begin_balance);
                        $('#debit').text('');
                        $('#debit').text(data.debit);
                        $('#credit').text('');
                        $('#credit').text(data.credit);
                        $('#ending_balance').text('');
                        $('#ending_balance').text(data.ending_balance);
                    } else {
                        md.showNotification('bottom', 'right', 'There Is Something wrong with this Informations');
                    }
                    // console.log(data);
                },
                error: function(data) {

                },
                type: 'GET'
            });

        });
        $("#save_balance").on("click", function(e) {
            e.preventDefault();
            var price = $('#price').val();
            var wallet_id = $('#wallet_id').val();
            if (price === '' && wallet_id === '') {
                swal("Cancelled", "Mohon Masukan Nominal", "error");
            } else {
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, Save it!'
                }).then((result) => {
                    console.log(result);
                    if (result.value) {

                        // console.log(data);
                        $.ajax({
                            url: `{{route('add_saldo')}}`,
                            data: {
                                id: wallet_id,
                                amount: $('#price').val(),
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
                                console.log(data);
                                swal.close()
                                if (data.status) {
                                    md.showNotification('bottom', 'right', "has been successfully saved");
                                    tables_reg.draw();
                                    tables_exp.draw();

                                } else {
                                    md.showNotification('bottom', 'right', "Oops, Failed to save Data");
                                    tables_reg.draw();
                                    tables_exp.draw();
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
                        // swal("Updated!", "Your file has been updated", "success");

                    }
                })
            }
        });
        $("#datatable-reg").on("click", ".setor", function() {
            var wallet_id = $(this).data("id");
            Swal.fire({
                title: 'Apakah anda yakin ingin menarik saldo?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, Do it!'
            }).then((result) => {
                console.log(result);
                if (result.value) {

                    // console.log(data);
                    $.ajax({
                        url: `{{route('pull_balance')}}`,
                        data: {
                            id: wallet_id,
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
                            console.log(data);
                            swal.close()
                            if (data.status) {
                                md.showNotification('bottom', 'right', "has been successfully saved");
                                tables_reg.draw();
                                tables_exp.draw();

                            } else {
                                md.showNotification('bottom', 'right', "Oops, Failed to save Data");
                                tables_reg.draw();
                                tables_exp.draw();
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
                    // swal("Updated!", "Your file has been updated", "success");

                }
            })
        });
        
    });
</script>
@endpush