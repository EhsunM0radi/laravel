@extends('layouts.app')

@section('title')
    "Project {{$project->id}}"
@endsection

@section('content')
    @include('projects.partials.show-project-form')
@endsection