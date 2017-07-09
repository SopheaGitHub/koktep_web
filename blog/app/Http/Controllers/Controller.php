<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesResources;
use App\Http\Controllers\ConfigController;

class Controller extends BaseController
{
    use AuthorizesRequests, AuthorizesResources, DispatchesJobs, ValidatesRequests;

    // system status
    public function status() {
        return $status = ['1' => trans('text.enabled'), '0' => trans('text.disabled')];
    }

    // system watermark position
    public function watermark_positions() {
        return $position = [
            'topleft'       => trans('text.top_left'), 
            'topright'      => trans('text.top_right'),
            'centerleft'    => trans('text.center_left'),
            'centerrigth'   => trans('text.center_rigth'),
            'center'        => trans('text.center'),
            'centertop'     => trans('text.center_top'),
            'centerbottom'  => trans('text.center_bottom'),
            'bottomleft'    => trans('text.bottom_left'), 
            'bottomright'   => trans('text.bottom_right')
        ];
    }

    public function escape($value) {
        return str_replace(array("\\", "\0", "\n", "\r", "\x1a", "'", '"'), array("\\\\", "\\0", "\\n", "\\r", "\Z", "\'", '\"'), htmlspecialchars($value));
    }

    protected function systemLogs($action=null, $key=null, $all_resuest=[]) {
        $configObj = new ConfigController();
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
            // $ipinfo = json_decode(file_get_contents("https://ipinfo.io/".$ip), true);

            $arrayDatas = [
                'url' => $url,
                'request' => $all_resuest,
                'ip_info' => ((isset($ipinfo))? $ipinfo:['ip'=>$ip])
            ];

            $systemLogDatas = [
                'user_id' => ((\Auth::check())? \Auth::user()->id:'0'),
                'ip' => $ip,
                'action' => $action,
                'key' => $key,
                'value' => $arrayDatas,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ];

            // $my_file = $configObj->dir_logs.'system.log';
            // $handle = fopen($my_file, 'a') or die('Cannot open file:  '.$my_file);
            // $new_data = json_encode($systemLogDatas)."\n";
            // fwrite($handle, $new_data);
            // fclose($handle);

            return true;
        } catch (Exception $e) {
            echo $e->getMessage();
            exit();
        }
    }

    protected function readJsonFile($File){
        // open the file to with the R flag,
        $Path = fopen($File,"r") or die('Cannot open file:  '.$File);

        // if file found,
        if ($Path) {
            $print = '';

                // for each line
                while (($line = fgets($Path)) !== false) {
                    $Output = json_decode($line);
                    $print .= "Action: ".$Output->Action."<br/>";
                    $print .= "User: ".$Output->User."<br/>";
                    $print .= "When: ".$Output->Timestamp."<br/>";
                    $print .= "Location: ".$Output->URL."<hr>";
                }

                // close file
            fclose($Path);
        } else {
            $print = 'Error, File not found';
        }
        return $print;

        // how to use it
        // echo readJsonFile("AccessLog.txt");
    }

}
