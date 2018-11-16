@extends('layouts.app')

@section('content')
    <div id="wallet" class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Wallet</div>

                    <div class="card-body">
                        @foreach($wallets as $wallet)
                            <div>
                                <div>{{ $wallet->name }}</div>
                                <div>Balance: {{ $wallet->balance }}</div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Budgets</div>

                    <div class="card-body" style="padding: 0">
                        <div class="list-group">
                            @foreach ($budgets as $budget)
                                <div class="list-group-item list-group-item-action flex-column align-items-start">
                                    <div class="d-flex w-100 justify-content-between">
                                        <h5 class="mb-1">{{ $budget->name }}</h5>
                                        <small>
                                            @if(\Carbon\Carbon::createFromFormat('Y-m-d', $budget->to)->isFuture())
                                                {{ \Carbon\Carbon::now()->diffInDays(\Carbon\Carbon::createFromFormat('Y-m-d', $budget->to)) }} days left
                                            @else
                                                {{ $budget->from }} - {{ $budget->to }}
                                            @endif
                                        </small>
                                    </div>
                                    <div class="progress">
                                        <div class="progress-bar" role="progressbar" style="width: {{ calcPercent($budget->starting_balance, $budget->current_balance) }}%" aria-valuenow="{{ calcPercent($budget->starting_balance, $budget->current_balance) }}" aria-valuemin="0" aria-valuemax="100">{{ calcPercent($budget->starting_balance, $budget->current_balance) }}%</div>
                                    </div>
                                    <p class="mb-1">You have: {{ $budget->current_balance > 0 ? $budget->current_balance : 0 }}</p>
                                    <p class="mb-1">You spent: {{ $budget->starting_balance - $budget->current_balance }} / {{ $budget->starting_balance }}</p>
                                    <small><a href="/transaction#{{ str_replace('/transaction','',route('transaction.budget', ['budgetId' => $budget->id], false)) }}">Transactions.</a></small>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
<script src="{{ asset('js/budget.js') }}" defer></script>
