@extends('layouts.app')

@section('content')
    <div id="transaction" class="container">
        <div class="row justify-content-center">
            <transaction-links />
        </div>
        <div class="row justify-content-center">
            <div class="col-md-12">
                <transaction-view />
            </div>
        </div>
        <notifications group="notification" />
    </div>
@endsection
{{--<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Material+Icons">--}}
{{--<link rel="stylesheet" href="https://unpkg.com/bootstrap-material-design@4.1.1/dist/css/bootstrap-material-design.min.css" integrity="sha384-wXznGJNEXNG1NFsbm0ugrLFMQPWswR3lds2VeinahP8N0zJw9VWSopbjv2x7WCvX" crossorigin="anonymous">--}}
<script src="{{ asset('js/transaction.js') }}" defer></script>