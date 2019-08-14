<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Client;
use App\Email;
use Carbon\Carbon;
use File;

class HomeController extends Controller {

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    protected $request;

    public function __construct(Request $request) {
        $this->request = $request;
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function test() {
//         $email = Email::where('id','1')->pluck('emails');
//         $emails = $email[0];
//         $email = explode(',',$emails);
//        echo '<pre>';
//        print_r($email);
//        echo '</pre>';
//        exit();
    }

    public function index() {
        $mytime = Carbon::today();
        $timestamp = strtotime($mytime);
        $day = date('l', $timestamp);
        $date = date('m/d/Y');
        $all_client_application = Client::whereNotNull('email')->where('status','active')->count();
        $today_client_application = Client::whereNotNull('email')->where('status','active')->whereDate('created_at', Carbon::today())->count();
        $unread_client_application = Client::whereNotNull('email')->where('status','active')->where('is_red', '0')->count();
        $total_mpbile_application = Client::whereNotNull('email')->where('status','active')->where('type', '1')->count();
        $total_web_application = Client::whereNotNull('email')->where('status','active')->where('type', '2')->count();
        return view('admin.dashboard.index', ['totalmobile' => $total_mpbile_application, 'totalweb' => $total_web_application, 'unreadapplication' => $unread_client_application, 'allapplication' => $all_client_application, 'today_client_application' => $today_client_application]);
    }

    public function check() {
        if (\Auth::check()) {
            return redirect('admin/home');
        } else {
            return view('front.index');
        }
    }

    public function chartdetails(Request $request) {
        $month = array();
        $greycount = array();
        $greencount = array();
        $unread = array();
        $r = $request->all();
        if ($r) {
            if (!empty($r['start_date']) && !empty($r['end_date'])) {
                $start_date = $r['start_date'];
                $end_date = $r['end_date'];
                $start_date = date("Y-m-d", strtotime($start_date));
                $end_date = date("Y-m-d", strtotime($end_date));
                $all = DB::select('select count(id) as `data`,SUM(CASE WHEN `email` is not null AND `is_red` = 0 THEN 1 ELSE 0 END) as `unread`,GROUP_CONCAT(type) as type, DATE_FORMAT(created_at, "%D-%M") new_date, DAY(created_at) as day, YEAR(created_at) as year, MONTH(created_at) as month from `clients` WHERE `email` is not null AND `status`="active" AND created_at BETWEEN "' . $start_date . ' 00:00:00" AND "' . $end_date . ' 23:59:59" group by `day`,`year`, `month` ORDER BY month');
            } else {
                if ($r['charttype'] == 'today') {
                    $start_date = Carbon::today()->toDateTimeString();
                    $end_date = Carbon::today()->toDateTimeString();
                    $start_date = date("Y-m-d", strtotime($start_date));
                    $end_date = date("Y-m-d", strtotime($end_date));
                }
                if ($r['charttype'] == 'month') {
                    $start_date = Carbon::now()->subDay()->startOfMonth()->toDateTimeString();
                    $end_date = Carbon::today()->toDateTimeString();
                    $start_date = date("Y-m-d", strtotime($start_date));
                    $end_date = date("Y-m-d", strtotime($end_date));
                }
                if ($r['charttype'] == 'week') {
                    $start_date = Carbon::now()->startOfWeek()->toDateTimeString();
                    $end_date = Carbon::today()->toDateTimeString();
                    $start_date = date("Y-m-d", strtotime($start_date));
                    $end_date = date("Y-m-d", strtotime($end_date));
                }
//                if ($type == 'admin') {
                    if(!empty($r['charttype'])){
                    $all = DB::select('select count(id) as `data`,`email`,SUM(CASE WHEN `email` is not null AND `is_red` = 0 THEN 1 ELSE 0 END) as `unread`,GROUP_CONCAT(type) as type, DATE_FORMAT(created_at, "%D-%M") new_date, DAY(created_at) as day, YEAR(created_at) as year, MONTH(created_at) as month from `clients` WHERE `email` is not null AND `status`="active" AND created_at BETWEEN "' . $start_date . ' 00:00:00" AND "' . $end_date . ' 23:59:59" group by `day`,`year`, `month` ORDER BY month');
                    }  else {
                    $all = DB::select('select count(id) as `data`,SUM(CASE WHEN `email` is not null AND `is_red` = 0 THEN 1 ELSE 0 END) as `unread`,GROUP_CONCAT(type) as type, DATE_FORMAT(created_at, "%D-%M") new_date, DAY(created_at) as day, YEAR(created_at) as year, MONTH(created_at) as month from `clients` WHERE `email` is not null AND `status`="active" group by CAST(created_at AS DATE) ORDER BY month');
                    }
                    
//                } else {
//                $all = DB::select('select count(id) as `data`,SUM(CASE WHEN `is_red` = 0 THEN 1 ELSE 0 END) as `unread`,GROUP_CONCAT(type) as type, DATE_FORMAT(created_at, "%D-%M") new_date, DAY(created_at) as day, YEAR(created_at) as year, MONTH(created_at) as month from `clients` group by CAST(created_at AS DATE) ORDER BY month');
//                }
            }
//            $all = Client::where('created_at', '>', $start_date)->where('created_at', '<', $end_date)->get();
        }

        if (!empty($all)) {
            foreach ($all as $a) {
                $count = array_count_values(explode(',', ($a->type)));
                if (array_key_exists(2, $count)) {
                    $greycount[] = $count[2];
                } else {
                    $greycount[] = 0;
                }
                if (array_key_exists(1, $count)) {
                    $greencount[] = $count[1];
                } else {
                    $greencount[] = 0;
                }
                $month[] = $a->new_date;
                if (!empty($a->unread)) {
                    $unread[] = (int)$a->unread;
                } else {
                    $unread[] = 0;
                }
            }
        }
        $arry = array('month' => $month, 'greencount' => $greycount, 'greycount' => $greencount, 'unread' => $unread);
        return \Response::json($arry);
    }

}
