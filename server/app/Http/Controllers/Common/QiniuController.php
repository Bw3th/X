<?php

namespace App\Http\Controllers\Common;

use App\Http\Controllers\Controller;
use Qiniu\Auth;

class QiniuController extends Controller
{
    public function token()
    {
        $accessKey = env('QINIU_APPKEY');
        $secretKey = env('QINIU_APPSECRET');
        $auth = new Auth($accessKey, $secretKey);
        $bucket = env('QINIU_BUCKET');
        // 生成上传Token
        $token = $auth->uploadToken($bucket);
        return responder()->success(['token' => $token, 'domain' => env('QINIU_DOMAIN')]);
    }
}
