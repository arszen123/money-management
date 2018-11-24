@extends('layouts.app')

@section('content')
    <div id="wallet" class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body" style="padding: 0">
                        <budgets-view :budgets='@json($budgets)'/>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
<script src="{{ asset('js/budget.js') }}" defer></script>
