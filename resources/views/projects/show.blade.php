@extends('layouts.app')

@section('content')
    <style>
        .full-window-iframe {
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            border: none;
            z-index: 9999;
        }
        body {
            overflow: hidden;
        }
    </style>

    <iframe src="{{ asset('storage/projects/project_' . $project->id . '/index.html') }}"
            class="full-window-iframe"></iframe>
@endsection
