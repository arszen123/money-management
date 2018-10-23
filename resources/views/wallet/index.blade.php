@extends('layouts.app')

@section('content')
    <div id="wallet" class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Wallet</div>

                    <div class="card-body">
                        <div>Balance: {{ $wallet->balance }}</div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">Savings</div>
                        <savings-view />
                    <div class="card-body">
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">Budgets</div>

                    <div class="card-body" style="padding: 0">
                        <budgets-view :budgets='@json($budgets)'/>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
<script src="{{ asset('js/budget.js') }}" defer></script>
