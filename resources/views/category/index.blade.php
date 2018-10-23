@extends('layouts.app')

@section('content')
    <div class="container">
        <categories-list :categories='@json($categories)' />
    </div>
@endsection
<!-- Scripts -->
<script src="{{ asset('js/app.js') }}" defer></script>