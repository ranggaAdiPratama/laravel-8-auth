<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileRequest;
use App\Http\Requests\PasswordRequest;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    /**
     * Show the form for editing the profile.
     *
     * @return \Illuminate\View\View
     */
    public function edit()
    {
        return view('profile.edit');
    }

    /**
     * Update the profile
     *
     * @param  \App\Http\Requests\ProfileRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(ProfileRequest $request)
    {
        auth()->user()->update($request->all());

        return back()->withStatus(__('Profile successfully updated.'));
    }

    /**
     * Change the password
     *
     * @param  \App\Http\Requests\PasswordRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function password(PasswordRequest $request)
    {
        auth()->user()->update(['password' => Hash::make($request->get('password'))]);

        return back()->withStatusPassword(__('Password successfully updated.'));
    }
    public function changeStatus (Request $request) 
    {
        $req = $request->all();
        // dd($req);
        for ($i=0; $i < count($req['datas']); $i++) { 
            
            $create = DB::table('users')->where('id', $req['datas'][$i])->update(['online' => $req['valueStatus']]);
            
           if ($create) {
              $response = [
                'status' => true,
                'msg'    => 'data successfully saved'
              ];
           }else{
              $response = [
                'status' => false,
                'msg'    => 'data successfully saved'
              ];
           }
           
            
        }
        return response()->json($response);
      
    }
}
