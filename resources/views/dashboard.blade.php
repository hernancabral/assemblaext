@extends('layouts.main')

@section('content')

<div class="jumbotron">
    <h1>Dashboard</h1>
</div>

<div class="container">
    <div class="row p-1">

    <a href="/users">
    <button type="button" class="btn btn-primary">Lista Usuarios</button>
    </a>

    <a href="tag">
    <button type="button" class="btn btn-primary">Lista Tags</button>
    </a>

    <a href="brand">
    <button type="button" class="btn btn-primary">Lista Brands</button>
    </a>

    <a href="milestone">
    <button type="button" class="btn btn-primary">Lista Milestones</button>
    </a>
    </div>
</div>

@endsection