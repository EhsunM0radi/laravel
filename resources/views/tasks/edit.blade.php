@extends('layouts.app')

@section('title')
    "Edit Task {{$task->id}}"
@endsection

@section('content')
    @include('tasks.partials.edit-task-form')
@endsection