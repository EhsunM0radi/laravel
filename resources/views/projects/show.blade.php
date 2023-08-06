@extends('layouts.app')

@section('title')
    "project {{}}"
@endsection

@section('content')
    @include('projects.partials.show-project-form')
@endsection