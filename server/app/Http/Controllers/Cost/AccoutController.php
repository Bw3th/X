<?php

namespace App\Http\Controllers\Cost;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Members;
use App\Bank;
use App\User;
use App\Role;

class AccoutController extends Controller
{
    public function index(Request $request)
    {
        $response = [
            'error_code' => 0,
            'error_msg' => 'success',
            'failed' => [],
            'successful' => [],
        ];
        $sort  = $request->input('sort','id');
        $order = $request->input('order','desc');
        $member = Members::orderBy($sort, $order) 
                         ->select('members.*','banks.bank_num','banks.opening_bank','hospitals.hospital_name')
                         ->where('members.is_delete',0)
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

    public function add(Request $request)
    {
        $response = [
            'error_code' => 0,
            'error_msg' => 'success',
            'failed' => [],
            'successful' => [],
        ];
        $res = [];
        $bank_info['bank_num'] = $request['bank_num'];
        $bank_info['opening_bank'] = $request['opening_bank'];
        $bank_info['type'] = 0;
        $data["name"] = $request['name'];
        $data['sex'] = $request['sex'];
        $data['IDcard'] = $request['IDcard'];
        $data['company'] = $request['company'];
        $data['mobile'] = $request['mobile'];
        $data['updated_at'] = date("Y-m-d H:i:s");
        $bank_id = Bank::insertGetId($bank_info);
        $data['bank_id'] = $bank_id;
        $data['created_at'] = date("Y-m-d H:i:s");
        $res = Members::insert(
                $data
        );
        if($res){
            $response['successful'][] = $res;
            return $response;
        }else{
            $response['successful'][] = $meminfo;
            return $response;
        }
        $response['failed'][] = "加载失败";
        return $response;
    }

    public function delete($id)
    {
        $Members = Members::find($id);
        $Members->update([
            'is_delete' => 1
        ]);
        return [
            'success' => true,
            'data' => $Members
        ];
    }

    public function update($id, Request $request)
    {
        $response = [
            'error_code' => 0,
            'error_msg' => 'success',
            'failed' => [],
            'successful' => [],
        ];
        $this->validate($request, [
            'name' => 'required|string',
            'sex' => 'required|integer',
            'company' => 'required',
            'mobile' => 'required',
            'IDcard' => 'required'
        ]);
        $res = Members::find($id);
        $bank_id = $res['bank_id'];
        $banknum = $request['bank_num'];
        $opening_bank = $request['opening_bank'];
        $ress = Bank::find($bank_id);
        $ress->update([
            'bank_num' => $banknum,
            'opening_bank' => $opening_bank,
        ]);
        $res->update([
            'name' => $request['name'],
            'sex' => $request['sex'],
            'company' => $request['company'],
            'mobile' => $request['mobile'],
            'IDcard' => $request['IDcard'],
            'updated_at' => date("Y-m-d H:i:s")
        ]);
        $response['successful'] = $res;
        return $response;
    }

    public function is_role(Request $request)
    {
        $response = [
            'error_code' => 0,
            'error_msg' => 'success',
            'failed' => [],
            'successful' => [],
        ];
        $user = auth('api')->user();
        $role = Role::find($user['role']);
        $response['successful'] = $role['role'];
        return $response;
    }

    public function bank($id,Request $request)
    {
        $response = [
            'error_code' => 0,
            'error_msg' => 'success',
            'failed' => [],
            'successful' => [],
        ];
        $bank_info['bank_num'] = $request['bank_n'];
        $bank_info['opening_bank'] = $request['opening_b'];
        $bank_info['type'] = 0;
        $meminfo = Members::find($id);
        $bankinfo = Bank::where('bank_num', $request['bank_n'])->first();
        if(!$bankinfo){
            $bank_id = Bank::insertGetId($bank_info);
            $data['bank_id'] = $bank_id.','.$meminfo['bank_id'];
            $meminfo->update(
                $data
            );
        }
        $response['successful'][] = $meminfo;
        return $response;

    }
}
