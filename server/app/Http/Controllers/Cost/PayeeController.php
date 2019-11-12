<?php

namespace App\Http\Controllers\cost;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\PaymentCharge;
use App\PaymentCause;
use App\Members;
use App\Bank;
use App\Role;

class PayeeController extends Controller
{
    // public function chargeStatus($id,Request $request)
    // {
    //     $response = [
    //         'error_code' => 0,
    //         'error_msg' => 'success',
    //         'failed' => [],
    //         'successful' => [],
    //     ];
    //     $payee = PaymentCharge::find($id);
    //     $cause = PaymentCause::find($payee['cause_id']);
    //     $payee->update([
    //         'status' => $request['status']
    //     ]);
    //     if($request['status'] == 2){
    //         $cause->update([
    //             'final_status' => 5,
    //             "updated_at" => date('Y-m-d H:i:s'),
    //         ]);
    //     }
    //     if($request['status'] == 1 || $request['status'] == 4){
    //         $status = [];
    //         $payees = PaymentCharge::where('cause_id',$payee['cause_id'])->get();
    //         foreach($payees as $k=>$v){
    //             $status[$k] = $v['status'];
    //         }
    //         if(!in_array(2,$status)){
    //             $cause->update([
    //                 'final_status' => 4,
    //                 "updated_at" => date('Y-m-d H:i:s'),
    //             ]);
    //         }
    //     }
    //     $response['successful'] = true;
    //     return $response;
    // }

    public function chargeStatus($id,Request $request)
    {
        $user = auth('api')->user();
        $role = Role::find($user['role']);
        $response = [
            'error_code' => 0,
            'error_msg' => 'success',
            'failed' => [],
            'successful' => [],
        ];
        $payee = PaymentCharge::find($id);
        $cause = PaymentCause::find($payee['cause_id']);
        
        if($role['role'] == 'finance'){
            $payee->update([
                'status' => 4,
                'remarks'=> '',
                "updated_at" => date('Y-m-d H:i:s',time()+8*60*60),
            ]);
            $status = [];
            $payees = PaymentCharge::where('cause_id',$payee['cause_id'])->get();
            foreach($payees as $k=>$v){
                $status[$k] = $v['status'];
            }
            if(!in_array(2,$status)){
                $cause->update([
                    'final_status' => 3,
                    "updated_at" => date('Y-m-d H:i:s',time()+8*60*60),
                ]);
            }
        }
        if($role['role'] == 'admin'){
            $payee->update([
                'status' => 1,
                "updated_at" => date('Y-m-d H:i:s',time()+8*60*60),
            ]);
            $status = [];
            $payees = PaymentCharge::where('cause_id',$payee['cause_id'])->get();
            foreach($payees as $k=>$v){
                $status[$k] = $v['status'];
            }
            if(!in_array(2,$status) && !in_array(4,$status)){
                $cause->update([
                    'final_status' => 4,
                    'pay_time' => date('Y-m-d H:i:s',time()+8*60*60),
                    "updated_at" => date('Y-m-d H:i:s',time()+8*60*60),
                ]);
            }else{
                $cause->update([
                    'final_status' => 5,
                    "updated_at" => date('Y-m-d H:i:s',time()+8*60*60),
                ]);
            }
        }
        $response['successful'] = true;
        return $response;
    }

    public function changeCharge($id,Request $request)
    {
        // return $request;
        $response = [
            'error_code' => 0,
            'error_msg' => 'success',
            'failed' => [],
            'successful' => [],
        ];
        
        $payee = PaymentCharge::find($id);
        $cause = PaymentCause::find($payee['cause_id']);
        $member = Members::find($payee['account_id']);
        $bank = Bank::find($payee['bank_id']);
        if($request['status'] == 0 || $request['status'] == 1  || $request['status'] == 4){
            $response['error_msg'] = '此账户无需更改';
            $response['successful'] = false;
            return $response;
        }
        $bank->update([
            'bank_num' => $request['bank_num'],
            'opening_bank' => $request['opening_bank']
        ]);
        $payee->update([
            'status' => 3,
            "updated_at" => date('Y-m-d H:i:s',time()+8*60*60),
        ]);
        $member->update([
            'name' => $request['name'],
            'sex' => $request['sex'],
            'mobile' => $request['mobile'],
            'IDcard' => $request['IDcard'],
            "updated_at" => date('Y-m-d H:i:s',time()+8*60*60),
        ]);
        $status = [];
        $payees = PaymentCharge::where('cause_id',$payee['cause_id'])->get();
        foreach($payees as $k=>$v){
            $status[$k] = $v['status'];
        }
        $response['successful'] = $payees;
        return $response;
    }

    public function alreadyUpdate($id,Request $request)
    {
        // $sort  = $request->input('sort','id');
        // $order = $request->input('order','asc');
        // $charge = PaymentCharge::orderBy($sort, $order) 
        //                         ->where('payment_charges.is_delete',0)
        //                         ->where('payment_charges.status','3')
        //                         ->select('payment_charges.id','payment_charges.updated_at','members.name','members.sex','members.company','members.IDcard','members.bank_id','members.mobile','banks.bank_num','banks.opening_bank','payment_charges.cost','payment_charges.remarks','payment_charges.status','hospitals.hospital_name','payment_charges.cause_id')
        //                         ->leftjoin('members','payment_charges.account_id','=','members.id')
        //                         ->leftjoin('banks','payment_charges.bank_id','=','banks.id')
        //                         ->leftjoin('hospitals','members.company','=','hospitals.id')
        //                         ->get();
        $response = [
            'error_code' => 0,
            'error_msg' => 'success',
            'failed' => [],
            'successful' => [],
        ];
        $charge = PaymentCharge::where('payment_charges.is_delete',0)
                                ->when($id == '0',function($query) use ($id){
                                    $query->where('payment_charges.status','3');
                                })
                                ->when($id == '1',function($query) use ($id){
                                    $query->where('payment_charges.status','2');
                                })
                                ->get();
        $causeId = [];
        foreach($charge as $k => $v){
            if(!in_array($v['cause_id'],$causeId)){
                array_push($causeId,$v['cause_id']);
            }
        }
        $charges = [];
        foreach($causeId as $key => $val){
            $causeName = PaymentCause::find($val);
            $charges[$key]['cause_name'] = $causeName['cause_name'];
            $charges[$key]['data'] = PaymentCharge::where('payment_charges.is_delete',0)
                                ->where('cause_id',$val)
                                ->when($id == '0',function($query) use ($id){
                                    $query->where('payment_charges.status','3');
                                })
                                ->when($id == '1',function($query) use ($id){
                                    $query->where('payment_charges.status','2');
                                })
                                ->select('payment_charges.id','payment_charges.updated_at','members.name','members.sex','members.company','members.IDcard','members.bank_id','members.mobile','banks.bank_num','banks.opening_bank','payment_charges.cost','payment_charges.remarks','payment_charges.status','hospitals.hospital_name','payment_charges.cause_id')
                                ->leftjoin('members','payment_charges.account_id','=','members.id')
                                ->leftjoin('banks','payment_charges.bank_id','=','banks.id')
                                ->leftjoin('hospitals','members.company','=','hospitals.id')
                                ->get();
            foreach($charges[$key]['data'] as $keys => $vals){
                if($vals['sex'] == 1){
                    $charges[$key]['data'][$keys]['sexs'] = '男';
                }else{
                        $charges[$key]['data'][$keys]['sexs'] = '女';
                }
                if($vals['status'] == 0){
                    $charges[$key]['data'][$keys]['m_status'] = '' ;
                }elseif($v['status'] == 1){
                    $charges[$key]['data'][$keys]['m_status'] = '<span style="color:green;">已支付</span>'.'<br>'.$vals['updated_at'] ;
                }elseif($v['status'] == 2){
                    $charges[$key]['data'][$keys]['m_status'] = '<span style="color:red;">已退回</span>'.'<br>'.$vals['updated_at'] ;
                }elseif($v['status'] == 3){
                    $charges[$key]['data'][$keys]['m_status'] = '已更新'.'<br>'.$vals['updated_at'] ;
                }elseif($v['status'] == 4){
                    $charges[$key]['data'][$keys]['m_status'] = '已提交支付'.'<br>'.$vals['updated_at'] ;
                }
            }
            $charges[$key]['sum']['cost'] = PaymentCharge::where('is_delete',0)
                                ->when($id == '0',function($query) use ($id){
                                    $query->where('payment_charges.status','3');
                                })
                                ->when($id == '1',function($query) use ($id){
                                    $query->where('payment_charges.status','2');
                                })
                                ->where('cause_id', $val)
                                ->sum('cost');
            $charges[$key]['sum']['people'] = PaymentCharge::where('is_delete',0)
                                ->when($id == '0',function($query) use ($id){
                                    $query->where('payment_charges.status','3');
                                })
                                ->when($id == '1',function($query) use ($id){
                                    $query->where('payment_charges.status','2');
                                })
                                ->where('cause_id', $val)
                                ->count();
        }
        $response['successful'] = $charges;
        return $response;
    }

    public function allstatus($id)
    {
        $causes = PaymentCharge::where('cause_id',$id)->get();
        foreach($causes as $cause){
            $cause->status = 1;
            $cause->updated_at = date('Y-m-d H:i:s',time()+8*60*60);
            $cause->save();
        }
        $cause = PaymentCause::find($id);
        $cause->update([
            'final_status' => 4,
            "updated_at" => date('Y-m-d H:i:s',time()+8*60*60),
            "pay_time" => date('Y-m-d H:i:s',time()+8*60*60),
        ]);
    }
}
