@extends('layouts.app')

@section('title')
    "edit project {{}}"
@endsection

@section('content')
    @include('projects.partials.edit-project-form')
@endsection