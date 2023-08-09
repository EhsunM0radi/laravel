@extends('layouts.app')

@section('title')
    "Edit Project {{$project->id}}"
@endsection

@section('content')
    @include('projects.partials.edit-project-form')
@endsection