@extends('layouts.app')

@section('title', 'Detail Goal')

@section('content')

<div class="bg-white rounded-xl shadow p-6">

    <h1 class="text-3xl font-bold">

        {{ $goal->title }}

    </h1>

    <div class="mt-4 space-y-2">

        <p>
            Status:
            <strong>{{ $goal->status }}</strong>
        </p>

        <p>
            Target:
            {{ $goal->target_application_count }}
        </p>

        <p>
            Progress:
            {{ $goal->current_count }}
        </p>

        <p>
            Deadline:
            {{ $goal->deadline }}
        </p>

    </div>

</div>

@endsection