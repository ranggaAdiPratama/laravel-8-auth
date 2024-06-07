<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use DataTables;

class WalletDriverController extends Controller
{
    public function index($slug = null)
    {

        return view('driver/wallet', ['slug' => $slug]);
    }

    public function allWalletDisplay(Request $request)
    {
        $id = $request->get('type');
        if ($request->ajax()) {
            if ($id === 'express') {
                if (!empty($request->get('dates'))) {
                    if (!empty($request->get('status'))) {
                        $allRegulers = $this->driverWalletExp($request->get('dates'), $request->get('status'));
                    } else {
                        $allRegulers = $this->driverWalletExp($request->get('dates'));
                    }
                } else {
                    if (!empty($request->get('status'))) {
                        $allRegulers = $this->driverWalletExp($request->get('status'));
                    } else {
                        $allRegulers = $this->driverWalletExp();
                    }
                }
            } else if ($id === 'reguler') {
                if (!empty($request->get('dates'))) {
                    if (!empty($request->get('status'))) {
                        $allRegulers = $this->driverWallet($request->get('dates'), $request->get('status'));
                    } else {
                        $allRegulers = $this->driverWallet($request->get('dates'));
                    }
                } else {
                    if (!empty($request->get('status'))) {
                        $allRegulers = $this->driverWallet($request->get('status'));
                    } else {
                        $allRegulers = $this->driverWallet();
                    }
                }
            }
            // 
            return Datatables::of($allRegulers)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '<button class="btn btn-link btn-info btn-just-icon btn-tooltip detail_saldo" rel="tooltip" title="" data-id = "' . $row['wallet_id'] . '" data-original-title="Detail Wallet"><i class="material-icons">visibility</i></button>';
                    $btn = $btn . '<button class="btn btn-link btn-rose btn-just-icon add_saldo" id="add_saldo" rel="tooltip" data-id = "' . $row['wallet_id'] . '" data-original-title="Add Saldo"><i class="material-icons" >add_box</i></button>';
                    $btn = $btn . '<button  class="btn btn-link btn-success btn-just-icon btn-tooltip setor" rel="tooltip" data-id = "' . $row['wallet_id'] . '" title="" data-original-title="Setor"><i class="material-icons" >payments</i></button >';


                    return $btn;
                })
                ->addColumn('statuses', function ($row) {
                    // $btn = '<a href="/district/' . $row['id']. '" data-id = "'.$row['id'].'" class="btn btn-link btn-info village_list"><i class="material-icons">location_on</i> View List</a>';
                    if (intval($row['status']) == 0) {
                        $status = '<span role="button" class="badge badge-pill badge-danger statuted" data-id="2"><small>Belum Setor</small></span>';
                    } else {
                        $status = '<span  role="button" class="badge badge-pill badge-success statuted" data-id="2"><small>Sudah Setor</small></span>';
                    }


                    return $status;
                })
                ->addColumn('balance', function ($row) {
                    $balance = number_format($row['ending_balance'], 0, ',', '.');


                    return $balance;
                })
                ->rawColumns(['balance', 'statuses', 'action'])
                ->make(true);
            // return DataTables::queryBuilder($allRegulers)->toJson();
        }
    }

    public function driverWallet()
    {
        $getData = DB::table('driver_wallet')->get();
        $data = array();
        if (!empty($getData)) {
            foreach ($getData as $val) {
                $date = date_create($val->wallet_date);
                if (intval($val->amount) !== 0) {
                    $amount = intval($val->amount);
                } else {
                    $amount = 0;
                }
                $arr = array(
                    'wallet_id' => intval($val->id_wallet),
                    'driver_name' => $val->name,
                    'begin_balance' => intval($val->begin_balance),
                    'status' => intval($val->status),
                    'wallet_date' => date_format($date, 'Y-m-d'),
                    'amount' => $amount,
                    'ending_balance' => $amount + $val->begin_balance
                );
                array_push($data, $arr);
            }
            // return response()->json(['data' => $data]);
        } else {
            return $data = [];
        }
        return $data;

        // return response()->json('Data Not Found', 204);
    }

    public function driverWalletExp()
    {
        $getData = DB::table('driver_wallet_exp')->get();
        $data = array();
        if (!empty($getData)) {
            foreach ($getData as $val) {
                $date = date_create($val->wallet_date);
                if (date_format(date_create($val->wallet_date), 'd-M-Y') == date('d-M-Y') && date_format(date_create($val->wallet_trans_date), 'd-M-Y') == date('d-M-Y')) {
                    $amount = intval($val->amount);
                } else {
                    $amount = 0;
                }
                $arr = array(
                    'wallet_id' => intval($val->id_wallet),
                    'driver_name' => $val->name,
                    'begin_balance' => intval($val->begin_balance),
                    'status' => intval($val->status),
                    'wallet_date' => date_format($date, 'Y-m-d'),
                    'amount' => $amount,
                    'ending_balance' => $amount + $val->begin_balance
                );

                array_push($data, $arr);
            }
            // return response()->json(['data' => $data]);
        } else {
            return $data = [];
        }
        return $data;

        // return response()->json('Data Not Found', 204);
    }

    //Admin Panel
    public function driverWalletDetail($id)
    {
        //Cek Saldo Awal
        $begin_balance_check = DB::select('SELECT begin_balance FROM wallet where CAST(update_at AS DATE) = CURRENT_DATE AND id=' . $id . ' OR CAST(update_at AS DATE) < CURRENT_DATE AND id=' . $id);
        // dd($begin_balance_check);
        $begin_balance = $begin_balance_check;
        $getData = DB::table('driver_wallet_detail')
            ->where('id', $id)
            ->get();
        $data = array();
        $debit = [];
        $credit = [];
        $data_amount = array();
        if (!empty($getData)) {
            $ending_balance = [];
            foreach ($getData as $val) {
                $date = date_create($val->created_at);
                if ($val->type == 'debit') {
                    array_push($debit, $val->amount);
                } else {
                    array_push($credit, $val->amount);
                }
                $amount = intval($val->amount);
                array_push($data_amount, $amount);
                $arr = array(
                    // 'driver_id' => $val->id,
                    'date' => date_format($date, 'd-M-Y'),
                    'description' => $val->description,
                    'type' => $val->type,
                    'amount' => intval($val->amount),

                );
                $end = $begin_balance[0]->begin_balance + $val->amount;
                array_replace(array($ending_balance), array($end));
                array_push($data, $arr);
            }

            // return(array_sum($data_amount));
            return response()->json([
                'status'   => true,
                'begin_balance' => intval($begin_balance[0]->begin_balance),
                'data' => $data,
                'debit' => array_sum($debit),
                'credit' => array_sum($credit),
                'ending_balance' => $begin_balance[0]->begin_balance + array_sum($data_amount)
            ]);
        }
        return response()->json([
            'status' => false
        ]);
    }
    public function addSaldo(Request $request)
    {
        $id = $request->input('id');
        $amount = $request->input('amount');

        date_default_timezone_set('Asia/Makassar');
        // $credit = DB::update('update wallet set begin_balance = '.intval($new_beg_bal).',update_at = "'.date("Y-m-d H:i:s").'" WHERE id = '.intval($id).' AND CAST(created_at as date)= CURRENT_DATE');
        $credit = DB::table('wallet_transaction')
            ->insert([
                'wallet_id' => $id,
                'type' => 'credit',
                'description' => "Top Up",
                'amount' => $amount
            ]);
        if ($credit == 1) {
            return response()->json([
                'status' => true
            ]);
        } else {
            return response()->json([
                'status' => false
            ]);
        }
    }

    public function pullBalance(Request $request)
    {
        $id = $request->input('id');
        $update = DB::table('wallet')->where('id',$id)->update(['status'=> 1]);

        if($update > 0 ){
            return response()->json([
                'status' => true
            ]);
        }else{
            return response()->json([
                'status' => true
            ]);
        }
       
    }
}
