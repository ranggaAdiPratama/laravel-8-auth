<?php

namespace App\Export;

use App\Order;
use App\Payment;
use App\Cart;
use DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Illuminate\Support\Carbon;
use App\Http\Controllers\OngkirAPIController;
use App\Http\Controllers\CheckoutController;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PHPExcel_Style_Protection;

use Maatwebsite\Excel\Concerns\WithColumnWidths;

// class OrderExport implements FromCollection, WithHeadings, ShouldAutoSize, WithEvents
class DataOrder implements FromView,WithColumnWidths
{
    /**
    * @return \Illuminate\Support\Collection
    */

    public function  __construct($category)
    {
        $this->datePrint = $category;
    }

    public static function getData($category) {
       
        $getData = DB::select('
        SELECT
        `orders`.`id` AS `id`,
        `orders`.`no_order` AS `no_order`,
        `order_statuses`.`status` AS `order_status`,
        `orders`.`created_at` AS `order_date`,
        `orders`.`category_id` AS `category_id`,
        `return`.`status` AS `return_status`,
        `driver_queue`.`d_driver` AS `delivery_driver`,
        `driver_queue`.`p_driver` AS `driver_name`,
        `cust_receiver_add`.`receiver_district` AS `receiver_district`,
        `cust_receiver_add`.`receiver_village` AS `receiver_village`,
        `cust_receiver_add`.`receiver_address` AS `receiver_address`,
        `cust_receiver_add`.`receiver_city` AS `receiver_city`,
        `order_details`.`receiver` AS `receiver_name`,
        `order_details`.`phone` AS `receiver_phone`,
        `users`.`name` AS `client`,
        `user_profiles`.`phone` AS `sender_phone`,
        `user_profiles`.`address` AS `sender_address`,
        `order_details`.`price` AS `price`,
        `order_details`.`delivery_fee` AS `delivery_fee`,
        `order_details`.`name` AS `name`,
        `payment`.`payment_status` AS `payment_status`,
        `payment`.`payment_method` AS `method`,
        `payment`.`payment_method_id` AS `payment_method_id` 
        FROM
            ((((((((((
                                            `orders`
                                                LEFT JOIN `order_statuses` ON ( `orders`.`order_statuses_id` = `order_statuses`.`id` ))
                                            LEFT JOIN `users` ON ( `orders`.`user_id` = `users`.`id` ))
                                        LEFT JOIN `user_profiles` ON ( `orders`.`pickup_address` = `user_profiles`.`id` ))
                                        LEFT JOIN `delivery_addresses` ON ( `orders`.`delivery_address_id` = `delivery_addresses`.`id` ))
                                    LEFT JOIN `return` ON ( `orders`.`id` = `return`.`id_orders` ))
                                LEFT JOIN `driver_queue` ON ( `orders`.`id` = `driver_queue`.`id` ))
                            LEFT JOIN `cust_receiver_add` ON ( `orders`.`id` = `cust_receiver_add`.`id` ))
                        LEFT JOIN `order_details` ON ( `orders`.`id` = `order_details`.`orders_id` ))
                    LEFT JOIN `user_list` ON ( `orders`.`user_id` = `user_list`.`id` ))
            LEFT JOIN `payment` ON ( `orders`.`payment_id` = `payment`.`payment_id` )) 
        WHERE
            cast( `orders`.`created_at` AS date ) = curdate() AND
            orders.category_id = '. $category .'
        GROUP BY orders.id
        ORDER BY
            `orders`.`id` DESC
        ');
        $data = [];
        if (!empty($getData)) {
            foreach ($getData as $val) {
                $date = date_create($val->order_date);
                $arr = array(
                    'id' => $val->id, //1
                    'no_order' => '#' . intval($val->no_order),//2
                    'client' => $val->client,//3
                    'date' => date_format($date, 'Y-m-d H:i:s'),//4
                    'delivery_fee' => intval($val->delivery_fee),
                    'order_status' => $val->order_status,//7
                    'payment_status' => $val->payment_status,
                    'payment_method' => $val->method,
                    'payment_method_id' => $val->payment_method_id,//8
                    'sender_address' => $val->sender_address,
                    'sender_phone' => $val->sender_phone,
                    'receiver_name' => $val->receiver_name,
                    'receiver_phone' => $val->receiver_phone,
                    'receiver_address' => $val->receiver_address,
                    'receiver_district' => $val->receiver_district,
                    'receiver_village' => $val->receiver_village,
                    'price' => intval($val->price),
                    'total' => $val->price + $val->delivery_fee,
                    'driver_name' => $val->driver_name,//5
                    'delivery_driver' => $val->delivery_driver,//6
                    'return_status' => intval($val->return_status)

                );
                array_push($data, $arr);
            }
        } else {
            $data = [];
        }
        // return $data;
         
           
        $values = [
            'orders' =>  $data
        ];

        return $values;


    }

    public function view(): View
    {
        $data = $this->getData( $this->datePrint );
        // dd($data);
        return view('layouts.page_templates.DataOrder', $data);
    }

   

    public function registerEvents(): array
    {
        return [
            AfterSheet::class    => function(AfterSheet $event) {
                $cellRange = 'A1:Z1'; // All headers
                $event->sheet->getDelegate()->getStyle($cellRange)->getFont()->setSize(14);

                $event->sheet->getStyle('A1:Z1000')->getAlignment()->applyFromArray(
                    array('horizontal' => 'center')
                );
                $event->sheet->getStyle('A1:Z1')->getAlignment()->setWrapText(true);
                // $event->sheet->getColumnDimension('D')->setAutoSize(false);
                $event->sheet->setAutoSize(false);
            },
        ];
    }
    public function columnWidths(): array
    {
        return [
            'A' => 5,
            'B' => 20,
            'C' => 20,   
            'D' => 20,   
            'E' => 20,   
            'F' => 20,               
            'G' => 20,   
            'H' => 20,   
            'I' => 20,   
            'J' => 60,   
            'K' => 25,   
            'L' => 20,  
            'M' => 25,   
        ];
    }
}
