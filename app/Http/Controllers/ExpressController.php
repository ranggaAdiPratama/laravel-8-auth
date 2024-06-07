<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Models\Order\Order;
use DataTables;

class ExpressController extends Controller
{
    public function index()
    {
        $data = DB::table('user_list')->where('role', 'customer')->get();
        $special_city = DB::table('city')->join('service_area', 'city.id', 'service_area.city_id')->orderBy('nama')->get();
        $payment_methods = DB::table('payment_methods')->get();
        // $getDriver = DB::table('driver_list')->get();
        $getDriver = DB::select('SELECT drivers.user_id as id, users.name as name FROM `drivers` inner join users on drivers.user_id = users.id where drivers.driver_category_id =2 and users.online = 1 order by users.name asc');

        $fee = DB::select('select * from delivery_fee_exp order by id ASC LIMIT 1');
        // return response()->json(['amount' => intval($fee[0]->amount)]); 
        $delivery_fee = intval($fee[0]->amount);
        // dd(intval($fee[0]->amount));
        // dd($allExpress);
        return view('express/index', ["data" => $data, "city" => $special_city, "payment_method" => $payment_methods, 'driver' => $getDriver, 'delivery_fee' => $delivery_fee]);
    }
    public function allExpressDisplay(Request $request)
    {
        if ($request->ajax()) {
            if (!empty($request->get('dates'))) {
                if (!empty($request->get('status'))) {
                    $allExpres = $this->allExpressByDate($request->get('dates'), $request->get('status'));
                } else {
                    $allExpres = $this->allExpressByDate($request->get('dates'));
                }
            } else {
                if (!empty($request->get('status'))) {
                    $allExpres = $this->allExpress($request->get('status'));
                } else {
                    $allExpres = $this->allExpress();
                }
            }
            // 
            return Datatables::of($allExpres)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '<a href="/administrator/order-detail/' . substr($row['no_order'], 1) . '" class="btn btn-link btn-info btn-just-icon like"><i class="material-icons">visibility</i></a>';
                    $btn = $btn . '<a href="#" class="btn btn-link btn-warning btn-just-icon edit"><i class="material-icons">mode_edit</i></a>';
                    $btn = $btn . '<a href="#" class="btn btn-link btn-danger btn-just-icon remove"><i class="material-icons">close</i></a>';

                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
            // return DataTables::queryBuilder($allRegulers)->toJson();
        }
    }
    public function userListCustomer()
    {
        $data = DB::table('user_list')->where('role', 'customer')->get();
        $special_city = DB::table('city')->join('service_area', 'city.id', 'service_area.city_id')->orderBy('nama')->get();
        $district = DB::table('districts')->get();
        $village = DB::table('villages')->get();
        $payment_methods = DB::table('payment_methods')->get();
        $del_fee_list = DB::table('delivery_fee_list')->get();
        if (!empty($data)) {
            return response()->json([
                'data' => $data,
                'districts' => $district,
                'village' => $village,
                'methods' => $payment_methods,
                'del_fee_list' => $del_fee_list,
                'city' => $special_city
            ], 200);
        }
        return response()->json('Data Tidak Ditemukan');
    }

    public function createOrder(Request $request)
    {
        $this->validate($request, [
            'name'  => 'required',
            'weight' => 'required',
            'volume' => 'required',
            'price' => 'required'
            // 'photo' => 'required|image',
        ]);
        $id = $request->input('user_id');

        $numb = rand(0, 999999);
        $date = str_shuffle(date('dY'));
        $code = substr($numb + $date, 0, 6);
        $district = DB::table('user_profiles')->where('user_id', $id)->first('district_id')->district_id;
        $village = DB::table('user_profiles')->where('user_id', $id)->first('village_id')->village_id;
        $price = $request->input('price');
        $price = (int)str_replace('.', '',  $price);
        $category_id = $request->input('category_id');

        $w = $request->input('weight');
        $delivery_fee = $request->input('delivery_fee');
        $delivery_fee = (int)str_replace('.', '',  $delivery_fee);
        //Check Customer
        $checkCust = DB::table('pre-pickup-assigned-check')->where('user_id', $id)->where('district_id', $district)->get();
        //Assign Pickup Driver
        if ($category_id == 1) {
            $order_status = 1;
            if (count($checkCust) == 0 && $request->input('village') === "null") {
                $getDriver = DB::select('
                    SELECT
                    user_id, 
                    coalesce(count, 0) as count
                    FROM
                    drivers
                    LEFT JOIN
                    count_driver_order
                    ON 
                    drivers.user_id = count_driver_order.id
                    Join users 
                    ON users.id = drivers.user_id
                    WHERE
                    drivers.district_placementt  LIKE "%' . $district . '%" 
                        AND
                        drivers.driver_category_id = 1
                        AND
                        coalesce(count, 0) < 60
                        AND
                        users.online = 1
                    ORDER BY
                        count ASC
                    LIMIT 1
                    ');
            } elseif (count($checkCust) == 0 && $request->input('village') !== "null") {
                $getDriver = DB::select('
                                SELECT
                                user_id, 
                                coalesce(count, 0) as count
                                FROM
                                drivers
                                LEFT JOIN
                                count_driver_order
                                ON 
                                    drivers.user_id = count_driver_order.id
                                Join users 
                                ON users.id = drivers.user_id
                                WHERE
                                drivers.district_placementt LIKE "%' . $district . '%"
                                AND
                                drivers.village_placement LIKE "%' . $village . '%"
                                AND
                                drivers.driver_category_id = 1
                                AND
                                coalesce(count, 0) < 60
                                AND
                                users.online = 1
                                ORDER BY
                                    count ASC
                                LIMIT 1');
            } else {
                $getDriver = $checkCust[0]->driver_id_pickup;
            }
        } else {
            $order_status = 4;
            if ($request->input('village') === "null") {
                $getDriver = DB::select('
            SELECT
            user_id, 
            coalesce(count, 0) as count
            FROM
                drivers
                LEFT JOIN
                count_driver_order
                ON 
                drivers.user_id = count_driver_order.id
                Join users 
                ON users.id = drivers.user_id
            WHERE
                drivers.district_placement LIKE "%' . $district . '%" 
                AND
                drivers.driver_category_id = 2
                AND
                coalesce(count, 0) < 60
                AND
                users.online = 1
            ORDER BY
                count ASC
            LIMIT 1
            ');
            } elseif ($request->input('village') !== "null") {
                $getDriver = DB::select('
                        SELECT
                        user_id, 
                        coalesce(count, 0) as count
                        FROM
                        drivers
                        LEFT JOIN
                        count_driver_order
                        ON 
                        drivers.user_id = count_driver_order.id
                        Join users 
                        ON users.id = drivers.user_id
                        WHERE
                        drivers.district_placement LIKE "%' . $district . '%"
                        AND
                        drivers.village_placement LIKE "%' . $village . '%"
                        AND
                        drivers.driver_category_id = 2
                        AND
                        coalesce(count, 0) < 60
                        AND
                        users.online = 1
                        ORDER BY
                            count ASC
                        LIMIT 1');
                        if (!empty($getDriver) && is_array($getDriver)){
                            $driver =  $getDriver[0]->user_id;
                        }else{
                            $driver = $request->input('delivery_driver');
                        }
                $available = DB::table('drivers')->where('user_id', $driver)->update(['available' => 1]);
            }
        }
        // dd($request);
        //insert photo
        if ($request->hasFile('photo')) {
            $fileExtension = $request->file('photo')->getClientOriginalName();
            $file = pathinfo($fileExtension, PATHINFO_FILENAME);
            $extension = $request->file('photo')->getClientOriginalExtension();
            $fileStore = $file . '_' . time() . '.' . $extension;
            $img = 'photo/product/' . base64_encode($fileStore);
            $path = $request->file('photo')->storeAs('photo/product', $fileStore);
        } else {
            $img = 'photo/product/bm8tdGh1bWJuYWlsXzE2MTQwNTIwNjMuanBn';
        }

        //Create Payment
        $payment_id = DB::table('payments')->insertGetId([
            'user_id' => $id,
            'status' => 1,
            'price' => $price,
            'payment_method_id' => $request->input('payment_method')
        ]);

        //Create Delivery Address
        $deliv_address = DB::table('delivery_addresses')->insertGetId([
            'address' =>   $request->input('description_address'),
            'description' =>  $request->input('description_address_null'),
            'city_id' =>  $request->input('city'),
            'district' =>  $request->input('district'),
            'village' =>  $request->input('village'),
            'latitude' => $request->input('latitude'),
            'longitude' =>  $request->input('longitude'),
            'user_id' => $id
        ]);

        if (!empty($getDriver) && is_array($getDriver)) {
            $driver =  $getDriver[0]->user_id;
        } else {
            $driver = 2;
        }
        $order = new Order;
        $order->user_id = $id;
        $order->no_order = $code;
        $order->order_statuses_id = $order_status;
        $order->driver_id_pickup = $driver;
        $order->driver_id_deliver = $request->input('delivery_driver');
        $order->created_at = date('Y-m-d H:i:s', strtotime("+7 hours"));
        if ($category_id == 2) {
            $order->driver_id_deliver = $driver;
        }
        $order->delivery_address_id = $deliv_address;
        $order->payment_id = $payment_id;
        $order->pickup_status = 0;
        $order->category_id = $category_id;
        $order->save();
        $id_order = $order->id;

        $detail = DB::table('order_details')->insertGetId([
            'orders_id' => $id_order,
            'name' => $request->input('name'),
            'price' => $price,
            'description' => $request->input('description_order'),
            'weight' => $request->input('weight'),
            'volume' => $request->input('volume'),
            'receiver' => $request->input('receiver_name'),
            'phone' => $request->input('receiver_phone'),
            'description' => $request->input('description_address'),
            'delivery_fee' => $delivery_fee,
            'photo' => $img,
            'category_id' => 0

        ]);
        $getCount = DB::table('count_driver_order')->where('id', $driver)->first();
        if (!empty($detail)) {
            DB::table('drivers')
                ->where('user_id', $getCount->id)
                ->update(['total_orders' => $getCount->count]);
            return redirect()->back()->with('success', 'Orderan Berhasil Di buat');
        }

        return redirect()->back()->with('error', 'Orderan Gagal Dibuat Di buat');
        // return redirect()->back()->with('success', 'Orderan Berhasil Di buat');
        // return redirect()->back()->with('error', 'Orderan Gagal Dibuat Di buat');   
    }
  
    public function allExpress($status_order = null)
    {
        if ($status_order != null) {
            if ($status_order == 99) {
                $query = '';
            } else {
                $query = 'AND  orders.order_statuses_id = ' . $status_order;
            }
        } else {
            $query = '';
        }

        $getData = DB::select('
        SELECT
        `orders`.`id` AS `id`,
        `orders`.`no_order` AS `no_order`,
        `orders`.`created_at` AS `order_date`,
        `orders`.`category_id` AS `category_id`,
        `order_statuses`.`status` AS `order_status`,
        `return`.`status` AS `return_status`,
        `driver_queue`.`d_driver` AS `delivery_driver`,
        `driver_queue`.`p_driver` AS `driver_name`,
        `cust_receiver_add`.`receiver_district` AS `receiver_district`,
        `cust_receiver_add`.`receiver_village` AS `receiver_village`,
        `cust_receiver_add`.`receiver_address` AS `receiver_address`,
        `cust_receiver_add`.`receiver_city` AS `receiver_city`,
        `users`.`name` AS `client`,
        `payment`.`payment_status` AS `payment_status`,
        `payment`.`payment_method` AS `method`,
        `payment`.`payment_method_id` AS `payment_method_id`
        FROM
           ((((((
                                            `orders`
                                                LEFT JOIN `order_statuses` ON ( `orders`.`order_statuses_id` = `order_statuses`.`id` ))
                                            LEFT JOIN `users` ON ( `orders`.`user_id` = `users`.`id` ))
                                    LEFT JOIN `return` ON ( `orders`.`id` = `return`.`id_orders` ))
                            LEFT JOIN `driver_queue` ON ( `orders`.`id` = `driver_queue`.`id` ))
                    LEFT JOIN `cust_receiver_add` ON ( `orders`.`id` = `cust_receiver_add`.`id` ))
            LEFT JOIN `payment` ON ( `orders`.`payment_id` = `payment`.`payment_id` ))
        WHERE
            cast( `orders`.`created_at` AS date ) = curdate() AND
            orders.category_id = 2 ' . $query . '
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
                    'order_status' => $val->order_status,
                    'payment_method_id' => $val->payment_method_id,
                    'driver_name' => $val->driver_name,
                    'delivery_driver' => $val->delivery_driver,
                    'return_status' => intval($val->return_status),
                    'receiver_address' =>(is_null($val->receiver_address) ) ? 'Tidak ada Address' :  $val->receiver_address,
                    'receiver_district' => (is_null($val->receiver_district) ) ? 'Tidak ada District' : $val->receiver_district,
                    'receiver_village' =>(is_null( $val->receiver_village) ) ? 'Tidak ada Village' :  $val->receiver_village
                );
                array_push($data, $arr);
            }
        } else {
            return $data = [];
        }
        return $data;
    }

    public function allExpressByDate($date, $status_order = null)
    {
        // $date = $request->input('date');
        if ($status_order != null) {
            if ($status_order == 99) {
                $query = '';
            } else {
                $query = 'AND  orders.order_statuses_id = ' . $status_order;
            }
        } else {
            $query = '';
        }
        $getData = DB::select('
        SELECT
        `orders`.`id` AS `id`,
        `orders`.`no_order` AS `no_order`,
        `orders`.`created_at` AS `order_date`,
        `orders`.`category_id` AS `category_id`,
        `order_statuses`.`status` AS `order_status`,
        `return`.`status` AS `return_status`,
        `driver_queue`.`d_driver` AS `delivery_driver`,
        `driver_queue`.`p_driver` AS `driver_name`,
        `cust_receiver_add`.`receiver_district` AS `receiver_district`,
        `cust_receiver_add`.`receiver_village` AS `receiver_village`,
        `cust_receiver_add`.`receiver_address` AS `receiver_address`,
        `cust_receiver_add`.`receiver_city` AS `receiver_city`,
        `users`.`name` AS `client`,
        `payment`.`payment_status` AS `payment_status`,
        `payment`.`payment_method` AS `method`,
        `payment`.`payment_method_id` AS `payment_method_id`
        FROM
           ((((((
                                            `orders`
                                                LEFT JOIN `order_statuses` ON ( `orders`.`order_statuses_id` = `order_statuses`.`id` ))
                                            LEFT JOIN `users` ON ( `orders`.`user_id` = `users`.`id` ))
                                    LEFT JOIN `return` ON ( `orders`.`id` = `return`.`id_orders` ))
                            LEFT JOIN `driver_queue` ON ( `orders`.`id` = `driver_queue`.`id` ))
                        LEFT JOIN `cust_receiver_add` ON ( `orders`.`id` = `cust_receiver_add`.`id` ))
            LEFT JOIN `payment` ON ( `orders`.`payment_id` = `payment`.`payment_id` ))
        WHERE
        cast( `orders`.`created_at` AS date ) = "' . $date . '" AND
        orders.category_id = 2 ' . $query . '
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
                    'order_status' => $val->order_status,
                    'payment_method_id' => $val->payment_method_id,
                    'driver_name' => $val->driver_name,
                    'delivery_driver' => $val->delivery_driver,
                    'return_status' => intval($val->return_status),
                    'receiver_address' =>(is_null($val->receiver_address) ) ? 'Tidak ada District' :  $val->receiver_address,
                    'receiver_district' => (is_null($val->receiver_district) ) ? 'Tidak ada District' : $val->receiver_district,
                    'receiver_village' =>(is_null( $val->receiver_village) ) ? 'Tidak ada District' :  $val->receiver_village
                );
                array_push($data, $arr);
            }
        } else {
            return $data = [];
        }
        return $data;
    }
    public function changeDriverFilterList(Request $request)
    {
        $req = $request->order_id;
        $district = DB::select('
                            SELECT
                            orders.user_id, 
                            user_profiles.user_id, 
                            user_profiles.district_id AS district, 
                            user_profiles.village_id AS village
                            FROM
                            orders
                            INNER JOIN
                            user_profiles
                            ON 
                            orders.user_id = user_profiles.user_id
                            WHERE orders.id = ' . $req);
        // $data = DB::table('driver_list')->where('district_placement_id',$district[0]->district)->where('village_placement_id', 'like', '%'.$district[0]->village.'%')->select('id','name')->get();                            
        $data = DB::table('driver_list_exp')->where('online', 1)->select('id', 'name')->get();
        if (!empty($data)) {
            return response()->json(['data' => $data], 200);
        }
        return response()->json('Data Not Found', 200);
    }
}
