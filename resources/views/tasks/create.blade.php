@extends('layouts.app')

@section('title')
    "Create Task"
@endsection

@section('content')
    @include('tasks.partials.create-task-form')
@endsection