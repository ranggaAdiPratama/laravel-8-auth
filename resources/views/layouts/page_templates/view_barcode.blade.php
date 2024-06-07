<div class="page">
        <!-- //foreach -->
        @foreach($dataOrder as $item)
        <div class="border-address">
            <table>
                <tr>
                    <td>
                        <img src="{{asset('dkm.png')}}" width="55px" style="margin: 10px 0 0 10px;">
                    </td>
                    <td>Daeng Kurir<br>Makassar</td>
                </tr>
            </table>
            <div style="margin-left:150px;margin-top:-30px; padding-bottom: 8px;">
                {{$item['category_id']}}
            </div>
            <div style="margin-left:300px;margin-top:-30px;">
                Nomor Resi : {{$item['no_order']}}
            </div>
            <hr style="border: none;border-top: 2px dashed #000000; margin-top: 15px;">
            <table style="width: 100%; margin-bottom: -2px; margin-top: -7px;">
                <tr>
                    <td style="width: 70%; border-right: 2px solid #000000; vertical-align: top; text-align: left;">
                        <table class="font-size" style="margin-bottom: 10px;">
                            <tr>
                                <td style="vertical-align: top; text-align: left; border-right: 1px solid black;">
                                    <b>Penerima</b>
                                </td>
                                <td style="vertical-align: bottom; text-align: left; margin-bottom: 10px;">
                                    {{ $item['receiver_name'] }} <br>
                                    {{ $item['receiver_phone'] }}
                                    <br>
                                    {{ $item['receiver_address'] }},
                                    {{ $item['receiver_district'] }} {{ isset($item['receiver_city']) ? $item['receiver_city'] : ''}}<br>
                                </td>
                            </tr>
                            <tr style="border-bottom: 2px solid black;">
                                <td style="vertical-align: top; text-align: left; border-right: 1px solid black;">
                                    <b>Pengirim</b>
                                </td>
                                <td style="vertical-align: top; text-align: left; margin-bottom: 40px;">
                                    {{ $item['client'] }} <br>
                                    {{ $item['sender_phone'] }} <br>
                                    {{ $item['sender_address'] }}
                                </td>
                            </tr>
                            <tr>
                                <td style="text-align: left; white-space: nowrap;">
                                    <b><br>Biaya Kirim </b>
                                </td>

                                <td style="vertical-align: top; text-align: right;">
                                    <br>
                                    @if($item['payment_method_id'] === '2' || $item['payment_method_id'] === '4')
                                    Rp. {{ number_format($item['delivery_fee'],0,',','.') }}
                                    @else
                                    Rp.0
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td style="text-align: left; border-bottom: 1px solid black; ">
                                    <b>Harga Barang </b>
                                </td>

                                <td style="vertical-align: top; text-align: right; border-bottom: 1px solid black;">
                                    @if($item['payment_method_id'] === '3' || $item['payment_method_id'] === '4')
                                    Rp.0
                                    @else
                                    Rp. {{ number_format($item['price'],0,',','.') }}
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td style="text-align: left; ">
                                    <b>Total Biaya </b>
                                </td>

                                <td style="vertical-align: top; text-align: right;">
                                    @if($item['payment_method_id'] === '1')
                                    Rp. {{ number_format($item['price'],0,',','.') }}
                                    @elseif($item['payment_method_id'] === '2')
                                    Rp. {{ number_format($item['total'],0,',','.') }}
                                    @elseif($item['payment_method_id'] === '3')
                                    Rp. 0
                                    @elseif($item['payment_method_id'] === '4')
                                    Rp. {{ number_format($item['delivery_fee'],0,',','.') }}
                                    @endif
                                </td>
                            </tr>
                        </table>
                    </td>
                    <td class="font-size" style="vertical-align: top;float: none;">
                        <table class="font-size" style="margin-bottom: 10px;">
                            <tr>
                                <td>
                                    <b>Tanggal :</b><br>
                                    {{ $item['date'] }}<br><br>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <b>Driver Pick-up :</b><br>
                                    {{ $item['driver_name'] }}<br><br>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <b>QR CODE:</b><br>
                                    {!! QrCode::size(100)->generate($item['id']) !!}
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </div>
        <hr style="border: none;border-top: 0.5px dotted #000000; margin-top: 8px;">
        @endforeach
        <!-- endforeach -->

    </div>