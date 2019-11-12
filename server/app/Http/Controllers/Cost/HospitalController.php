<?php

namespace App\Http\Controllers\Cost;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Hospital;
use App\Members;

class HospitalController extends Controller
{
    public function show(Request $request)
    {
        $response = [
            'error_code' => 0,
            'error_msg' => 'success',
            'failed' => [],
            'successful' => [],
        ];
        $sort  = $request->input('sort','id');
        $order = $request->input('order','desc');
        $hospital = Hospital::orderBy($sort, $order)
                            ->where('is_delete',0)
                            ->paginate();
        foreach($hospital as $k => $v){
            $count_mem = Members::where('company',$v['id'])->where('is_delete',0)->count();
            $hospital[$k]['count_mem'] = $count_mem;
        }
        return responder()->success($hospital);
    }

    public function add(Request $request)
    {
        $response = [
            'error_code' => 0,
            'error_msg' => 'success',
            'failed' => [],
            'successful' => [],
        ];
        $info = Hospital::where('hospital_name',$request['hospital_name'])->get();
        $info = $info->toArray();
        if($info != []){
            $response["error_msg"] = '医院名称已存在!';
            $response["successful"] = false;
            return $response;
        }
        if(!$request->input('hospital_name')){
            $response["error_msg"] = '医院名称不能为空!';
            $response["successful"] = false;
            return $response;
        }

        $res = Hospital::insert([
            'hospital_name' => $request->input('hospital_name'),
            'introduce' => $request->input('introduce','')
        ]);
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
        $hospital = Hospital::find($id);
        $hospital->update([
            'hospital_name' => $request->input('hospital_name'),
            'introduce' => $request->input('introduce')?$request->input('introduce'):''
        ]);
        return [
            "successful" => true,
            "data" => $hospital
        ];
    }

    public function delete($id)
    {
        $hospital = Hospital::find($id);
        $hospital->update([
            'is_delete' => 1
        ]);
        return [
            'successful' => true,
            'date' => $hospital
        ];
    }
}
