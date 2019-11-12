<?php

namespace App\Http\Controllers\Cost;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Consultation;
use App\ServiceCharge;
use App\PaymentCause;
use App\PaymentTag;
use App\PaymentCharge;
use App\Members;
use App\Bank;

class ServiceFreeController extends Controller
{
    public function consultations(Request $request)
    {
        $response = [
            'error_code' => 0,
            'error_msg' => 'success',
            'failed' => [],
            'successful' => [],
        ];
        $sort  = $request->input('sort','id');
        $order = $request->input('order','desc');
        $res = PaymentCause::orderBy($sort, $order)
                            ->select("payment_causes.*",'payment_tags.tag')
                            ->where('payment_causes.is_delete',0)
                            ->leftjoin('payment_tags','payment_causes.cause_type','=','payment_tags.id')
                            ->paginate();
        foreach($res as $k => $v){
            if($v['final_status'] == 1){
                $res[$k]['finals_status'] = '收集中' ;
            }elseif($v['final_status'] == 2){
                $res[$k]['finals_status'] = '已收集' ;
            }elseif($v['final_status'] == 3){
                $res[$k]['finals_status'] = '已提交支付' ;
            }elseif($v['final_status'] == 4){
                // $res[$k]['cause_name'] = '<span style="color:green;">'.$v['cause_name'].'</span>';
                $res[$k]['finals_status'] = '<span style="color:green;">已支付</span>' ;
            }elseif($v['final_status'] == 5){
                // $res[$k]['cause_name'] = '<span style="color:red;">'.$v['cause_name'].'</span>';
                $res[$k]['finals_status'] = '<span style="color:red;">部分支付</span>' ;
            }elseif($v['final_status'] == 6){
                $res[$k]['finals_status'] = '已提交财务' ;
            }
            $res[$k]['cost'] =  PaymentCharge::where('is_delete',0)->where('cause_id', $v['id'])->sum('cost');
        }
        return responder()->success($res);
    }

    public function addConsultation(Request $request)
    {
        $response = [
            'error_code' => 0,
            'error_msg' => 'success',
            'failed' => [],
            'successful' => [],
        ];
        $date = substr($request['begin_time'],0,10);
        $date = strtotime($date) + 86400;
        $date = date("Y-m-d",$date);
        $res = PaymentCause::insert([
            'cause_name' => $request['cause_name'],
            'cause_type' => $request['cause_type'],
            'begin_time' => $date,
            'pay_time' => '',
            'process_status' => 0,
            'Final_status' => 1,
            "created_at" => date('Y-m-d H:i:s'),
            "updated_at" => date('Y-m-d H:i:s'),
        ]);
        $response['successful'][] = $res;
        return $response;
    }

    public function deleteConsultation($id){
        $response = [
            'error_code' => 0,
            'error_msg' => 'success',
            'failed' => [],
            'successful' => [],
        ];
        $consultation = PaymentCause::find($id);
        $consultation->update([
            'is_delete' => 1
        ]);
        return [
            'success' => true,
            'data' => $consultation
        ];
    }

    public function updateConsultation($id,Request $request)
    {
        $this->validate($request, [
            'cause_name' => 'required|string',
            'cause_type' => 'required|integer'
        ]);
        $consultation_name = $request->input("cause_name");
        $cause_type = $request->input("cause_type");
        $date = substr($request['begin_time'],0,10);
        $date = strtotime($date) + 86400;
        $date = date("Y-m-d",$date);
        if(!$consultation_name || !$cause_type){
            return [
                "success" => true,
            ];
        }
        $consultation = PaymentCause::find($id);
        $consultation->update([
            "cause_name" => $consultation_name,
            'cause_type' => $cause_type,
            'begin_time' => $date,
            'final_status' => $request['final_status'],
            "updated_at" => date('Y-m-d H:i:s'),
        ]);
        return [
            "successful" => true,
            "data" => $consultation
        ];
        
    }

    public function banklist($id)
    {
        $response = [
            'error_code' => 0,
            'error_msg' => 'success',
            'failed' => [],
            'successful' => [],
        ];
        $bank = Members::find($id);
        $bank_id = explode(',',$bank['bank_id']);
        $bankinfo = Bank::whereIn('id',$bank_id)->get();
        $response['successful'][]=$bankinfo;
        return $response;
    }

    public function deletebank($id)
    {
        $bank = Bank::find($id);
        $bank->delete();
        return [
            'success' => true,
            'date' => $bank
        ];
    }

    public function taglist(Request $request){
        $response = [
            'error_code' => 0,
            'error_msg' => 'success',
            'failed' => [],
            'successful' => [],
        ];
        $sort  = $request->input('sort','id');
        $order = $request->input('order','desc');
        $res = PaymentTag::orderBy($sort, $order)->where('is_delete',0)->paginate();
        return responder()->success($res);
    }

    public function addtag(Request $request)
    {
        $response = [
            'error_code' => 0,
            'error_msg' => 'success',
            'failed' => [],
            'successful' => [],
        ];
        $info = PaymentTag::where('tag',$request['tag'])->get();
        $info = $info->toArray();
        if($info != []){
            $response["error_msg"] = '分类名称已存在!';
            $response["successful"] = false;
            return $response;
        }
        if(!$request->input('tag')){
            $response["error_msg"] = '分类名称不能为空!';
            $response["successful"] = false;
            return $response;
        }
        $res = PaymentTag::insert([
            'tag' => $request->input('tag'),
            'introduce' => $request->input('introduce')
        ]);
        $response["successful"][] = $res;
        return $response;
    }

    public function updatetag($id,Request $request)
    {
        $response = [
            'error_code' => 0,
            'error_msg' => 'success',
            'failed' => [],
            'successful' => [],
        ];
        $info = PaymentTag::where('tag',$request['tag'])->get();
        $info = $info->toArray();
        
        $tag = PaymentTag::find($id);
        $tag->update([
            'tag' => $request['tag'],
            'introduce' => $request['introduce']
        ]);
        return [
            "successful" => true,
            "data" => $tag
        ];
    }

    public function deletetag($id)
    {
        $tag = PaymentTag::find($id);
        $tag->update([
            'is_delete' => 1
        ]);
        return [
            'successful' => true,
            'date' => $tag
        ];
    }
}
