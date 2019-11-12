<?php

namespace App\Http\Controllers\Cost;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Members;
use App\Hospital;
use App\Bank;
use App\PaymentCause;
use App\PaymentCharge;
use App\PaymentTag;
use DB;

class PaymentController extends Controller
{
    public function charges($id,Request $request)
    {
        $response = [
            'error_code' => 0,
            'error_msg' => 'success',
            'failed' => [],
            'cause_name' => '',
            'cause_status'=>'',
            'sum' => [],
            'successful' => [],
        ];
        DB::connection()->enableQueryLog();
        $sort  = $request->input('sort','id');
        $order = $request->input('order','desc');
        $charge = PaymentCharge::orderBy($sort, $order) 
                                ->where('payment_charges.is_delete',0)
                                ->when($id == '0',function($query) use( $id){
                                    $query->where('payment_charges.status','3');
                                })
                                ->when($id != '0',function($query) use( $id){
                                    $query->where('cause_id', $id);
                                })
                                ->select('payment_charges.id','payment_charges.updated_at','members.name','members.sex','members.company','members.IDcard','members.bank_id','members.mobile','banks.bank_num','banks.opening_bank','payment_charges.cost','payment_charges.remarks','payment_charges.status','hospitals.hospital_name')
                                ->leftjoin('members','payment_charges.account_id','=','members.id')
                                ->leftjoin('banks','payment_charges.bank_id','=','banks.id')
                                ->leftjoin('hospitals','members.company','=','hospitals.id')
                                ->get();
                                // echo "";print_r(DB::getQueryLog());die();
        $sumc = PaymentCharge::where('is_delete',0)
                                ->when($id == '0',function($query) use( $id){
                                    $query->where('payment_charges.status','3');
                                })
                                ->when($id != '0',function($query) use( $id){
                                    $query->where('cause_id', $id);
                                })
                                ->sum('cost');
        $sump = PaymentCharge::where('is_delete',0)
                                ->when($id == '0',function($query) use( $id){
                                    $query->where('payment_charges.status','3');
                                })
                                ->when($id != '0',function($query) use( $id){
                                    $query->where('cause_id', $id);
                                })
                                ->count();
        foreach($charge as $k => $v){
            if($v['sex'] == 1){
                    $charge[$k]['sexs'] = '男';
            }else{
                    $charge[$k]['sexs'] = '女';
            }
            if($v['status'] == 0){
                $charge[$k]['m_status'] = '' ;
            }elseif($v['status'] == 1){
                $charge[$k]['m_status'] = '<span style="color:green;">已支付</span>'.'<br>'.$v['updated_at'] ;
            }elseif($v['status'] == 2){
                $charge[$k]['m_status'] = '<span style="color:red;">已退回</span>'.'<br>'.$v['updated_at'] ;
            }elseif($v['status'] == 3){
                $charge[$k]['m_status'] = '已更新'.'<br>'.$v['updated_at'] ;
            }elseif($v['status'] == 4){
                $charge[$k]['m_status'] = '已提交支付'.'<br>'.$v['updated_at'] ;
            }
        }
        $charge = $charge->toArray();
        $cause = PaymentCause::orderBy($sort, $order)
                            ->select("payment_causes.*",'payment_tags.tag')
                            ->where('payment_causes.is_delete',0)
                            ->where('payment_causes.id',$id)
                            ->leftjoin('payment_tags','payment_causes.cause_type','=','payment_tags.id')
                            ->first();
        
        if($cause['final_status'] == 1){
            $cause['finals_status'] = '收集中' ;
        }elseif($cause['final_status'] == 2){
            $cause['finals_status'] = '已收集' ;
        }elseif($cause['final_status'] == 3){
            $cause['finals_status'] = '已提交支付' ;
        }elseif($cause['final_status'] == 4){
            // $cause['cause_name'] = '<span style="color:green;">'.$cause['cause_name'].'</span>';
            $cause['finals_status'] = '<span style="color:green;">已支付</span>' ;
        }elseif($cause['final_status'] == 5){
            // $cause['cause_name'] = '<span style="color:red;">'.$cause['cause_name'].'</span>';
            $cause['finals_status'] = '<span style="color:red;">部分支付</span>' ;
        }elseif($cause['final_status'] == 6){
            $cause['finals_status'] = '已提交财务' ;
        }
        $response['successful'] = $charge;
        $response['cause_name'] = $cause;
        $response['cause_status'] = $cause['final_status'];
        $response['sum']['cost'] = $sumc;
        $response['sum']['people'] = $sump;
        return $response;
    }

    public function add($id,Request $request)
    {
        $response = [
            'error_code' => 0,
            'error_msg' => 'success',
            'failed' => [],
            'successful' => [],
        ];
        
        // if(!$request->input('memberID')){
        //     $response["error_msg"] = '收款人不能为空!';
        //     $response["successful"] = false;
        //     return $response;
        // }
        // if(!$request->input('newbank')){
        //     $response["error_msg"] = '银行账户不能为空!';
        //     $response["successful"] = false;
        //     return $response;
        // }
        // if(!$request->input('cost')){
        //     $response["error_msg"] = '金额不能为空!';
        //     $response["successful"] = false;
        //     return $response;
        // }
        // $charge = PaymentCharge::where('cause_id',$id)->where(
        //     function($query) use ($request){
        //         $query->whereIn('account_id',$request['member']);
        // })->get();
        // return $charge;
        $memberid = $request['member'];
        foreach($memberid as $k => $v){
            $charge = PaymentCharge::where('cause_id',$id)->where('account_id',$v)->get()->toArray();
            if($charge){
                unset($memberid[$k]);
            }
        }
        if(!$memberid){
            $response["error_msg"] = '收款账户都已添加!';
            $response["successful"] = false;
            return $response;
        }
        $member = Members::whereIn('id',$memberid)->get();
        $data = [];
        foreach($member as $k => $v){
            $data[$k]['cause_id'] = $id;
            $data[$k]['account_id'] = $v['id'];
            $data[$k]['bank_id'] = $v['bank_id'];
            $data[$k]['cost'] = $request->input('cost',0);
            $data[$k]['status'] = 0;
            $data[$k]['remarks'] = '';
            $data[$k]['created_at'] = date("Y-m-d H:i:s",time()+8*60*60);
            $data[$k]['updated_at'] = date("Y-m-d H:i:s",time()+8*60*60);
        }
        $res = PaymentCharge::insert($data);
        $response["successful"][] = $res;
        return $response;
    }

    public function update($id,Request $request)
    {
        $response = [
            'error_code' => 0,
            'error_msg' => 'success',
            'failed' => [],
            'successful' => [],
        ];
        $remarks = $request->input("remarks");
        if(!$remarks){
            return [
                "success" => true,
            ];
        }
        $res = PaymentCharge::find($id);

        $cause = PaymentCause::find($res['cause_id']);
        $res->update([
            "remarks" => $remarks,
            'status' => 2,
            "updated_at" => date('Y-m-d H:i:s',time()+8*60*60),
        ]);
        $cause->update([
            "final_status" => 5,
            "updated_at" => date('Y-m-d H:i:s',time()+8*60*60),
        ]);
        $response['successful'] = $res;
        return $response;
    }

    public function cost($id,Request $request)
    {
        $response = [
            'error_code' => 0,
            'error_msg' => 'success',
            'failed' => [],
            'successful' => [],
        ];
        $cost = $request->input("cost");
        if(!$cost){
            return [
                "success" => true,
            ];
        }
        $res = PaymentCharge::find($id);
        $res->update([
            "cost" => $cost,
            "updated_at" => date('Y-m-d H:i:s',time()+8*60*60),
        ]);
        $response['successful'] = $res;
        return $response;
    }

    public function delete($id)
    {
        $res = PaymentCharge::find($id);
        $res->update([
            'is_delete' => 1,
        ]);
        return [
            'successful' => true,
            'date' => $res
        ];
    }   

    public function msearch($name,Request $request)
    {
        $response = [
            'error_code' => 0,
            'error_msg' => 'success',
            'failed' => [],
            'successful' => [],
        ];
        
        $sort  = $request->input('sort','id');
        $order = $request->input('order','asc');
        $member = Members::orderBy($sort, $order) 
                         ->select('members.*','banks.bank_num','banks.opening_bank','hospitals.hospital_name')
                         ->where('members.is_delete',0)
                         ->when($name != '0',function($query) use( $name){
                            $query->where('members.name', $name)->orwhere('members.name','like','%'.$name.'%')->orwhere('members.company',$name);
                            })
                         ->leftjoin('banks','members.bank_id','=','banks.id')
                         ->leftjoin('hospitals','members.company','=','hospitals.id')
                         ->paginate();
        foreach($member as $k => $v){
        //    $bank_id = explode(',',$v['bank_id']);
        //    $bankinfo = Bank::whereIn('id',$bank_id)->get();
           if($v['sex'] == 1){
                $member[$k]['sexs'] = '男';
           }else{
                $member[$k]['sexs'] = '女';
           }
        //    if(count($bankinfo) > 1){
        //         foreach($bankinfo as $key => $val){
        //             $banknum[$key] = $val['bank_num'];
        //             $openbank[$key] = $val['opening_bank'];
        //         }
        //         $member[$k]['bank_num'] = implode(',',$banknum);
        //         $member[$k]['opening_bank'] = implode(',',$openbank);
        //    }else{
        //         $member[$k]['bank_num'] = $bankinfo[0]['bank_num'];
        //         $member[$k]['opening_bank'] = $bankinfo[0]['opening_bank'];
        //    }
        }
        return responder()->success($member);
    }

    public function causesearchs($name,Request $request)
    {
        // DB::connection()->enableQueryLog();
        $response = [
            'error_code' => 0,
            'error_msg' => 'success',
            'failed' => [],
            'successful' => [],
        ];
        
        $sort  = $request->input('sort','id');
        $order = $request->input('order','asc');
        $res = PaymentCause::orderBy($sort, $order)
                            ->select("payment_causes.*",'payment_tags.tag')
                            
                            ->when($name != '0',function($query) use($name){
                                $query->where('payment_causes.cause_name', $name)->orwhere('payment_causes.cause_name','like','%'.$name.'%');
                            })
                            ->where('payment_causes.is_delete','0')
                            ->leftjoin('payment_tags','payment_causes.cause_type','=','payment_tags.id')
                            ->paginate();
                            // return DB::getQueryLog();
        foreach($res as $k => $v){
            if($v['final_status'] == 1){
                $res[$k]['finals_status'] = '收集中' ;
            }elseif($v['final_status'] == 2){
                $res[$k]['finals_status'] = '已提交' ;
            }elseif($v['final_status'] == 3){
                $res[$k]['finals_status'] = '已申请提交' ;
            }elseif($v['final_status'] == 4){
                $res[$k]['finals_status'] = '<span style="color:green;">已支付</span>' ;
            }elseif($v['final_status'] == 5){
                $res[$k]['finals_status'] = '<span style="color:red;">部分支付</span>' ;
            }elseif($res[$k]['final_status'] == 6){
                $res[$k]['finals_status'] = '已提交财务' ;
            }
        }
        return responder()->success($res);
    }

    public function usersearchscause($name,Request $request)
    {
        // DB::connection()->enableQueryLog();
        $response = [
            'error_code' => 0,
            'error_msg' => 'success',
            'failed' => [],
            'successful' => [],
        ];
        $strlen = mb_strlen($name,'UTF8');
        $member = Members::when($strlen > 17 , function ($query) use ($name){
                                $query->where('IDcard',$name);
                        })
                        ->when($strlen < 17, function ($query) use ($name){
                                $query->where('name','like','%'.$name.'%');
                        })
                        ->first();
        $charges = PaymentCharge::where('account_id',$member['id'])->get();
        $chargeId = [];
        foreach($charges as $k => $v){
            $chargeId[$k] = $v['cause_id'];
        }
        $sort  = $request->input('sort','id');
        $order = $request->input('order','desc');
        $res = PaymentCause::orderBy($sort, $order)
                            ->select("payment_causes.*",'payment_tags.tag')
                            ->whereIn('payment_causes.id',$chargeId)
                            ->where('payment_causes.is_delete','0')
                            ->leftjoin('payment_tags','payment_causes.cause_type','=','payment_tags.id')
                            ->paginate();
        foreach($res as $k => $v){
            if($v['final_status'] == 1){
                $res[$k]['finals_status'] = '收集中' ;
            }elseif($v['final_status'] == 2){
                $res[$k]['finals_status'] = '已提交' ;
            }elseif($v['final_status'] == 3){
                $res[$k]['finals_status'] = '已申请提交' ;
            }elseif($v['final_status'] == 4){
                $res[$k]['finals_status'] = '<span style="color:green;">已支付</span>' ;
            }elseif($v['final_status'] == 5){
                $res[$k]['finals_status'] = '<span style="color:red;">部分支付</span>' ;
            }elseif($res[$k]['final_status'] == 6){
                $res[$k]['finals_status'] = '已提交财务' ;
            }
        }
        return responder()->success($res);
    }

    public function csearch()
    {
        $response = [
            'error_code' => 0,
            'error_msg' => 'success',
            'failed' => [],
            'successful' => [],
        ];
        $company = Hospital::get()->toArray();
        $response['successful'] = $company;
        return $response;
    }

    public function csearchs($id)
    {
        $response = [
            'error_code' => 0,
            'error_msg' => 'success',
            'failed' => [],
            'successful' => [],
        ];
        $member = Members::where('company',$id)
                            ->select('members.*','banks.bank_num')
                            ->where('members.is_delete',0)
                            ->leftjoin('banks','members.bank_id','=','banks.id')
                            ->get()->toArray();
        foreach($member as $k => $v){
            $member[$k]['name_bank'] = $v['name'].' ('.$v['bank_num'].')';
        }
        $response['successful'] = $member;
        return $response;
    }

    public function hsearch($name)
    {
        $response = [
            'error_code' => 0,
            'error_msg' => 'success',
            'failed' => [],
            'successful' => [],
        ];
        if($name == 1){
            $response['error_msg'] = '收款人不能为空';
            $response['successful'] =false;
            return $response;
        }
        $member = Hospital::where('hospital_name',$name)
                            ->where('is_delete',0)
                            ->orWhere('hospital_name','like','%'.$name.'%')
                            ->get()
                            ->toArray();
        return responder()->success($member);
    }
}
