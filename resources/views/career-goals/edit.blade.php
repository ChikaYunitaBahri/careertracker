@extends('layouts.app')

@section('title', 'Edit Goal')

@section('content')

<div class="max-w-3xl mx-auto">

    <div class="bg-white p-6 rounded-xl shadow">

        <h1 class="text-2xl font-bold mb-6">
            Edit Goal
        </h1>

        <form
            action="{{ route('career-goals.update',$goal) }}"
            method="POST">

            @csrf
            @method('PUT')

            @include('career-goals.form')

            <button
                class="mt-6 bg-blue-600 text-white px-5 py-2 rounded-lg">

                Update

            </button>

        </form>

    </div>

</div>

@endsection