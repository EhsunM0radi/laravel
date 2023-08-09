@extends('layouts.app')

@section('title')
    "Task {{$task->id}}"
@endsection

@section('content')
    @include('tasks.partials.show-task-form')
@endsection