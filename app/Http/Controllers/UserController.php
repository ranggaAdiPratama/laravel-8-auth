<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Models\Order\Order;
use App\Models\User;
use DataTables;
use Illuminate\Support\Collection;
use Excel;
use Carbon\Carbon;
use App\Export\DataOrder;

class RegulerController extends Controller
{
    public function index()
    {
        $data = DB::table('users')->where('role_id', 5)->get();
        $special_city = DB::table('city')->join('service_area', 'city.id', 'service_area.city_id')->orderBy('nama')->get();
        $payment_methods = DB::table('payment_methods')->get();
        // $getDriver = DB::table('driver_list')->get();
        $getDriver = DB::select('SELECT drivers.user_id as id, users.name as name FROM `drivers` inner join users on drivers.user_id = users.id where drivers.driver_category_id =1 and users.online = 1 order by users.name asc');

        $fee = DB::select('select * from delivery_fee_exp order by id ASC LIMIT 1');
        // return response()->json(['amount' => intval($fee[0]->amount)]);
        // dd($del_fee_list);

        return view('reguler/index', ["data" => $data, "city" => $special_city, "payment_method" => $payment_methods, 'driver' => $getDriver]);
    }
    public function allRegulerDisplay(Request $request)
    {
        // if ($request->ajax()) {
        if (!empty($request->get('dates'))) {
            if (!empty($request->get('status'))) {
                $allRegulers = $this->allRegulerByDate($request->get('dates'), $request->get('status'));
            } else {
                $allRegulers = $this->allRegulerByDate($request->get('dates'));
            }
        } else {
            if (!empty($request->get('status'))) {
                $allRegulers = $this->allReguler($request->get('status'));
            } else {
                $allRegulers = $this->allReguler();
            }
        }

        //
        return Datatables::of($allRegulers)
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
        // }
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
    public function area()
    {
        $district = DB::table('districts')->get();
        $village = DB::table('villages')->get();
        $special_city = DB::table('city')->join('service_area', 'city.id', 'service_area.city_id')->orderBy('nama')->get();

        return response()->json([
            'district' => $district,
            'village' => $village,
            'special_city' => $special_city
        ]);
    }
    public function region()
    {
        $special_city = DB::table('city')->join('service_area', 'city.id', 'service_area.city_id')->orderBy('nama')->get();
        $city = DB::table('city')->orderBy('nama')->get();
        $district = DB::table('district')->orderBy('nama')->get();
        $village = DB::table('village')->orderBy('nama')->get();

        return response()->json(['city' => $city, 'district' => $district, 'village' => $village, 'special_city' => $special_city]);
    }
    public function specialDeliveryFee(Request $req)
    {
        $selectedVillage = $req->selectedVillage;
        // $get = DB::table('special_region')->where('village_id', $selectedVillage)->first()->delivery_fee;
        $get = DB::table('special_region')->where('village_id', $selectedVillage)->first();
        if (!$get) {
            return response()->json(intval(0));
        } else {
            $get = $get->delivery_fee;
            $d = DB::table('delivery_fee_list')->first()->price;
            $add = intval($get) - intval($d);
            return response()->json(intval($add));
        }
    }

    public function specialPickupFee(Request $req)
    {
        $user_id = $req->user_id;
        $g = DB::table('user_profiles')->leftJoin('special_region', 'special_region.village_id', 'user_profiles.village_id')->where('user_id', $user_id)->first()->pickup_fee;
        // $get = DB::table('special_region')->where('village_id',$g)->first()->pickup_fee;
        $del_fee_list = DB::table('delivery_fee_list')->get();

        if ($g !== null) {
            $d = DB::table('delivery_fee_list')->first()->price;
            $add = intval($g) - intval($d);
            $price = intval($add);
            // return response()->json(intval($add));
        } else {
            $price = intval(0);
        }
        $data = [
            'del_fee_list' => $del_fee_list,
            'price' => $price
        ];
        // return response()->json(0);
        return response()->json($data);
    }

    public function getDistrictByCityId(Request $req)
    {
        $city_id = $req->city_id;
        $district = DB::table('districts')->where('kabupaten_id', $city_id)->get();
        return response()->json($district);
    }
    public function getVillageByDistrictIdBulk(Request $req)
    {
        $related = new Collection();
        for ($i = 0; $i < count($req->district_id); $i++) {
            $village = DB::table('wilayah_desa')->where('kecamatan_id', $req->district_id[$i])->get();
            $related = $related->merge($village);
        }
        return response()->json($related);
        // dd('cek');
        // $district_id = $req->district_id;
        // $village = DB::table('villages')->where('kecamatan_id', $district_id)->get();
        // return response()->json($village);
    }
    public function getVillageByDistrictId(Request $req)
    {
        $district_id = $req->district_id;
        $village = DB::table('wilayah_desa')->where('kecamatan_id', $district_id)->get();
        return response()->json($village);
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
        // dd($price);
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
                if (!empty($getDriver) && is_array($getDriver)) {
                    $driver =  $getDriver[0]->user_id;
                } else {
                    $driver = $request->input('delivery_driver');
                }
                $available = DB::table('drivers')->where('user_id', $driver)->update(['available' => 1]);
            }
        }

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

    public function allReguler($status_order = null)
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
        `users`.`name` AS `client`,
        `payment`.`payment_status` AS `payment_status`,
        `payment`.`payment_method` AS `method`,
        `payment`.`payment_method_id` AS `payment_method_id`
        FROM
           (((((
                                            `orders`
                                                LEFT JOIN `order_statuses` ON ( `orders`.`order_statuses_id` = `order_statuses`.`id` ))
                                            LEFT JOIN `users` ON ( `orders`.`user_id` = `users`.`id` ))
                                    LEFT JOIN `return` ON ( `orders`.`id` = `return`.`id_orders` ))
                            LEFT JOIN `driver_queue` ON ( `orders`.`id` = `driver_queue`.`id` ))
            LEFT JOIN `payment` ON ( `orders`.`payment_id` = `payment`.`payment_id` ))
        WHERE
            cast( `orders`.`created_at` AS date ) = curdate() AND
            orders.category_id = 1 ' . $query . '
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
                    'return_status' => intval($val->return_status)
                    // 'receiver_address' =>(is_null($val->receiver_address) ) ? 'Tidak ada Address' :  $val->receiver_address,
                    // 'receiver_district' => (is_null($val->receiver_district) ) ? 'Tidak ada District' : $val->receiver_district,
                    // 'receiver_village' =>(is_null( $val->receiver_village) ) ? 'Tidak ada Village' :  $val->receiver_village
                );
                array_push($data, $arr);
            }
        } else {
            return $data = [];
        }
        return $data;
    }

    public function allRegulerBackup($status_order = null)
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
            orders.category_id = 1 ' . $query . '
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
            return $data = [];
        }
        return $data;
    }
    public function allRegulerByDate($date, $status_order = null)
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
        `users`.`name` AS `client`,
        `payment`.`payment_status` AS `payment_status`,
        `payment`.`payment_method` AS `method`,
        `payment`.`payment_method_id` AS `payment_method_id`
        FROM
           (((((
                                            `orders`
                                                LEFT JOIN `order_statuses` ON ( `orders`.`order_statuses_id` = `order_statuses`.`id` ))
                                            LEFT JOIN `users` ON ( `orders`.`user_id` = `users`.`id` ))
                                    LEFT JOIN `return` ON ( `orders`.`id` = `return`.`id_orders` ))
                            LEFT JOIN `driver_queue` ON ( `orders`.`id` = `driver_queue`.`id` ))
            LEFT JOIN `payment` ON ( `orders`.`payment_id` = `payment`.`payment_id` ))
        WHERE
        cast( `orders`.`created_at` AS date ) = "' . $date . '" AND
        orders.category_id = 1 ' . $query . '
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
                    'return_status' => intval($val->return_status)
                    // 'receiver_address' =>(is_null($val->receiver_address) ) ? 'Tidak ada Address' :  $val->receiver_address,
                    // 'receiver_district' => (is_null($val->receiver_district) ) ? 'Tidak ada District' : $val->receiver_district,
                    // 'receiver_village' =>(is_null( $val->receiver_village) ) ? 'Tidak ada Village' :  $val->receiver_village
                );
                array_push($data, $arr);
            }
        } else {
            return $data = [];
        }
        return $data;
    }
    public function RegulerByNoOrder($id_order)
    {

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
            orders.id = ' . $id_order . '
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
                    'return_status' => intval($val->return_status),
                    'category_id' => ($val->category_id == 1) ? 'Reguler' : 'Express'

                );
            }
        } else {
            $arr = [];
        }
        return $arr;
        // dd($data);
    }
    public function countCustomer()
    {
        $order = DB::select('select * from orders where cast(created_at AS date ) = curdate()');
        $driver = DB::table('drivers')->where('driver_category_id', 1)->get();
        $driverExp = DB::table('drivers')->where('driver_category_id', 2)->get();
        $cust =   User::where('role_id', 5)->get();
        $cust_today =   DB::select('select * from users where role_id = 5 AND cast(created_at AS date ) = curdate()');
        // return $cust_today;

        return response()->json([
            'total_exp' => count($driverExp),
            'total_user' => count($cust_today),
            'total_order' => count($order),
            'total_reg' => count($driver)
        ]);
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
        $data = DB::table('driver_list')->where('online', 1)->select('id', 'name')->get();
        if (!empty($data)) {
            return response()->json(['data' => $data], 200);
        }
        return response()->json('Data Not Found', 200);
    }
    public function changeDriverPickUp(Request $request)
    {

        $update = DB::table('orders')->where('id', $request->order_id)->Update([
            'driver_id_pickup' => $request->driver_id
        ]);

        if ($update) {
            $this->sendPickupNotif($request->driver_id);
            return response()->json([
                'status' => true,
                'msg'    => 'data successfully saved'
            ]);
        } else {
            return response()->json([
                'status' => false,
                'msg'    => 'Failed to save the Data.'
            ]);
        }
    }
    public function changeDriverDelivery(Request $request)
    {
        $update = DB::table('orders')->where('id', $request->order_id)->Update([
            'driver_id_deliver' => $request->driver_id
        ]);

        if ($update) {
            $this->sendPickupNotif($request->driver_id);
            return response()->json([
                'status' => true,
                'msg'    => 'data successfully saved'
            ]);
        } else {
            return response()->json([
                'status' => false,
                'msg'    => 'Failed to save the Data.'
            ]);
        }
    }
    public function sendPickupNotif($id_driver)
    {
        // $id_driver = 851;
        $user = DB::table('users')->where('id', $id_driver)->get();
        $dev_id = array();
        $name = '';
        foreach ($user as $val) {
            array_push($dev_id, $val->device_id);
            $name = $val->name;
        }
        // return $dev_id;
        $url = 'https://fcm.googleapis.com/fcm/send';
        $dataArr = array('click_action' => 'FLUTTER_NOTIFICATION_CLICK', 'status' => "done");
        $notification = array('title' => 'Hai ada orderan baru, yuk cek orderan', 'body' => 'hai ' . $name . '!', 'sound' => 'default', 'badge' => '1');

        $arrayToSend = array('registration_ids' => $dev_id, 'notification' => $notification, 'data' => $dataArr);
        $fields = json_encode($arrayToSend);
        $headers = array(
            'Authorization: key=' . "AAAAeKmGD5s:APA91bHlguaxpl0DqrFm3oZnQcnKh1kMhZwq1s30zF-d_B1INlF9QPVKvgQt5pkw5UIOBdNNGhiK_6ZbFiGXYWKiGsj1fjIiQ3MMkXhKq9h8VRapfg0GkMnM6GcypB5tqomME5n3u2Ot",
            'Content-Type: application/json'
        );
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);

        $result = curl_exec($ch);
        //var_dump($result);
        curl_close($ch);
        return $result;
    }
    public function status(Request $request)
    {
        date_default_timezone_set('Asia/Makassar');
        $req = $request->all();
        $response = [];
        // return response()->json($req['datas']);
        foreach ($req['datas'] as $key => $val) {
            if ($val['status'] == 2) {
                $query = Order::join('payments', 'payments.id', 'orders.payment_id')
                    ->where('orders.id', intval($val['id']))
                    ->update([
                        'pickup_status' => 0,
                        'order_statuses_id' => $val['status'],
                        'pickup_at' => date('Y-m-d H:i:s')
                    ]);
                if ($query) {
                    $response = [
                        'status' => true,
                        'msg'    => 'data successfully saved'
                    ];
                } else {
                    $response = [
                        'status' => false,
                        'msg'    => 'Sorry, There is something Wrong!'
                    ];
                }
                //Barang diambil dengan talangan & ongkir di tanggung pengirim
            } elseif ($val['status'] == 1) {
                $query = Order::where('id', intval($val['id']))
                    ->update([
                        'order_statuses_id' => $val['status']
                    ]);
                if ($query) {
                    $response = [
                        'status' => true,
                        'msg'    => 'data successfully saved'
                    ];
                } else {
                    $response = [
                        'status' => false,
                        'msg'    => 'Sorry, There is something Wrong!'
                    ];
                }
            } elseif ($val['status'] == 3 && $val['bailout'] == 1 && $val['method'] == 1) {
                $getAmount = DB::table('order_details')->where('orders_id', $val['id'])->select('price', 'delivery_fee')->get();
                $user_id = DB::table('orders')->where('id', $val['id'])->select('driver_id_pickup', 'no_order')->get();
                $wallet_id = DB::select('select id from wallet where user_id = ' . intval($user_id[0]->driver_id_pickup) . ' AND CAST(created_at as DATE) = CURRENT_DATE  AND status = 0 OR user_id =' . intval($user_id[0]->driver_id_pickup) . ' AND CAST(created_at as date) < CURRENT_DATE AND status = 0');
                $debit = DB::table('wallet_transaction')
                    ->insert([
                        'wallet_id' => $wallet_id[0]->id,
                        'type' => 'debit',
                        'description' => 'Talangan Barang (#' . $user_id[0]->no_order . ')',
                        'amount' => -$getAmount[0]->price
                    ]);
                $credit = DB::table('wallet_transaction')
                    ->insert([
                        'wallet_id' => $wallet_id[0]->id,
                        'type' => 'credit',
                        'description' => 'Ongkir (#' . $user_id[0]->no_order . ')',
                        'amount' => $getAmount[0]->delivery_fee
                    ]);

                $query = Order::where('id', intval($val['id']))
                    ->update([
                        'pickup_status' => 1,
                        'order_statuses_id' => $val['status'],
                        'bailout_id' => $val['bailout'],
                        'pickup_at' => date('Y-m-d H:i:s')
                    ]);
                if ($query) {
                    $response = [
                        'status' => true,
                        'msg'    => 'data successfully saved'
                    ];
                } else {
                    $response = [
                        'status' => false,
                        'msg'    => 'Sorry, There is something Wrong!'
                    ];
                }
                //Barang diambil tanpa talangan & ongkir di tanggung pengirim
            } elseif ($val['status'] == 3 && $val['bailout'] == 2 && $val['method'] == 1) {
                $getAmount = DB::table('order_details')->where('orders_id', $val['id'])->select('price', 'delivery_fee')->get();
                $user_id = DB::table('orders')->where('id', $val['id'])->select('driver_id_pickup', 'no_order')->get();
                $wallet_id = DB::select('select id from wallet where user_id = ' . intval($user_id[0]->driver_id_pickup) . ' AND CAST(created_at as DATE) = CURRENT_DATE AND status = 0 OR user_id =' . intval($user_id[0]->driver_id_pickup) . ' AND CAST(created_at as date) < CURRENT_DATE AND status = 0');
                $credit = DB::table('wallet_transaction')
                    ->insert([
                        'wallet_id' => $wallet_id[0]->id,
                        'type' => 'credit',
                        'description' => 'Ongkir (#' . $user_id[0]->no_order . ')',
                        'amount' => $getAmount[0]->delivery_fee
                    ]);
                $query = Order::where('id', intval($val['id']))
                    ->update([
                        'pickup_status' => 1,
                        'order_statuses_id' => $val['status'],
                        'bailout_id' => $val['bailout'],
                        'pickup_at' => date('Y-m-d H:i:s')
                    ]);
                if ($query) {
                    $response = [
                        'status' => true,
                        'msg'    => 'data successfully saved'
                    ];
                } else {
                    $response = [
                        'status' => false,
                        'msg'    => 'Sorry, There is something Wrong!'
                    ];
                }
                //Barang diambil dengan talangan & ongkir di tanggung penerima
            } elseif ($val['status'] == 3 && $val['bailout'] == 1 && $val['method'] == 2) {
                $getAmount = DB::table('order_details')->where('orders_id', $val['id'])->select('price', 'delivery_fee')->get();
                $user_id = DB::table('orders')->where('id', $val['id'])->select('driver_id_pickup', 'no_order')->get();
                $wallet_id = DB::select('SELECT id from wallet where user_id =' . intval($user_id[0]->driver_id_pickup) . ' AND CAST(created_at as date) = CURRENT_DATE AND status = 0 OR user_id =' . intval($user_id[0]->driver_id_pickup) . ' AND CAST(created_at as date) < CURRENT_DATE AND status = 0');
                $debit = DB::table('wallet_transaction')
                    ->insert([
                        'wallet_id' => $wallet_id[0]->id,
                        'type' => 'debit',
                        'description' => 'Talangan Barang (#' . $user_id[0]->no_order . ')',
                        'amount' => -$getAmount[0]->price
                    ]);
                $query = Order::where('id', intval($val['id']))
                    ->update([
                        'pickup_status' => 1,
                        'order_statuses_id' => $val['status'],
                        'bailout_id' => $val['bailout'],
                        'pickup_at' => date('Y-m-d H:i:s')
                    ]);
                if ($query) {
                    $response = [
                        'status' => true,
                        'msg'    => 'data successfully saved'
                    ];
                } else {
                    $response = [
                        'status' => false,
                        'msg'    => 'Sorry, There is something Wrong!'
                    ];
                }
                //Barang diambil tanpa talangan & ongkir di tanggung penerima
            } elseif ($val['status'] == 3 && $val['bailout'] == 2 && $val['method'] == 2) {
                $query = Order::where('id', intval($val['id']))
                    ->update([
                        'pickup_status' => 1,
                        'order_statuses_id' => $val['status'],
                        'bailout_id' => $val['bailout'],
                        'pickup_at' => date('Y-m-d H:i:s')
                    ]);
                if ($query) {
                    $response = [
                        'status' => true,
                        'msg'    => 'data successfully saved'
                    ];
                } else {
                    $response = [
                        'status' => false,
                        'msg'    => 'Sorry, There is something Wrong!'
                    ];
                }
                //Driver Assign
            } elseif ($val['status'] == 4) {
                if ($val['driver'] == "") {
                    $query = Order::where('id', intval($val['id']))
                        ->update([
                            'order_statuses_id' => $val['status'],
                            'pickup_at' => date('Y-m-d H:i:s')
                        ]);
                    if ($query) {
                        $response = [
                            'status' => true,
                            'msg'    => 'data successfully saved'
                        ];
                    } else {
                        $response = [
                            'status' => false,
                            'msg'    => 'Sorry, There is something Wrong!'
                        ];
                    }
                } else {
                    $query = Order::where('id', intval($val['id']))
                        ->update([
                            'order_statuses_id' => $val['status'],
                            'driver_id_deliver' => $val['driver'],
                            'pickup_at' => date('Y-m-d H:i:s')
                        ]);
                    if ($query) {
                        $response = [
                            'status' => true,
                            'msg'    => 'data successfully saved'
                        ];
                    } else {
                        $response = [
                            'status' => false,
                            'msg'    => 'Sorry, There is something Wrong!'
                        ];
                    }
                }
                //Barang diambil ongkir di tanggung pengirim
            } elseif ($val['status'] == 11) {
                if ($val['driver'] == "") {
                    $query = Order::where('id', intval($val['id']))
                        ->update([
                            'order_statuses_id' => 4,
                            'pickup_status' => 0,
                            'pickup_at' => null
                        ]);
                    if ($query) {
                        $response = [
                            'status' => true,
                            'msg'    => 'data successfully saved'
                        ];
                    } else {
                        $response = [
                            'status' => false,
                            'msg'    => 'Sorry, There is something Wrong!'
                        ];
                    }
                } else {
                    $query = Order::where('id', intval($val['id']))
                        ->update([
                            'order_statuses_id' => 4,
                            'driver_id_deliver' => $val['driver'],
                            'pickup_status' => 0,
                            'pickup_at' => null
                        ]);

                    if ($query) {
                        $response = [
                            'status' => true,
                            'msg'    => 'data successfully saved'
                        ];
                    } else {
                        $response = [
                            'status' => false,
                            'msg'    => 'Sorry, There is something Wrong!'
                        ];
                    }
                }
                //Barang diambil ongkir di tanggung pengirim
            } elseif ($val['status'] == 3 && $val['bailout'] == 2 && $val['method'] == 3) {
                $getAmount = DB::table('order_details')->where('orders_id', $val['id'])->select('price', 'delivery_fee')->get();
                $user_id = DB::table('orders')->where('id', $val['id'])->select('driver_id_pickup', 'no_order')->get();
                $wallet_id = DB::select('select id from wallet where user_id = ' . intval($user_id[0]->driver_id_pickup) . ' AND CAST(created_at as DATE) = CURRENT_DATE AND status = 0 OR user_id =' . intval($user_id[0]->driver_id_pickup) . ' AND CAST(created_at as date) < CURRENT_DATE AND status = 0');
                $credit = DB::table('wallet_transaction')
                    ->insert([
                        'wallet_id' => $wallet_id[0]->id,
                        'type' => 'credit',
                        'description' => 'Ongkir (#' . $user_id[0]->no_order . ')',
                        'amount' => $getAmount[0]->delivery_fee
                    ]);
                $query = Order::where('id', intval($val['id']))
                    ->update([
                        'pickup_status' => 1,
                        'order_statuses_id' => $val['status'],
                        'bailout_id' => $val['bailout'],
                        'pickup_at' => date('Y-m-d H:i:s')
                    ]);
                if ($query) {
                    $response = [
                        'status' => true,
                        'msg'    => 'data successfully saved'
                    ];
                } else {
                    $response = [
                        'status' => false,
                        'msg'    => 'Sorry, There is something Wrong!'
                    ];
                }
                //Barang diambil ongkir di tanggung penerima
            } elseif ($val['status'] == 3 && $val['bailout'] == 2 && $val['method'] == 4) {
                $query = Order::where('id', intval($val['id']))
                    ->update([
                        'pickup_status' => 1,
                        'order_statuses_id' => $val['status'],
                        'bailout_id' => $val['bailout'],
                        'pickup_at' => date('Y-m-d H:i:s')
                    ]);

                if ($query) {
                    $response = [
                        'status' => true,
                        'msg'    => 'data successfully saved'
                    ];
                } else {
                    $response = [
                        'status' => false,
                        'msg'    => 'Sorry, There is something Wrong!'
                    ];
                }
                //Barang diantar dengan tagihan
            } elseif ($val['status'] == 5 && $val['method'] == 1) {
                $getAmount = DB::table('order_details')->where('orders_id', $val['id'])->select('price', 'delivery_fee')->get();
                $order = DB::table('orders')->join('delivery_addresses', 'delivery_addresses.id', 'orders.delivery_address_id')->where('orders.id', $val['id'])->select('driver_id_deliver', 'no_order', 'delivery_addresses.district')->get();
                $wallet_id = DB::select('SELECT id from wallet where user_id =' . intval($order[0]->driver_id_deliver) . ' AND CAST(created_at as date) = CURRENT_DATE AND status = 0 OR user_id =' . intval($order[0]->driver_id_deliver) . ' AND CAST(created_at as date) < CURRENT_DATE AND status = 0');
                $credit = DB::table('wallet_transaction')
                    ->insert([
                        'wallet_id' => $wallet_id[0]->id,
                        'type' => 'credit',
                        'description' => 'Pembayaran Barang (#' . $order[0]->no_order . ')',
                        'amount' => $getAmount[0]->price
                    ]);
                $query = Order::where('id', intval($val['id']))
                    ->update([
                        'order_statuses_id' => $val['status'],
                        'delivered_at' => date('Y-m-d H:i:s')
                    ]);
                if ($query) {
                    $response = [
                        'status' => true,
                        'msg'    => 'data successfully saved'
                    ];
                } else {
                    $response = [
                        'status' => false,
                        'msg'    => 'Sorry, There is something Wrong!'
                    ];
                }
            }
            //Barang diantar dengan tagihan dan ongkir
            elseif ($val['status'] == 5 && $val['method'] == 2) {
                $getAmount = DB::table('order_details')->where('orders_id', $val['id'])->select('price', 'delivery_fee')->get();
                $order = DB::table('orders')->join('delivery_addresses', 'delivery_addresses.id', 'orders.delivery_address_id')->where('orders.id', $val['id'])->select('driver_id_deliver', 'no_order', 'delivery_addresses.district')->get();
                $wallet_id = DB::select('SELECT id from wallet where user_id =' . intval($order[0]->driver_id_deliver) . ' AND CAST(created_at as date) = CURRENT_DATE AND status = 0 OR user_id =' . intval($order[0]->driver_id_deliver) . ' AND CAST(created_at as date) < CURRENT_DATE AND status = 0');
                $credit = DB::table('wallet_transaction')
                    ->insert([
                        'wallet_id' => $wallet_id[0]->id,
                        'type' => 'credit',
                        'description' => 'Pembayaran Barang (#' . $order[0]->no_order . ')',
                        'amount' => $getAmount[0]->price
                    ]);
                $credit2 = DB::table('wallet_transaction')
                    ->insert([
                        'wallet_id' => $wallet_id[0]->id,
                        'type' => 'credit',
                        'description' => 'Ongkir (#' . $order[0]->no_order . ')',
                        'amount' => $getAmount[0]->delivery_fee
                    ]);
                $query = Order::where('id', intval($val['id']))
                    ->update([
                        'order_statuses_id' => $val['status'],
                        'delivered_at' => date('Y-m-d H:i:s')
                    ]);

                if ($query) {
                    $response = [
                        'status' => true,
                        'msg'    => 'data successfully saved'
                    ];
                } else {
                    $response = [
                        'status' => false,
                        'msg'    => 'Sorry, There is something Wrong!'
                    ];
                }
                //Barang diantar tanpa tagihan dan ongkir
            } elseif ($val['status'] == 5 && $val['method'] == 3) {
                $order = DB::table('orders')->join('delivery_addresses', 'delivery_addresses.id', 'orders.delivery_address_id')->where('orders.id', $val['id'])->select('driver_id_deliver', 'no_order', 'delivery_addresses.district')->get();
                $query = Order::where('id', intval($val['id']))
                    ->update([
                        'order_statuses_id' => $val['status'],
                        'delivered_at' => date('Y-m-d H:i:s')
                    ]);
                if ($query) {
                    $response = [
                        'status' => true,
                        'msg'    => 'data successfully saved'
                    ];
                } else {
                    $response = [
                        'status' => false,
                        'msg'    => 'Sorry, There is something Wrong!'
                    ];
                }
                //Barang diantar dengan ongkir tanpa tagihan
            } elseif ($val['status'] == 5 && $val['method'] == 4) {
                $getAmount = DB::table('order_details')->where('orders_id', $val['id'])->select('price', 'delivery_fee')->get();
                $order = DB::table('orders')->join('delivery_addresses', 'delivery_addresses.id', 'orders.delivery_address_id')->where('orders.id', $val['id'])->select('driver_id_deliver', 'no_order', 'delivery_addresses.district')->get();
                $wallet_id = DB::select('SELECT id from wallet where user_id =' . intval($order[0]->driver_id_deliver) . ' AND CAST(created_at as date) = CURRENT_DATE AND status = 0 OR user_id =' . intval($user_id[0]->driver_id_deliver) . ' AND CAST(created_at as date) < CURRENT_DATE AND status = 0');
                $credit2 = DB::table('wallet_transaction')
                    ->insert([
                        'wallet_id' => $wallet_id[0]->id,
                        'type' => 'credit',
                        'description' => 'Ongkir (#' . $order[0]->no_order . ')',
                        'amount' => $getAmount[0]->delivery_fee
                    ]);
                $query = Order::where('id', intval($val['id']))
                    ->update([
                        'order_statuses_id' => $val['status'],
                        'delivered_at' => date('Y-m-d H:i:s')
                    ]);

                if ($query) {
                    $response = [
                        'status' => true,
                        'msg'    => 'data successfully saved'
                    ];
                } else {
                    $response = [
                        'status' => false,
                        'msg'    => 'Sorry, There is something Wrong!'
                    ];
                }
                //Cancel Order
            } elseif ($val['status'] == 6) {
                if ($val['cancel'] == 'pickup') {
                    if ($val['status'] == 6 && $val['method'] == 1) {
                        $getAmount = DB::table('order_details')->where('orders_id', $val['id'])->select('price', 'delivery_fee')->get();
                        $order = DB::table('orders')->join('delivery_addresses', 'delivery_addresses.id', 'orders.delivery_address_id')->where('orders.id', $val['id'])->select('driver_id_pickup', 'no_order', 'delivery_addresses.district')->get();
                        $wallet_id = DB::select('SELECT id from wallet where user_id =' . intval($order[0]->driver_id_pickup) . ' AND CAST(created_at as date) = CURRENT_DATE AND status = 0 OR user_id =' . intval($order[0]->driver_id_pickup) . ' AND CAST(created_at as date) < CURRENT_DATE AND status=0');
                        $credit = DB::table('wallet_transaction')->insert([
                            'wallet_id' => $wallet_id[0]->id,
                            'type' => 'credit',
                            'description' => 'Pengembalian pembayaran barang (#' . $order[0]->no_order . ')',
                            'amount' => $getAmount[0]->price
                        ]);
                        $debit = DB::table('wallet_transaction')
                            ->insert([
                                'wallet_id' => $wallet_id[0]->id,
                                'type' => 'debit',
                                'description' => 'Pengembalian ongkir(#' . $order[0]->no_order . ')',
                                'amount' => -$getAmount[0]->delivery_fee
                            ]);
                        $query = Order::where('id', intval($val['id']))
                            ->update([
                                'order_statuses_id' => $val['status'],
                                'pickup_at' => date('Y-m-d H:i:s')
                            ]);
                    } elseif ($val['status'] == 6 && $val['method'] == 2) {
                        $getAmount = DB::table('order_details')->where('orders_id', $val['id'])->select('price', 'delivery_fee')->get();
                        $order = DB::table('orders')->join('delivery_addresses', 'delivery_addresses.id', 'orders.delivery_address_id')->where('orders.id', $val['id'])->select('driver_id_pickup', 'no_order', 'delivery_addresses.district')->get();
                        $wallet_id = DB::select('SELECT id from wallet where user_id =' . intval($order[0]->driver_id_pickup) . ' AND CAST(created_at as date) = CURRENT_DATE AND status = 0 OR user_id =' . intval($order[0]->driver_id_pickup) . ' AND CAST(created_at as date) < CURRENT_DATE AND status=0');
                        $credit = DB::table('wallet_transaction')->insert([
                            'wallet_id' => $wallet_id[0]->id,
                            'type' => 'credit',
                            'description' => 'Pengembalian pembayaran barang (#' . $order[0]->no_order . ')',
                            'amount' => $getAmount[0]->price
                        ]);
                        $query = Order::where('id', intval($val['id']))
                            ->update([
                                'order_statuses_id' => $val['status'],
                                'pickup_at' => date('Y-m-d H:i:s')
                            ]);
                    } elseif ($val['status'] == 6 && $val['method'] == 3) {
                        $getAmount = DB::table('order_details')->where('orders_id', $val['id'])->select('price', 'delivery_fee')->get();
                        $order = DB::table('orders')->join('delivery_addresses', 'delivery_addresses.id', 'orders.delivery_address_id')->where('orders.id', $val['id'])->select('driver_id_pickup', 'no_order', 'delivery_addresses.district')->get();
                        $wallet_id = DB::select('SELECT id from wallet where user_id =' . intval($order[0]->driver_id_pickup) . ' AND CAST(created_at as date) = CURRENT_DATE AND status = 0 OR user_id =' . intval($order[0]->driver_id_pickup) . ' AND CAST(created_at as date) < CURRENT_DATE AND status=0');
                        $debit = DB::table('wallet_transaction')->insert([
                            'wallet_id' => $wallet_id[0]->id,
                            'type' => 'debit',
                            'description' => 'Pengembalian ongkir(#' . $order[0]->no_order . ')',
                            'amount' => -$getAmount[0]->delivery_fee
                        ]);
                        $query = Order::where('id', intval($val['id']))
                            ->update([
                                'order_statuses_id' => $val['status'],
                                'pickup_at' => date('Y-m-d H:i:s')
                            ]);
                    } elseif ($val['status'] == 6 && $val['method'] == 4) {
                        $query = Order::where('id', intval($val['id']))
                            ->update([
                                'order_statuses_id' => $val['status'],
                                'pickup_at' => date('Y-m-d H:i:s')
                            ]);
                    }
                } else if ($val['cancel'] == 'delivery') {
                    if ($val['status'] == 6 && $val['method'] == 1) {
                        $getAmount = DB::table('order_details')->where('orders_id', $val['id'])->select('price', 'delivery_fee')->get();
                        $order = DB::table('orders')->join('delivery_addresses', 'delivery_addresses.id', 'orders.delivery_address_id')->where('orders.id', $val['id'])->select('driver_id_deliver', 'no_order', 'delivery_addresses.district')->get();
                        $wallet_id = DB::select('SELECT id from wallet where user_id =' . intval($order[0]->driver_id_deliver) . ' AND CAST(created_at as date) = CURRENT_DATE AND status = 0 OR user_id =' . intval($order[0]->driver_id_deliver) . ' AND CAST(created_at as date) < CURRENT_DATE AND status = 0');
                        $debit = DB::table('wallet_transaction')
                            ->insert([
                                'wallet_id' => $wallet_id[0]->id,
                                'type' => 'debit',
                                'description' => 'Pengembalian pembayaran barang (#' . $order[0]->no_order . ')',
                                'amount' => -$getAmount[0]->price
                            ]);
                        $query = Order::where('id', intval($val['id']))
                            ->update([
                                'order_statuses_id' => $val['status'],
                                'delivered_at' => date('Y-m-d H:i:s')
                            ]);
                    } elseif ($val['status'] == 6 && $val['method'] == 2) {
                        $getAmount = DB::table('order_details')->where('orders_id', $val['id'])->select('price', 'delivery_fee')->get();
                        $order = DB::table('orders')->join('delivery_addresses', 'delivery_addresses.id', 'orders.delivery_address_id')->where('orders.id', $val['id'])->select('driver_id_deliver', 'no_order', 'delivery_addresses.district')->get();
                        $wallet_id = DB::select('SELECT id from wallet where user_id =' . intval($order[0]->driver_id_deliver) . ' AND CAST(created_at as date) = CURRENT_DATE AND status = 0 OR user_id =' . intval($order[0]->driver_id_deliver) . ' AND CAST(created_at as date) < CURRENT_DATE AND status = 0');
                        $debit = DB::table('wallet_transaction')
                            ->insert([
                                'wallet_id' => $wallet_id[0]->id,
                                'type' => 'debit',
                                'description' => 'Pengembalian pembayaran barang (#' . $order[0]->no_order . ')',
                                'amount' => -$getAmount[0]->price
                            ]);
                        $debit2 = DB::table('wallet_transaction')
                            ->insert([
                                'wallet_id' => $wallet_id[0]->id,
                                'type' => 'debit',
                                'description' => 'Pengembalian ongkir(#' . $order[0]->no_order . ')',
                                'amount' => -$getAmount[0]->delivery_fee
                            ]);
                        $query = Order::where('id', intval($val['id']))
                            ->update([
                                'order_statuses_id' => $val['status'],
                                'delivered_at' => date('Y-m-d H:i:s')
                            ]);
                    } elseif ($val['status'] == 6 && $val['method'] == 3) {
                        $getAmount = DB::table('order_details')->where('orders_id', $val['id'])->select('price', 'delivery_fee')->get();
                        $order = DB::table('orders')->join('delivery_addresses', 'delivery_addresses.id', 'orders.delivery_address_id')->where('orders.id', $val['id'])->select('driver_id_deliver', 'no_order', 'delivery_addresses.district')->get();
                        $wallet_id = DB::select('SELECT id from wallet where user_id =' . intval($order[0]->driver_id_deliver) . ' AND CAST(created_at as date) = CURRENT_DATE AND status = 0 OR user_id =' . intval($order[0]->driver_id_deliver) . ' AND CAST(created_at as date) < CURRENT_DATE AND status = 0');
                        $query = Order::where('id', intval($val['id']))
                            ->update([
                                'order_statuses_id' => $val['status'],
                                'delivered_at' => date('Y-m-d H:i:s')
                            ]);
                    } elseif ($val['status'] == 6 && $val['method'] == 4) {
                        $getAmount = DB::table('order_details')->where('orders_id', $val['id'])->select('price', 'delivery_fee')->get();
                        $order = DB::table('orders')->join('delivery_addresses', 'delivery_addresses.id', 'orders.delivery_address_id')->where('orders.id', $val['id'])->select('driver_id_deliver', 'no_order', 'delivery_addresses.district')->get();
                        $wallet_id = DB::select('SELECT id from wallet where user_id =' . intval($order[0]->driver_id_deliver) . ' AND CAST(created_at as date) = CURRENT_DATE AND status = 0 OR user_id =' . intval($order[0]->driver_id_deliver) . ' AND CAST(created_at as date) < CURRENT_DATE AND status = 0');
                        $debit = DB::table('wallet_transaction')
                            ->insert([
                                'wallet_id' => $wallet_id[0]->id,
                                'type' => 'debit',
                                'description' => 'Pengembalian ongkir(#' . $order[0]->no_order . ')',
                                'amount' => -$getAmount[0]->delivery_fee
                            ]);
                        $query = Order::where('id', intval($val['id']))
                            ->update([
                                'order_statuses_id' => $val['status'],
                                'delivered_at' => date('Y-m-d H:i:s')
                            ]);
                    }
                } else {
                    $query = Order::where('id', intval($val['id']))
                        ->update([
                            'order_statuses_id' => $val['status'],
                        ]);
                }
                if ($query) {
                    $response = [
                        'status' => true,
                        'msg'    => 'data successfully saved'
                    ];
                } else {
                    $response = [
                        'status' => false,
                        'msg'    => 'Sorry, There is something Wrong!'
                    ];
                }
            }
            //Retur
            elseif ($val['status'] == 7) {
                DB::table('return')->insert(['id_orders' => intval($val['id'])]);
                $query = Order::where('id', intval($val['id']))
                    ->update([
                        'order_statuses_id' => $val['status'],
                    ]);
                if ($query) {
                    $response = [
                        'status' => true,
                        'msg'    => 'data successfully saved'
                    ];
                } else {
                    $response = [
                        'status' => false,
                        'msg'    => 'Sorry, There is something Wrong!'
                    ];
                }
            }
            //Pengiriman Ulang
            elseif ($val['status'] == 8) {
                $query = Order::where('id', intval($val['id']))
                    ->update([
                        'order_statuses_id' => $val['status'],
                    ]);

                if ($query) {
                    $response = [
                        'status' => true,
                        'msg'    => 'data successfully saved'
                    ];
                } else {
                    $response = [
                        'status' => false,
                        'msg'    => 'Sorry, There is something Wrong!'
                    ];
                }
            }
        }
        return response()->json($response);
    }
    public function printBarcode(Request $request)
    {
        $req = $request->all();
        $collection = new Collection([]);
        foreach ($req['datas'] as $key => $data) {
            $response[$key] = $data['id'];
            $response[$key] = $data['no_order'];
            $collection->push($this->RegulerByNoOrder($data['id']));
        }

        return view('layouts.page_templates.print_barcode', ['dataOrder' => $collection]);
    }
    public function checkout_barcode(Request $request)
    {
        $req = $request->all();
        $response = [];
        $collections = new Collection([]);

        // return response()->json($req['datas']);
        foreach ($req['datas'] as $key => $data) {
            $response[$key] = $data['id'];
            // $response[$key] = $data['no_order'];
            $collections->push($this->RegulerByNoOrder($data['id']));
        }
        // dd($collections);
        $view = view("layouts.page_templates.view_barcode", ['dataOrder' => $collections])->render();

        return response()->json(['html' => $view]);
    }
    public function printExcelReguler()
    {
        $mytime = Carbon::now();

        return Excel::download(new DataOrder('1'), 'DataOrder-' . $mytime->toDateTimeString() . ' - Reguler.xls');
    }
    public function printExcelExpress()
    {
        $mytime = Carbon::now();
        return Excel::download(new DataOrder('2'), 'DataOrder-' . $mytime->toDateTimeString() . ' - Express.xls');
    }
}
