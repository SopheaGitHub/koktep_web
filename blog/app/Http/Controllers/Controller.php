<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesResources;

class Controller extends BaseController
{
    use AuthorizesRequests, AuthorizesResources, DispatchesJobs, ValidatesRequests;

    protected function systemLogs($action=null, $key=null, $all_resuest=[]) {
        try {
            // get information for log
            if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
                $ip_note = 'HTTP_CLIENT_IP='.$_SERVER['HTTP_CLIENT_IP'];
                $ip = $_SERVER['HTTP_CLIENT_IP'];
            } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
                $ip_note = 'HTTP_X_FORWARDED_FOR='.$_SERVER['HTTP_X_FORWARDED_FOR'];
                $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
            } else {
                $ip_note = 'REMOTE_ADDR='.$_SERVER['REMOTE_ADDR'];
                $ip = $_SERVER['REMOTE_ADDR'];
            }

            $url = \Request::url();
            $ipinfo = json_decode(file_get_contents("https://ipinfo.io/".$ip), true);

            $arrayDatas = [
                'url' => $url,
                'request' => $all_resuest,
                'ip_info' => $ipinfo
            ];

            $systemLogDatas = [
                'user_id' => ((\Auth::check())? \Auth::user()->id:'0'),
                'ip' => $ip,
                'action' => $action,
                'key' => $key,
                'value' => json_encode($arrayDatas),
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ];

            \DB::table('system_log')->insert($systemLogDatas);
            // End

        } catch (Exception $e) {
            echo $e->getMessage();
            exit();
        }
    }

}
