<?php declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Outgoing;
use App\Income;
use App\Labels;
use Carbon\Carbon;

final class MainController extends Controller
{
    public function home(Request $request)
    {
        $today = new Carbon('today');
        $year = $today->year;
        $month = $today->month;
        $data = $this->selectData($year, $month);

        $labels = Labels::get();
        $sum = [];
        foreach($labels as $label){
            array_push($sum, $data['outgoings']->where('category', $label['name'])->sum('yen'));
        }

        return view('home', [
            'today' => $today,
            'outgoings' => $data['outgoings'],
            'incomes' => $data['incomes'],
            'outgoingSum' => $data['outgoingSum'],
            'incomeSum' => $data['incomeSum'],
            'syushi' => $data['syushi'],
            'year' => $year,
            'month' => $month,
            'labels' => $labels,
            'sum' => $sum
        ]);
    }

    /*
    * 登録関数
    */
    public function input(Request $request)
    {
        //バリエーション
        $request->validate([
            'date' => 'required',
            'category' => 'required',
            'yen' => 'required|integer|numeric',
        ], [
            'date.required' => '日付は必須です。',
            'category.required' => 'カテゴリは必須です。',
            'yen.required' => '金額は必須です。',
            'yen.integer' => '金額は整数値で入力してください。',
            'yen.numeric' => '金額は整数値で入力してください。',
        ]);

        // 支出か収入で分岐
        if ($request->which === 'out') {
            Outgoing::create([
                // 'user_id' => Auth::user()->id,
                'date' => $request->date,
                'category' => $request->category,
                'yen' => $request->yen
            ]);
        } elseif ($request->which === 'in') {
            Income::create([
                // 'user_id' => Auth::user()->id,
                'date' => $request->date,
                'category' => $request->category,
                'yen' => $request->yen
            ]);
        }
        return redirect()->route('home');
    }

    /*
    * データ取得関数
    */
    public function selectData($year, $month){
        $result = [];

        // 月の1日を取得する
        $from = Carbon::create($year, $month, 1)->firstOfMonth();
        // 月の最終日を取得する
        $to = Carbon::create($year, $month, 1)->lastOfMonth();

        // 支出データ
        $outgoings = Outgoing::whereBetween('date', [$from, $to])->get();
        $result['outgoings'] = $outgoings;

        // 支出合計金額
        $outgoingSum = $outgoings->sum('yen');
        $result['outgoingSum'] = $outgoingSum;

        // 収入データ
        $incomes = Income::whereBetween('date', [$from, $to])->get();
        $result['incomes'] = $incomes;

        // 収入合計金額
        $incomeSum = $incomes->sum('yen');
        $result['incomeSum'] = $incomeSum;

        // 収支
        $syushi = $incomeSum - $outgoingSum;
        $result['syushi'] = $syushi;

        return $result;
    }

    /*
    * データ参照関数
    */
    public function reference(Request $request){
        $data = $this->selectData($request->year, $request->month);
        $labels = Labels::get();
        $sum = [];
        foreach($labels as $label){
            array_push($sum, $data['outgoings']->where('category', $label['name'])->sum('yen'));
        }

        $today = new Carbon('today');

        return view('home', [
            'today' => $today,
            'outgoings' => $data['outgoings'],
            'incomes' => $data['incomes'],
            'outgoingSum' => $data['outgoingSum'],
            'incomeSum' => $data['incomeSum'],
            'syushi' => $data['syushi'],
            'year' => $request->year,
            'month' => $request->month,
            'labels' => $labels,
            'sum' => $sum
        ]);
    }

    /*
    * カテゴリ追加関数
    */
    public function addCategory(Request $request)
    {
        // バリデーション
        $request->validate([
            'categoryName' => 'required',
        ], [
            'categoryName.required' => 'カテゴリ名は必須です。'
        ]);

        Labels::create([
            'name' => $request->categoryName,
            'color' => $request->categoryColor
        ]);

        return redirect()->route('home');
    }

    /*
    * カテゴリ削除関数
    */
    public function delCategory(Request $request)
    {
        // バリデーション
        $request->validate([
            'category_id' => 'required',
        ], [
            'category_id.required' => 'カテゴリ名は必須です。'
        ]);

        Labels::where('id', $request->category_id)->delete();
        $labels = Labels::get();

        return redirect()->route('home');
    }
}
