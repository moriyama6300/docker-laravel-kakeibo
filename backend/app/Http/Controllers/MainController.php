<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Outgoing;
use App\Income;
use Carbon\Carbon;

class MainController extends Controller
{
    public function home(Request $request){
        // 今月の1日を取得する
        $from = Carbon::createFromDate('first day of this month');
        // 来月の1日を取得する
        $to = Carbon::createFromDate('last day of this month');
        // whereBetween句で検索をかけてデータを取得
        $outgoings = Outgoing::whereBetween('date', [$from, $to])->get();
        $outgoingSum = $outgoings->sum('yen');
        $incomes = Income::whereBetween('date', [$from, $to])->get();
        $incomeSum = $incomes->sum('yen');
        $syushi = $incomeSum - $outgoingSum;
        $category1 = $outgoings->where('category', '住居費')->sum('yen');
        $category2 = $outgoings->where('category', '水道光熱費')->sum('yen');
        $category3 = $outgoings->where('category', '通信費')->sum('yen');
        $category4 = $outgoings->where('category', '食費')->sum('yen');
        $category5 = $outgoings->where('category', '娯楽費')->sum('yen');
        $category6 = $outgoings->where('category', '日用品費')->sum('yen');
        $category7 = $outgoings->where('category', '保険料')->sum('yen');
        $category8 = $outgoings->where('category', 'その他')->sum('yen');
        $category9 = $incomes->where('category', '給与')->sum('yen');
        $category10 = $incomes->where('category', 'その他')->sum('yen');
        $now = new Carbon('now');
        $year = date('Y', strtotime($now));
        $month = date('m', strtotime($now));
        $labels = ['住居費', '水道光熱費', '通信費', '食費', '娯楽費', '日用品費', '保険料', 'その他'];
        $sums = [$category1, $category2, $category3, $category4, $category5, $category6, $category7, $category8];
        // viewにわたす
        return view('home',['outgoings' => $outgoings,
                            'incomes' => $incomes,
                            'outgoingSum' => $outgoingSum,
                            'incomeSum' => $incomeSum,
                            'syushi' => $syushi,
                            'category1' => $category1,
                            'category2' => $category2,
                            'category3' => $category3,
                            'category4' => $category4,
                            'category5' => $category5,
                            'category6' => $category6,
                            'category7' => $category7,
                            'category8' => $category8,
                            'category9' => $category9,
                            'category10' => $category10,
                            'year' => $year,
                            'month' => $month,
                            'labels' => $labels,
                            'sums' => $sums
        ]);
    }

    public function input(Request $request){
        // dd($request);
        if($request->which == 'out'){
            Outgoing::create([
                // 'user_id' => Auth::user()->id,
                'date' => $request->date,
                'category' => $request->category,
                'yen' => $request->yen
            ]);
        }elseif($request->which == 'in'){
            Income::create([
                // 'user_id' => Auth::user()->id,
                'date' => $request->date,
                'category' => $request->category,
                'yen' => $request->yen
            ]);
        }
        return redirect()->route('home');
    }

}