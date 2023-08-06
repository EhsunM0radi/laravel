@extends('layouts.app')

@section('title')
    "task {{}}"
@endsection

@section('content')
    @include('tasks.partials.create-task-form')
@endsection