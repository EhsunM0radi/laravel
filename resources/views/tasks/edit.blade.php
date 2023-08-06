@extends('layouts.app')

@section('title')
    "task {{}}"
@endsection

@section('content')
    @include('task.partials.edit-task-form')
@endsection