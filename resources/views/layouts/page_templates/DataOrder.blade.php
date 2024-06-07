<html>
<table>
    <thead>
        <tr>
            <th style="border: thick solid #000000; width: 8px; text-align: center; background-color: yellow;">
                <b style="text-align: center;">No</b>
            </th>
            <th style="border: thick solid #000000; width: 15px; text-align: center; background-color: yellow;">
                <b>No Order</b>
            </th>
            <th style="border: thick solid #000000; width: 20px; text-align: center; background-color: yellow;">
                <b>Pickup Driver</b>
            </th>
            <th style="border: thick solid #000000; width: 20px; text-align: center; background-color: yellow;">
                <b>Delivery Driver</b>
            </th>
            <th style="border: thick solid #000000; width: 20px; text-align: center; background-color: yellow;">
                <b>Total</b>
            </th>
            <th style="border: thick solid #000000; width: 20px; text-align: center; background-color: yellow;">
                <b>Price</b>
            </th>
            <th style="border: thick solid #000000; width: 20px; text-align: center; background-color: yellow;">
                <b>Delivery Fee</b>
            </th>
            <th style="border: thick solid #000000; width: 25px; text-align: center; background-color: yellow;">
                <b>Receiver Name</b>
            </th>
            <th style="border: thick solid #000000; width: 25px; text-align: center; background-color: yellow;">
                <b>Receiver Phone</b>
            </th>
            <th style="border: thick solid #000000; width: 50px; text-align: center; background-color: yellow;">
                <b>Receiver Address</b>
            </th>
            <th style="border: thick solid #000000; width: 25px; text-align: center; background-color: yellow;">
                <b>Payment Method</b>
            </th>
            <th style="border: thick solid #000000; width: 25px; text-align: center; background-color: yellow;">
                <b>Status Order</b>
            </th>
            <th style="border: thick solid #000000; width: 50px; text-align: center; background-color: yellow;">
                <b>Client</b>
            </th>            
        </tr>
       
    </thead>
    <tbody>
            @php
                $sumTotal = 0;
                $sumDeliveryFee =0;
                $sumPrice = 0;
                $countOrder = 0;
            @endphp
        @foreach($orders as $index => $order)
            @php
                $sumTotal += $order['total'];
                $sumDeliveryFee += $order['price'];
                $sumPrice += $order['delivery_fee'];             
            @endphp
            <tr style="background-color: white;">
                <td >
                    <p style="text-align: center;">{{$index + 1}}</p>
                </td>
                <td >
                    {{$order['no_order']}}
                </td>
                <td >
                    <p> {{$order['driver_name']}}</p>
                </td>
                <td >
                    <p> {{$order['delivery_driver']}}</p>
                </td>
                <td style="text-align: right;">
                    <p> Rp. {{number_format(intval($order['total']), 0, ".", ".")}}</p>
                </td>
                <td style="text-align: right;">
                    <p> Rp. {{number_format(intval($order['price']), 0, ".", ".")}}</p>
                </td>
                <td style="text-align: right;">
                    <p> Rp. {{number_format(intval($order['delivery_fee']), 0, ".", ".")}}</p>
                </td>
                <td >
                    <p> {{$order['receiver_name']}}</p>
                </td>
                <td >
                    <p> {{$order['receiver_phone']}}</p>
                </td>
                <td >
                    <p> {{$order['receiver_address']}}</p>
                </td>
                <td >
                    <p> {{$order['payment_method']}}</p>
                </td>
                <td >
                    <p> {{$order['order_status']}}</p>
                </td>
                <td>
                    <p> {{$order['client']}}</p>
                </td>     
            </tr>   
           
        @endforeach
            <tr>
                <td colspan= 3>
                    Total Order Hari ini {{count($orders)}}
                </td>
                <td style="text-align: right;">
                       Jumlah : 
                </td>
                <td style="border: thick solid #000000; width: 50px; text-align: right; background-color: yellow;">
                     Rp. {{number_format(intval($sumTotal), 0, ".", ".")}}
                </td>
                <td style="border: thick solid #000000; width: 50px; text-align: right; background-color: yellow;">
                    <p>Rp. {{number_format(intval($sumPrice), 0, ".", ".")}}</p>
                </td>
                <td style="border: thick solid #000000; width: 50px; text-align: right; background-color: yellow;">
                    <p>Rp. {{number_format(intval($sumDeliveryFee), 0, ".", ".")}}</p>
                </td>
                <td >
                    
                </td>
                <td>
                    
                </td>
                <td >
                    
                </td>
                <td >
                    
                </td>
                <td >
                    
                </td>
                <td >
                    
                </td>
                <td >
                   
                </td>
                <td >
                   
                </td>
                <td>
                    
                </td>     
            </tr> 
      

    </tbody>
</table>

</html>