@extends('layouts.app')

@section('content')

@include('contacts._form', [
    'company' => $company,
    'contact' => null,
    'title' => 'Tambah Kontak',
    'action' => route('companies.contacts.store', $company),
    'method' => 'POST'
])

@endsection