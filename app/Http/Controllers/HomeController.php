<?php

namespace App\Http\Controllers;

use App\Models\User;
use DB;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $currentWeek = DB::select('
        select coalesce(t.Minggu,0) as Minggu, coalesce(t.Senin,0) as Senin,
        coalesce(t.Selasa,0) as Selasa, coalesce(t.Rabu,0) as Rabu, coalesce(t.Kamis,0) as Kamis,
        coalesce(t.Jumat,0) as Jumat, coalesce(t.Sabtu,0) as Sabtu, t.tahun, t.bulan ,
        GREATEST(coalesce(t.Minggu,0) , coalesce(t.Senin,0), coalesce(t.Selasa,0),coalesce(t.Rabu,0) , coalesce(t.Kamis,0) ,coalesce(t.Jumat,0) ,coalesce(t.Sabtu,0)
        ) as MaxValues
            from 
        (select year(`created_at`) as tahun, month(`created_at`) as bulan, week(`created_at`),
            sum(case when DAYOFWEEK(`created_at`) = 1 then 1 end) as Minggu,
            sum(case when DAYOFWEEK(`created_at`) = 2 then 1 end) as Senin,
            sum(case when DAYOFWEEK(`created_at`) = 3 then 1 end) as Selasa,
            sum(case when DAYOFWEEK(`created_at`) = 4 then 1 end) as Rabu,
            sum(case when DAYOFWEEK(`created_at`) = 5 then 1 end) as Kamis,
            sum(case when DAYOFWEEK(`created_at`) = 6 then 1 end) as Jumat,
            sum(case when DAYOFWEEK(`created_at`) = 7 then 1 end) as Sabtu
        from `orders` where week(`created_at`) = week(CURDATE())
        group by week(`created_at`), year(`created_at`)) t');
        if (empty($currentWeek)) {
            $currentWeek = [
                0 => (object) [
                    'Minggu' => 0,
                    'Senin' => 0,
                    'Selasa' => 0,
                    'Rabu' => 0,
                    'Kamis' => 0,
                    'Jumat' => 0,
                    'Sabtu' => 0,
                    'MaxValues' => 0

                ]                    
            ];
        }
        // dd($currentWeek);
        return view('dashboard',['orderINaWeek' => $currentWeek]);
    }

    public function detail($no_order){
      
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
            orders.no_order = '. $no_order .'
        GROUP BY orders.id
        ORDER BY
            `orders`.`id` DESC
        ');
        $data = [];
        if (!empty($getData)) {
            foreach ($getData as $val) {
                $date = date_create($val->order_date);
                $arr = array(
                    'id' => $val->id,
                    'no_order' => '#' . intval($val->no_order),
                    'client' => $val->client,
                    'date' => date_format($date, 'Y-m-d H:i:s'),
                    'delivery_fee' => intval($val->delivery_fee),
                    'order_status' => $val->order_status,
                    'payment_status' => $val->payment_status,
                    'payment_method' => $val->method,
                    'payment_method_id' => $val->payment_method_id,
                    'sender_address' => $val->sender_address,
                    'sender_phone' => $val->sender_phone,
                    'receiver_name' => $val->receiver_name,
                    'receiver_phone' => $val->receiver_phone,
                    'receiver_address' => $val->receiver_address,
                    'receiver_district' => $val->receiver_district,
                    'receiver_village' => $val->receiver_village,
                    'price' => intval($val->price),
                    'total' => $val->price + $val->delivery_fee,
                    'driver_name' => $val->driver_name,
                    'delivery_driver' => $val->delivery_driver,
                    'return_status' => intval($val->return_status)

                );
                array_push($data, $arr);
            }
        } else {
            $data = [];
        }
        return view('layouts.page_templates.detail_order',['dataOrder'=>$data]);
        // dd($data);
    }
    public function clearRoute()
    {
        // \Artisan::call('route:clear');
        // \Artisan::call('view:clear');
        // \Artisan::call('cache:clear');
        // \Artisan::call('clear-compiled');
        

    }
}
