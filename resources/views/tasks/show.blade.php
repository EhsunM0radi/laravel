@extends('layouts.app')

@section('title')
    "task {{}}"
@endsection

@section('content')
    @include('tasks.partials.show-task-form')
@endsection