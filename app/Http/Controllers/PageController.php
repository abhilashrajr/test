<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Orders;
use App\Models\Bookings;
use DB;

class PageController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display all the static pages when authenticated
     *
     * @param string $page
     * @return \Illuminate\View\View
     */
    public function index(string $page)
    {
        if (view()->exists("pages.{$page}")) {
            return view("pages.{$page}");
        }

        return abort(404);
    }

    public function dashboard()
    {
        


        $past_week = \Carbon\Carbon::today()->subDays(7);

       // $users = Orders::where('created_at','>=',$date)->count();
       /*
        $full_data = Orders::select(\DB::raw("SUM(amount) as revenue"),\DB::raw("COUNT(id) as total"))
                        ->where('status','=',3)->first();
         */
        $card_data = Orders::select(\DB::raw("SUM(amount) as revenue"),\DB::raw("COUNT(id) as total"))
                        ->where('status','=',2)
                        ->where('payment_method','=',1)
                        ->first(); 
                   
        $cash_data = Orders::select(\DB::raw("SUM(amount) as revenue"),\DB::raw("COUNT(id) as total"))
                        ->where('status','=',2)
                        ->where('payment_method','=',2)
                        ->first();  
        
        $chart_data = Orders::select(\DB::raw("SUM(amount) as revenue"),\DB::raw('MONTHNAME(order_time) as month'))
                        ->where('status','=',2)
                        ->groupby(\DB::raw('MONTH(order_time)'))
                        ->orderBy('order_time', 'asc')
                        ->limit(7)
                        ->get();
    
        return view('pages.dashboard',compact('card_data','cash_data','chart_data'));
    }
    public function stats(Request $request)
    {
        if ($request->isMethod('post')) {
            $request->validate([
                'from' => 'required',
                'to' => 'required',
            ]);
        }
            
        $query = Orders::select(\DB::raw("IFNULL(SUM(amount),0) as revenue"),\DB::raw("IFNULL(COUNT(id),0) as total"))->where('status','=',2);
        if(!empty($request->from))
            $query->whereDate('order_time', '>=', $request->from);
        if(!empty($request->to))
            $query->whereDate('order_time', '<=', $request->to);
        $summary = $query->groupby('payment_method')->orderBy('payment_method', 'asc')->get()->toArray();
       
        $query =  DB::table("orders as o1")
                    ->select(DB::raw('MONTHNAME(order_time) as month'),DB::raw("(select count(id) from orders as o2 where o2.status=2 and MONTHNAME(o2.order_time)=MONTHNAME(o1.order_time) AND o2.payment_method=2)as cash_order"),DB::raw("(select count(id) from orders as o3 where o3.status=2 and MONTHNAME(o3.order_time)=MONTHNAME(o1.order_time) AND o3.payment_method=1)as card_order"),DB::raw("(select IFNULL(SUM(amount),0) from orders as o2 where o2.status=2 and MONTHNAME(o2.order_time)=MONTHNAME(o1.order_time) AND o2.payment_method=2)as cash_revenue"),DB::raw("(select IFNULL(SUM(amount),0) from orders as o3 where o3.status=2 and MONTHNAME(o3.order_time)=MONTHNAME(o1.order_time) AND o3.payment_method=1)as card_revenue"))
                    ->where('status','=',2);
        if(!empty($request->from))
                $query->whereDate('order_time', '>=', $request->from);
        if(!empty($request->to))
                 $query->whereDate('order_time', '<=', $request->to);
                 $query->groupby(DB::raw('MONTH(o1.order_time)'))
                    ->orderBy('o1.order_time', 'asc');
        if(empty($request->from))
                    $query->limit(5);
        $order_data =  $query->get();
        $data['month'] = $data['cash_order'] = $data['card_order'] = $data['cash_revenue'] = $data['card_revenue'] = $data['revenue'] = [];

        if(!empty($order_data)){
            foreach($order_data as $item)
            { 
                $data['month'][] = $item->month;
                $data['cash_order'][] = $item->cash_order;
                $data['card_order'][] = $item->card_order;
                $data['cash_revenue'][] = $item->cash_revenue;
                $data['card_revenue'][] = $item->card_revenue;
                $data['revenue'][] = $item->card_revenue + $item->cash_revenue;
            }
        }  
    
        $query = Bookings::select(\DB::raw("IFNULL(COUNT(id),0) as total"))->where('status','=',2);
        if(!empty($request->from))
            $query->whereDate('date', '>=', $request->from);
        if(!empty($request->to))
            $query->whereDate('date', '<=', $request->to);
        $bookings = $query->get()->toArray();
        //dd($data);   
        return view("pages.stats",compact('summary','data','bookings','request'));
    }
    public function exportstats(Request $request)
    {


        
        
        $query = Orders::select(\DB::raw("IFNULL(SUM(amount),0) as revenue"),\DB::raw("IFNULL(COUNT(id),0) as total"))->where('status','=',2);
        if(!empty($request->from))
            $query->whereDate('order_time', '>=', $request->from);
        if(!empty($request->to))
            $query->whereDate('order_time', '<=', $request->to);
        $orders = $query->groupby('payment_method')->orderBy('payment_method', 'asc')->get()->toArray();

       
        
        $query = Bookings::select(\DB::raw("IFNULL(COUNT(id),0) as total"))->where('status','=',2);
        if(!empty($request->from))
            $query->whereDate('date', '>=', $request->from);
        if(!empty($request->to))
            $query->whereDate('date', '<=', $request->to);
        $bookings = $query->get()->toArray();

        $date =[];
        if(empty($request->from)||empty($request->to))
                    $date = Orders::select(\DB::raw("MIN(order_time) AS fromDate"),\DB::raw(" MAX(order_time) AS toDate "))->where('status','=',2)->get()->toArray();

      

        $fileName = 'stats.csv';
      
    
            $headers = array(
                "Content-type"        => "text/csv",
                "Content-Disposition" => "attachment; filename=$fileName",
                "Pragma"              => "no-cache",
                "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
                "Expires"             => "0"
            );
    
            $columns = array('From','To','Card Payments', 'Card Orders', 'Cash Payments', 'Cash Orders', 'Total Payments','Total Orders','Bookings');
    
            $callback = function() use($orders,$bookings, $columns,$request,$date) {
                                
                $file = fopen('php://output', 'w');
                fputcsv($file, $columns,);
    
                    $row['From']  = $request->from ??  $date[0]['fromDate'];
                    $row['To']  = $request->to ??  $date[0]['toDate'];
                    $row['Card Payments']  = number_format( ($orders[0]['revenue'] ?? 0),2);
                    $row['Card Orders']    = $orders[0]['total'] ?? 0;
                    $row['Cash Payments']    = number_format( ($orders[1]['revenue'] ?? 0),2);
                    $row['Cash Orders']  = $orders[1]['total'] ?? 0;
                    $row['Total Payments']  = number_format(($orders[0]['revenue'] ?? 0)+($orders[1]['revenue'] ?? 0),2);
                    $row['Total Orders']  = ($orders[0]['total'] ?? 0)+ ($orders[1]['total'] ?? 0);
                    $row['Bookings']  = $bookings[0]['total'] ?? 0;
                    fputcsv($file, array($row['From'],$row['To'],$row['Card Payments'], $row['Card Orders'], $row['Cash Payments'], $row['Cash Orders'], $row['Total Payments'], $row['Total Orders'], $row['Bookings']));
                
    
                fclose($file);
            };
    
            return response()->stream($callback, 200, $headers);
        }
}
