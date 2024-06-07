@extends('layouts.app', ['activePage' => 'user-management', 'titlePage' => __('User Management')])

@section('content')
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
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
                <div class="card">
                    <div class="card-header card-header-primary">
                        <h4 class="card-title ">Users</h4>
                        <p class="card-category"> Here you can manage users</p>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12 text-right">
                                <a href="#" class="btn btn-sm btn-primary form-create-button">Add user</a>
                            </div>
                        </div>
                        <!-- FORM  -->
                        <div class="col-md-12 " id="form-create" style="display:none">
                            <form method="post" action="{{route('create.users')}}" class="form-horizontal">
                                @csrf
                                <div class="row">
                                    <!-- Customer Fields -->
                                    <div class="col-md-6">
                                        <div class="card ">
                                            <div class="card-header card-header-rose card-header-text">
                                                <div class="card-text">
                                                    <h4 class="card-title">Step One</h4>
                                                </div>
                                            </div>
                                            <div class="card-body ">
                                                <div class="row">
                                                    <label class="col-form-label">Role</label>
                                                    <div class="col-sm-12">
                                                        <div class="form-group bmd-form-group">
                                                            <select class="customers form-control" id="role_id" name="role_id" data-style="select-with-transition" title="city">
                                                                <option value="" selected disabled> -- Select Role-- </option>
                                                                @foreach($role as $data)
                                                                <option value="{{$data->id}}"> {{$data->name}} </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <hr />
                                                <div class="row">
                                                    <div class="col-sm-12">
                                                        <div class="form-group bmd-form-group">
                                                            <label class="bmd-label-floating">Name</label>
                                                            <input type="text" class="form-control" name="name" required="true">
                                                            <span class="bmd-help">Naa User Wajib.</span>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-12">
                                                        <div class="form-group bmd-form-group">
                                                            <label class="bmd-label-floating">Email</label>
                                                            <input type="text" class="form-control" name="email" required="true">
                                                            <span class="bmd-help">Email User Wajib.</span>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-12">
                                                        <br>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <div class="form-group bmd-form-group">
                                                            <label class="bmd-label-floating">Phone</label>
                                                            <input type="number" class="form-control" name="phone" required="true" min=0>
                                                            <span class="bmd-help">*wajib.</span>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <div class="form-group bmd-form-group">
                                                            <label class="bmd-label-floating">Phone2</label>
                                                            <input type="number" class="form-control" name="phone2">
                                                            <span class="bmd-help">*optional</span>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-12">
                                                        <div class="form-group bmd-form-group">
                                                            <label class="bmd-label-floating">Password</label>
                                                            <input type="password" class="form-control" name="password" required="true">
                                                            <span class="bmd-help">*Wajib Diisi</span>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-12">
                                                        <div class="form-group bmd-form-group">
                                                            <label class="bmd-label-floating">Password Confirmation</label>
                                                            <input type="password" class="form-control" name="password_confirmation" required="true">
                                                            <span class="bmd-help">*Wajib Disini</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-sm-12">
                                                        <div class="form-group bmd-form-group">
                                                            <label class="bmd-label-floating">Address</label>
                                                            <textarea id="address" cols="30" rows="8" class="form-control" name="address"></textarea>
                                                            <span class="bmd-help">*Masukan Alamat User.</span>
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
                                                    <h4 class="card-title">Step Two</h4>
                                                </div>
                                            </div>
                                            <div class="card-body ">

                                                <div class="row">
                                                    <label class="col-form-label">Select City</label>
                                                    <div class="col-sm-12">
                                                        <div class="form-group bmd-form-group">
                                                            <select class="customers form-control" id="city_id" name="city_id" data-style="select-with-transition" title="city">
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
                                                            <select class="customers form-control" id="district_id" name="district_id" data-style="select-with-transition" title="Select district" disabled>
                                                                <option value="" selected disabled> -- Select District -- </option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <label class="col-sm-3 col-form-label">Select Village</label>
                                                    <div class="col-sm-12">
                                                        <div class="form-group bmd-form-group">
                                                            <select class="customers form-control" id="village_id" name="village_id" data-style="select-with-transition" title="Select village" disabled>
                                                                <option value="" selected disabled> -- Select Village -- </option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6 col-sm-6">
                                                        <h4 class="title">Foto</h4>
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
                                                    <input type="submit" value="Create User" name="submit" class="btn btn-primary btn-lg">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="table-responsive">
                            <table id="datatables" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                                <thead>
                                    <tr>
                                        <th class="text-center disabled-sorting "></th>
                                        <th>Nama</th>
                                        <th>Email</th>
                                        <th>No. Telp</th>
                                        <th>Address</th>
                                        <th>Role</th>
                                        <th>Status</th>                                        
                                        <th class="disabled-sorting text-right">Actions</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th class="text-center disabled-sorting "></th>
                                        <th>Nama</th>
                                        <th>Email</th>
                                        <th>No. Telp</th>
                                        <th>Address</th>
                                        <th>Role</th>
                                        <th>Status</th>                                        
                                        <th class="disabled-sorting text-right">Actions</th>
                                    </tr>
                                </tfoot>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="alert alert-danger">
                    <span style="font-size:18px;">
                        <b> </b> This is a PRO feature!</span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('js')
<script src="https://gyrocode.github.io/jquery-datatables-checkboxes/1.2.12/js/dataTables.checkboxes.min.js"></script>

<script>
    $(document).ready(function() {
        $('.customers').select2({
            width: '100%'
        });
        $('.form-create-button').click(function() {
            $('#form-create').toggle();
        });
        $('#city_id').on('change', function() {
            $.ajax({
                url: `{{route('city.id')}}`,
                data: {
                    city_id: this.value
                },
                dataType: 'json',
                beforeSend: function(xhr) {
                    $('#district_id').attr('disabled', true);
                    $('#village_id').attr('disabled', true);
                    $('#district_id').empty();
                },
                success: function(data) {
                    // district
                    $('#district_id').attr('disabled', false);
                    $('#district_id').append('<option value="" selected disabled> -- Select District -- </option>');
                    $.each(data, function(key, value) {
                        $("#district_id").append('<option value=' + value.id + '>' + value.nama + '</option>');
                    });
                    console.log(data);
                },
                error: function(data) {
                    // console.log(data);
                },
                type: 'GET'
            });
        });
        $('#district_id').on('change', function() {
            $.ajax({
                url: `{{route('district.id')}}`,
                data: {
                    district_id: this.value
                },
                dataType: 'json',
                beforeSend: function(xhr) {
                    $('#village_id').attr('disabled', true);
                    $('#village_id').empty();
                },
                success: function(data) {
                    // district
                    $('#village_id').attr('disabled', false);
                    $('#village_id').append('<option value="" selected disabled> -- Select Village -- </option>');
                    $.each(data, function(key, value) {
                        $("#village_id").append('<option value=' + value.id + '>' + value.nama + '</option>');
                    });
                    // console.log(data);
                },
                error: function(data) {
                    console.log(data);
                },
                type: 'GET'
            });
        });
        var tables_reg = $("#datatables").DataTable({
            autoWidth: false,
            serverSide: true,
            processing: true,
            deferRender: true,
            responsive:true,
            ajax: {
                url: "{{route('all-inOne')}}",
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
                    data: "id",
                    className: 'id no-sort',
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
                    data: "phone",
                    className: 'phone'
                },
                {
                    data: "address",
                    className: 'address'
                },
                {
                    data: "role",
                    className: 'role'
                },
                {
                    data: "statuses",
                    className: 'statuses'
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
    });
</script>
@endpush