<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use DataTables;
use Illuminate\Support\Collection;
class DriverController extends Controller
{
    public function index($slug)
    {  
        
        $special_city = DB::table('city')->join('service_area', 'city.id', 'service_area.city_id')->orderBy('nama')->get();
        return view('driver.index', ['slug' => $slug, "city" => $special_city]);
    }
    public function allDriverDisplay($id,Request $request)
    {
        
        if ($request->ajax()) {
            if ($id === 'express') {
                if (!empty($request->get('dates'))) {
                    if (!empty($request->get('status'))) {
                        $allRegulers = $this->driverListExp($request->get('dates'), $request->get('status'));
                    } else {
                        $allRegulers = $this->driverListExp($request->get('dates'));
                    }
                } else {
                    if (!empty($request->get('status'))) {
                        $allRegulers = $this->driverListExp($request->get('status'));
                    } else {
                        $allRegulers = $this->driverListExp();
                    }
                }
            }else if($id === 'reguler'){
                if (!empty($request->get('dates'))) {
                    if (!empty($request->get('status'))) {
                        $allRegulers = $this->driverList($request->get('dates'), $request->get('status'));
                    } else {
                        $allRegulers = $this->driverList($request->get('dates'));
                    }
                } else {
                    if (!empty($request->get('status'))) {
                        $allRegulers = $this->driverList($request->get('status'));
                    } else {
                        $allRegulers = $this->driverList();
                    }
                }
            }
           
            // 
            return Datatables::of($allRegulers)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '<a href="/order-detail/' . $row['id']. '" class="btn btn-link btn-info btn-just-icon like"><i class="material-icons">visibility</i></a>';
                    $btn = $btn . '<a href="#" class="btn btn-link btn-danger btn-just-icon remove"><i class="material-icons">close</i></a>';

                    return $btn;
                })
                ->addColumn('district', function ($row) {
                    // $btn = '<a href="/district/' . $row['id']. '" data-id = "'.$row['id'].'" class="btn btn-link btn-info village_list"><i class="material-icons">location_on</i> View List</a>';
                    
                   $dialog =  '<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">';
                   $dialog = $dialog.'<div class="panel panel-default">';
                   $dialog = $dialog.'<div class="panel-heading" role="tab" id="heading' . $row['id']. '">';
                   $dialog =  $dialog.'<h6 class="panel-title">';
                   $dialog = $dialog.'<a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse' . $row['id']. '" aria-expanded="true" aria-controls="collapse">';
                   $dialog = $dialog.'Click To See Detail Village Placement</a> </h6>';                                                          
                   $dialog = $dialog.'</div> <div id="collapse' . $row['id']. '" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading' . $row['id']. '">';
                   $dialog = $dialog.'<div class="panel-body">';
                   foreach ($row['village_placement'] as $value) {
                   $dialog = $dialog.'<span class="badge badge-pill badge-info"><small>'.$value.'</small></span>';
                   };
                   $dialog = $dialog.'</div>';
                   $dialog = $dialog.'</div>';
                   $dialog = $dialog.'</div>';
                   $dialog = $dialog.'</div>';
                
                    return $dialog;
                })
                ->addColumn('placement', function ($row) {
                    // $btn = '<a href="/district/' . $row['id']. '" data-id = "'.$row['id'].'" class="btn btn-link btn-info village_list"><i class="material-icons">location_on</i> View List</a>';
                   $dialog ='';
                   foreach ($row['district_placement'] as $value) {
                   $dialog = $dialog.'<span class="badge badge-pill badge-rose"><small>'.$value.'</small></span><br/>';
                   };
                  
                    return $dialog;
                })
                ->addColumn('statuses', function ($row) {
                    // $btn = '<a href="/district/' . $row['id']. '" data-id = "'.$row['id'].'" class="btn btn-link btn-info village_list"><i class="material-icons">location_on</i> View List</a>';
                   if (intval($row['online']) == 0) {
                    $status ='<span role="button" class="badge badge-pill badge-danger statuted" data-id="2"><small>Offline</small></span>';
                   }else{
                    $status ='<span  role="button" class="badge badge-pill badge-success statuted" data-id="2"><small>Online</small></span>';

                   }
                  
                  
                    return $status;
                })
                ->rawColumns(['statuses','placement','district','action'])
                ->make(true);
            // return DataTables::queryBuilder($allRegulers)->toJson();
        }
    }
    
    public function driverList($status_order = null)
    {
        $getDriver = DB::table('driver_list')->get();
        $special_city = DB::table('city')->join('service_area', 'city.id', 'service_area.city_id')->orderBy('nama')->get();
        $district = DB::table('district')->get();
        $village = DB::table('village')->get();
        $driver = [];
        if (!empty($getDriver)) {
            foreach ($getDriver as $val) {
                // village
                $d = str_replace(str_split('\\[]"'), '', $val->village_placement_id);
                $e = explode(',', $d);
                $village_placement = array();
                if ($val->village_placement_id !== '[]' && is_array($e) || $val->village_placement_id !== null && is_array($e)) {
                    foreach ($e as $v) {
                        $get = DB::table('village')->where('id', $v)->first('nama');
                        if (!empty($get)) {
                            array_push($village_placement, $get->nama);
                        }
                    }
                }
                $f = str_replace(str_split('\\[]"'), '', $val->district_placement_id);
                $g = explode(',', $f);
                $district_placement = array();
                if ($val->district_placement_id !== '[]' && is_array($g) || $val->district_placement_id !== null && is_array($g)) {
                    foreach ($g as $i) {
                        $name = DB::table('district')->where('id', $i)->first('nama');
                        if (!empty($name)) {
                            array_push($district_placement, $name->nama);
                        }
                    }
                }
                $arr = array(
                    'id' => $val->id,
                    'name' => $val->name,
                    'email' => $val->email,
                    'total_order' => $val->count,
                    'category' => $val->category,
                    'district_placement' => $district_placement,
                    'village_placement' => $village_placement,
                    'driver_district' => $val->driver_district,
                    'driver_village' => $val->driver_village,
                    'phone' => $val->phone,
                    'photo' => $val->photo,
                    'online' => $val->online
                );
                array_push($driver, $arr);
            }
        }else {
            return $driver = [];
        }
        return $driver;
        // return response()->json([

        //     'driver' => $driver,
        //     'district' => $district,
        //     'village' => $village,
        //     'city' => $special_city

        // ], 200);
    }
    public function driverListExp($status_order = null)
    {
        $getDriver = DB::table('driver_list_exp')->get();
        $district = DB::table('districts')->get();
        $village = DB::table('villages')->get();
        $driver =[];
        if (!empty($getDriver)) {
            foreach ($getDriver as $val) {
                // village
                $d = str_replace(str_split('\\[]"'), '', $val->village_placement_id);
                $e = explode(',', $d);
                $village_placement = array();
                if ($val->village_placement_id !== '[]' && is_array($e) || $val->village_placement_id !== null && is_array($e)) {
                    foreach ($e as $v) {
                        $get = DB::table('village')->where('id', $v)->first('nama');
                        if (!empty($get)) {
                            array_push($village_placement, $get->nama);
                        }
                    }
                }
                $f = str_replace(str_split('\\[]"'), '', $val->district_placement_id);
                $g = explode(',', $f);
                $district_placement = array();
                if ($val->district_placement_id !== '[]' && is_array($g) || $val->district_placement_id !== null && is_array($g)) {
                    foreach ($g as $i) {
                        $name = DB::table('district')->where('id', $i)->first('nama');
                        if (!empty($name)) {
                            array_push($district_placement, $name->nama);
                        }
                    }
                }
                $arr = array(
                    'id' => $val->id,
                    'name' => $val->name,
                    'email' => $val->email,
                    'total_order' => $val->count,
                    'category' => $val->category,
                    'district_placement' => $district_placement,
                    'village_placement' => $village_placement,
                    'driver_district' => $val->driver_district,
                    'driver_village' => $val->driver_village,
                    'phone' => $val->phone,
                    'photo' => $val->photo,
                    'online' => $val->online
                );
                array_push($driver, $arr);
            }
        }else {
            return $driver = [];
        }
        return $driver;

        // return response()->json([
        
        // 'driver' => $driver ,
        // 'district' =>$district,
        // 'village' =>$village,

        // ], 200);
    }

    public function setSaldo(Request $request)
        {
            $req = $request->all();
            date_default_timezone_set('Asia/Makassar');
            $price = $request->input('begin_balance');
            $price = (int)str_replace('.', '',  $price);
            // dd($req['datas'],$price);
            
            // foreach ($req['datas'] as $index){
            for ($i=0; $i < count($req['datas']); $i++) { 
                # code...
                $check_saldo = DB::table('driver_wallet')->where('user_id',intval($req['datas'][$i]))->get();
                $id[] = $check_saldo;
                if(count($check_saldo) > 0){
                    $update = DB::update('update wallet set begin_balance = '.$price.',update_at = "'.date("Y-m-d H:i:s").'" WHERE user_id = '.intval($req['datas'][$i]).' AND CAST(created_at as date)= CURRENT_DATE');
                    if (! $update) {
                        $create = DB::table('wallet')->insert(['begin_balance' => $price,'update_at' => date('Y-m-d H:i:s'),'user_id' => intval($req['datas'][$i])]);
                    }
                }else{
                    $create = DB::table('wallet')->insert(['begin_balance' => $price,'update_at' => date('Y-m-d H:i:s'),'user_id' => intval($req['datas'][$i])]);
                }
            }
            //    dd(date("Y-m-d H:i:s"),$update,count($check_saldo)); 
                
            // }
            
            // if ($update) {
                $response = [
                    'status' => true,
                    'msg'    => 'data successfully saved'
                ];
            // } else {
            //     $response = [
            //         'status' => false,
            //         'msg'    => 'Sorry, There is something Wrong!'
            //     ];
            // }
            return response()->json($response);
            
        }
        public function setPlacement(Request $request){
            $req = $request->all();
            // return response()->json($req['datas']);
            foreach($req['datas'] as $key => $val){
                if(isset($val['village'])){
                    $save =   DB::table('drivers')->where('user_id',$val['id'])
                        ->update([
                        'district_placementt' => $val['dictrict'],
                        'village_placement' => $val['village'],
                        ]);
                }else{
                        $save =   DB::table('drivers')->where('user_id',$val['id'])
                        ->update([
                        'district_placementt' => $val['dictrict'],
                        ]);
                }
            }
            if ($save) {
                $response = [
                    'status' => true,
                    'msg'    => 'data successfully saved'
                ];
            }else{
                $response = [
                    'status' => false,
                    'msg'    => 'Sorry, There is something Wrong!'
                ];
            }
            return response()->json($response);
        }
}
