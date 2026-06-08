@extends('layouts.app')

@section('title', 'Tambah Career Goal')

@section('content')

<div class="max-w-3xl mx-auto">

    <div class="bg-white p-6 rounded-xl shadow">

        <h1 class="text-2xl font-bold mb-6">
            Tambah Career Goal
        </h1>

        <form
            action="{{ route('career-goals.store') }}"
            method="POST">

            @csrf

            @include('career-goals.form')

            <button
                class="mt-6 bg-blue-600 text-white px-5 py-2 rounded-lg">

                Simpan

            </button>

        </form>

    </div>

</div>

@endsection