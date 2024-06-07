@extends('layouts.app', ['activePage' => 'reguler', 'titlePage' => __('Order Detail')])

@section('content')

<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 ml-auto mr-auto">
                <div class="page-categories">
                    <h3 class="title text-center">Detail Order {{$dataOrder[0]['no_order']}}</h3>
                    <br />                    
                    <ul class="nav nav-pills nav-pills-warning nav-pills-icons justify-content-center" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" data-toggle="tab" href="#link7" role="tablist">
                                <i class="material-icons">info</i> Description
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#link8" role="tablist">
                                <i class="material-icons">payments</i> Payment
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#link9" role="tablist">
                                <i class="material-icons">location_on</i> Status
                            </a>
                        </li>
                        <!-- <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#link10" role="tablist">
                                <i class="material-icons">help_outline</i> Help Center
                            </a>
                        </li> -->
                    </ul>
                    <div class="tab-content tab-space tab-subcategories">
                        <div class="tab-pane active" id="link7">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">Description about Client</h4>
                                    <p class="card-category">
                                        Who is the Receiver ?
                                    </p>
                                </div>
                                <div class="card-body">
                                <!-- <p class="text-center justify-content-center">{!! QrCode::size(100)->generate($dataOrder[0]['id']) !!}</p><br/> -->
                                    {{ $dataOrder[0]['receiver_name'] }} <br>
                                    {{ $dataOrder[0]['receiver_phone'] }}
                                    <br>
                                    {{ $dataOrder[0]['receiver_address'] }},
                                    {{ $dataOrder[0]['receiver_district'] }} {{ isset($dataOrder[0]['receiver_city']) ? $dataOrder[0]['receiver_city'] : ''}}
                                    <hr />
                                    <p class="card-category">
                                        Who is the Sender ?
                                    </p>
                                    {{ $dataOrder[0]['client'] }} <br>
                                    {{ $dataOrder[0]['sender_phone'] }} <br>
                                    {{ $dataOrder[0]['sender_address'] }}
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane" id="link8">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">Information About The Prices</h4>
                                    <p class="card-category">
                                        shipping cost
                                    </p>
                                </div>
                                <div class="card-body">
                                    @if($dataOrder[0]['payment_method_id'] === '2' || $dataOrder[0]['payment_method_id'] === '4')
                                    Rp. {{ number_format($dataOrder[0]['delivery_fee'],0,',','.') }}
                                    @else
                                    Rp.0
                                    @endif
                                    <hr />
                                    <p class="card-category">
                                        price of an item
                                    </p>
                                    @if($dataOrder[0]['payment_method_id'] === '3' || $dataOrder[0]['payment_method_id'] === '4')
                                    Rp.0
                                    @else
                                    Rp. {{ number_format($dataOrder[0]['price'],0,',','.') }}
                                    @endif
                                    <hr />
                                    <p class="card-category">
                                        Total Cost
                                    </p>
                                    @if($dataOrder[0]['payment_method_id'] === '1')
                                    Rp. {{ number_format($dataOrder[0]['price'],0,',','.') }}
                                    @elseif($dataOrder[0]['payment_method_id'] === '2')
                                    Rp. {{ number_format($dataOrder[0]['total'],0,',','.') }}
                                    @elseif($dataOrder[0]['payment_method_id'] === '3')
                                    Rp. 0
                                    @elseif($dataOrder[0]['payment_method_id'] === '4')
                                    Rp. {{ number_format($dataOrder[0]['delivery_fee'],0,',','.') }}
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane" id="link9">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">Package status</h4>
                                    <p class="card-category">
                                        Status Package
                                    </p>
                                </div>
                                <div class="card-body">
                                        Pickup Driver :
                                    <br>
                                        Delivery Driver :
                                    <br>
                                    <p class="card-category">
                                        What is status of this package? 
                                    </p>
                                        <ul class="timeline timeline-simple">
                                            <li class="timeline-inverted">
                                                <div class="timeline-badge danger">
                                                    <i class="material-icons">card_travel</i>
                                                </div>
                                                <div class="timeline-panel">
                                                    <div class="timeline-heading">
                                                        <span class="badge badge-pill badge-danger">Some title</span>
                                                    </div>
                                                    <div class="timeline-body">
                                                        <p>Wifey made the best Father's Day meal ever. So thankful so happy so blessed. Thank you for making my family We just had fun with the “future” theme !!! It was a fun night all together ... The always rude Kanye Show at 2am Sold Out Famous viewing @ Figueroa and 12th in downtown.</p>
                                                    </div>
                                                    <h6>
                                                        <i class="ti-time"></i> 11 hours ago via Twitter
                                                    </h6>
                                                </div>
                                            </li>
                                            <li class="timeline-inverted">
                                                <div class="timeline-badge success">
                                                    <i class="material-icons">extension</i>
                                                </div>
                                                <div class="timeline-panel">
                                                    <div class="timeline-heading">
                                                        <span class="badge badge-pill badge-success">Another One</span>
                                                    </div>
                                                    <div class="timeline-body">
                                                        <p>Thank God for the support of my wife and real friends. I also wanted to point out that it’s the first album to go number 1 off of streaming!!! I love you Ellen and also my number one design rule of anything I do from shoes to music to homes is that Kim has to like it....</p>
                                                    </div>
                                                </div>
                                            </li>
                                            <li class="timeline-inverted">
                                                <div class="timeline-badge info">
                                                    <i class="material-icons">fingerprint</i>
                                                </div>
                                                <div class="timeline-panel">
                                                    <div class="timeline-heading">
                                                        <span class="badge badge-pill badge-info">Another Title</span>
                                                    </div>
                                                    <div class="timeline-body">
                                                        <p>Called I Miss the Old Kanye That’s all it was Kanye And I love you like Kanye loves Kanye Famous viewing @ Figueroa and 12th in downtown LA 11:10PM</p>
                                                        <p>What if Kanye made a song about Kanye Royère doesn't make a Polar bear bed but the Polar bear couch is my favorite piece of furniture we own It wasn’t any Kanyes Set on his goals Kanye</p>
                                                        <hr>
                                                        <div class="dropdown pull-left">
                                                            <button type="button" class="btn btn-round btn-info dropdown-toggle" data-toggle="dropdown">
                                                                <i class="material-icons">build</i>
                                                                <span class="caret"></span>
                                                            </button>
                                                            <ul class="dropdown-menu dropdown-menu-right" role="menu">
                                                                <li>
                                                                    <a href="#action">Action</a>
                                                                </li>
                                                                <li>
                                                                    <a href="#action">Another action</a>
                                                                </li>
                                                                <li>
                                                                    <a href="#here">Something else here</a>
                                                                </li>
                                                                <li class="divider"></li>
                                                                <li>
                                                                    <a href="#link">Separated link</a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <!-- <div class="tab-pane" id="link10">
                                <div class="card">
                                    <div class="card-header">
                                        <h4 class="card-title">Help center</h4>
                                        <p class="card-category">
                                            More information here
                                        </p>
                                    </div>
                                    <div class="card-body">
                                        From the seamless transition of glass and metal to the streamlined profile, every detail was carefully considered to enhance your experience. So while its display is larger, the phone feels just right.
                                        <br>
                                        <br> Another Text. The first thing you notice when you hold the phone is how great it feels in your hand. The cover glass curves down around the sides to meet the anodized aluminum enclosure in a remarkable, simplified design.
                                    </div>
                                </div>
                            </div> -->
                        </div>
                    </div>
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
            md.initFormExtendedDatetimepickers();
            demo.showSwal();            
        });
    </script>
    @endpush