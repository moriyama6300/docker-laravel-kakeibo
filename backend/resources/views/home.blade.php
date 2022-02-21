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
                <input type="date" name="date" class="form-control {{ $errors->has('date') ? 'is-invalid' : '' }}" value="{{ old('date', $today) }}">
                @if ($errors->has('date'))
                    {{ $errors->first('date') }}
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
                    @foreach($labels as $label)
                        <option value="{{ $label['name'] }}">{{ $label['name'] }}</option>
                    @endforeach
                </select>
                @if ($errors->has('category'))
                    {{ $errors->first('category') }}
                @endif
            </div>
            <div>
                金額 :
                <input id='yen' name='yen' type='text' placeholder="※必須" class="form-control {{ $errors->has('yen') ? 'is-invalid' : '' }}" value="{{ old('yen') }}">
                円
                @if ($errors->has('yen'))
                    {{ $errors->first('yen') }}
                @endif
            </div>
            <button type="submit" class="btn btn-primary">
                登録
            </button>
        </form>
        <div>
            <form action="/reference" method="post" enctype='multipart/form-data'>
                @csrf
                <select name="year">
                    @for ($i = 1980; $i <= $year; $i++)
                        @if($i == $year)
                            <option value={{ $i }} selected>{{ $i }}年</option>
                        @else
                            <option value={{ $i }}>{{ $i }}年</option>
                        @endif
                    @endfor
                </select>
                <select name="month">
                    @for ($i = 1; $i <= 12; $i++)
                        @if($i == $month)
                            <option value={{ $i }} selected>{{ $i }}月</option>
                        @else
                            <option value={{ $i }}>{{ $i }}月</option>
                        @endif
                    @endfor
                </select>
                <button type="submit" class="btn btn-primary">
                    参照
                </button>
            </form>
        </div>
        <!-- 仮　カテゴリ操作 -->
        <form action="/addCategory" method="post" enctype='multipart/form-data'>
            @csrf
            <div>
                カテゴリ名 :
                <input id="categoryName" name="categoryName" type='text' class="form-control {{ $errors->has('categoryName') ? 'is-invalid' : '' }}">
                カラー :
                <input id="categoryColor" name="categoryColor" type='text' class="form-control {{ $errors->has('categoryColor') ? 'is-invalid' : '' }}">
                <button type="submit" class="btn btn-primary">
                    追加
                </button>
                @if ($errors->has('categoryName'))
                        {{ $errors->first('categoryName') }}
                @endif
                @if ($errors->has('categoryColor'))
                        {{ $errors->first('categoryColor') }}
                @endif
            </div>
        </form>
        <form action="/delCategory" method="post" enctype='multipart/form-data'>
            @csrf
            <select name="category_id">
                <option value=""></option>
                @foreach($labels as $label)
                    <option value="{{ $label['id'] }}">{{ $label['name'] }}</option>
                @endforeach
            </select>
            <button type="submit" class="btn btn-primary">
                削除
            </button>
            @if ($errors->has('category_id'))
                <div class="invalid-feedback">
                    {{ $errors->first('category_id') }}
                </div>
            @endif
        </form>
        <!-- 仮　カテゴリ操作 -->
        <canvas id="my_chart"></canvas>
        <script src="{{ mix('js/chart.js') }}"></script>
        <script src="/bower_components/chart.js/dist/Chart.min.js"></script>
        <script src="/bower_components/chartjs-plugin-labels/build/chartjs-plugin-labels.min.js"></script>
        <!-- <script src="https://cdn.jsdelivr.net/gh/emn178/chartjs-plugin-labels/src/chartjs-plugin-labels.js"></script> -->
        <script>
            id = 'my_chart';
            labels = @json($labels);
            console.log(labels);
            data = @json($sum);
            title = '@json($year)年@json($month)月';
            title = title.replace(/"/g, '');
            make_chart(id, labels, data, title);
        </script>
        <script src="https://cdn.jsdelivr.net/npm/vue"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.js"></script>
    </div>
</body>

</html>
