@extends('layouts.app')

@section('content')
    <div id="transaction" class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <form method="GET" action="{{ route('transaction.chart') }}">
                    <div class="form-group">
                        <label for="from">From:</label>
                        <input id="from" name="from" type="date" class="form-control" value="{{ $data['from'] }}">
                    </div>
                    <div class="form-group">
                        <label for="to">To:</label>
                        <input id="to" name="to" type="date" class="form-control" value="{{ $data['to'] }}">
                    </div>
                    <button class="btn btn-outline-success">Filter</button>
                </form>
                <vc-donut background="white" foreground="grey"
                          :size="200" unit="px" :thickness="30"
                          has-legend legend-placement="top"
                          :sections='@json($expenseCategories)'>
                    Total expense
                </vc-donut>
                <vc-donut background="white" foreground="grey"
                          :size="200" unit="px" :thickness="30"
                          has-legend legend-placement="top"
                          :sections='@json($incomeCategories)'>
                    Total income
                </vc-donut>
            </div>
        </div>
    </div>
@endsection
{{--<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Material+Icons">--}}
{{--<link rel="stylesheet" href="https://unpkg.com/bootstrap-material-design@4.1.1/dist/css/bootstrap-material-design.min.css" integrity="sha384-wXznGJNEXNG1NFsbm0ugrLFMQPWswR3lds2VeinahP8N0zJw9VWSopbjv2x7WCvX" crossorigin="anonymous">--}}
<script src="{{ asset('js/chart.js') }}" defer></script>