<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Kakeibo</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

    <!-- Styles -->
    <style>
        html,
        body {
            background-color: #fff;
            color: #636b6f;
            font-family: 'Nunito', sans-serif;
            font-weight: 200;
            height: 100vh;
            margin: 0;
        }

        .full-height {
            height: 100vh;
        }

        .flex-center {
            align-items: center;
            display: flex;
            justify-content: center;
        }

        .position-ref {
            position: relative;
        }

        .top-right {
            position: absolute;
            right: 10px;
            top: 18px;
        }

        .content {
            text-align: center;
        }

        .title {
            font-size: 84px;
        }

        .links>a {
            color: #636b6f;
            padding: 0 25px;
            font-size: 13px;
            font-weight: 600;
            letter-spacing: .1rem;
            text-decoration: none;
            text-transform: uppercase;
        }

        .m-b-md {
            margin-bottom: 30px;
        }
    </style>
</head>

<body class="antialiased">
    <div id="app">
        <div class=title>Kakeibo</div>
        <form action="/input" method="post" enctype='multipart/form-data'>
            @csrf
            <div>
                日付 :
                <input type="date" name="date" class="form-control {{ $errors->has('date') ? 'is-invalid' : '' }}" value="{{ old('date') }}">
                @if ($errors->has('date'))
                <div class="invalid-feedback">
                    {{ $errors->first('date') }}
                </div>
                @endif
            </div>
            <div>
                収支 :
                <select name="which">
                    <option value="out">支出</option>
                    <option value="in">収入</option>
                </select>
            </div>
            <div>
                カテゴリ :
                <select name="category">
                    <option value=""></option>
                    <option value="住居費">住居費</option>
                    <option value="水道光熱費">水道光熱費</option>
                    <option value="通信費">通信費</option>
                    <option value="食費">食費</option>
                    <option value="娯楽費">娯楽費</option>
                    <option value="日用品費">日用品費</option>
                    <option value="保険料">保険料</option>
                    <option value="給与">給与</option>
                    <option value="その他">その他</option>
                </select>
            </div>
            <div>
                金額 :
                <input id='yen' name='yen' type='text' placeholder="※必須" class="form-control {{ $errors->has('yen') ? 'is-invalid' : '' }}" value="{{ old('yen') }}">
                円
                @if ($errors->has('yen'))
                <div class="invalid-feedback">
                    {{ $errors->first('yen') }}
                </div>
                @endif
            </div>
            <button type="submit" class="btn btn-primary">
                登録する
            </button>
        </form>
        <canvas id="my_chart"></canvas>
        <script src="{{ mix('js/chart.js') }}"></script>
        <script src="/bower_components/chart.js/dist/Chart.min.js"></script>
        <script src="/bower_components/chartjs-plugin-labels/build/chartjs-plugin-labels.min.js"></script>
        <!-- <script src="https://cdn.jsdelivr.net/gh/emn178/chartjs-plugin-labels/src/chartjs-plugin-labels.js"></script> -->
        <script>
            id = 'my_chart';
            lavels = @json($labels);
            data = @json($sums);
            title = '@json($year)年@json($month)月';
            title = title.replace(/"/g, '');
            make_chart(id, lavels, data, title);
        </script>
        <!-- <div>{{ $year }}年  {{ $month }}月</div>
            <div>支出：{{ $outgoingSum }}円</div>
            <div>収入：{{ $incomeSum }}円</div>
            <div>収支：{{ $syushi }}円</div>
            <br>
            <div>カテゴリ</div>
            <div>住居費：{{ $category1 }}円</div>
            <div>水道光熱費：{{ $category2 }}円</div>
            <div>通信費：{{ $category3 }}円</div>
            <div>食費：{{ $category4 }}円</div>
            <div>娯楽費：{{ $category5 }}円</div>
            <div>日用品費：{{ $category6 }}円</div>
            <div>保険料：{{ $category7 }}円</div>
            <div>その他支出：{{ $category8 }}円</div>
            <div>給与：{{ $category9 }}円</div>
            <div>その他収入：{{ $category10 }}円</div> -->
        <script src="https://cdn.jsdelivr.net/npm/vue"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.js"></script>
    </div>
</body>

</html>