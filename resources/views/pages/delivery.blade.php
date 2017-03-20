@extends('layouts.app')
@section('title') Home :: @parent @endsection
@section('content')
<div class="row">
    <div class="page-header">
        <h2>Token delivery</h2>
    </div>
</div>

@if(count($errors)>0)
<div class="row">
    <h2>Errors</h2>
    @foreach ($errors as $error)
    <div class="col-md-6">
        <div class="row">
            <div class="col-md-8">
                <h4>
                    {{$error}}
                </h4>
            </div>
        </div>
    </div>
    @endforeach
</div>
@else
    <div class="row">
        <div class="col-md-6">
            {{$token->}}
        </div>
        <div class="col-md-6">
        </div>
    </div>
@endif

@endsection

