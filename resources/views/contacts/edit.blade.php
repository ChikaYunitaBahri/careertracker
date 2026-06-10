@extends('layouts.app')

@section('content')

@include('contacts._form', [
    'company' => $company,
    'contact' => $contact,
    'title' => 'Edit Kontak',
    'action' => route(
        'companies.contacts.update',
        [$company, $contact]
    ),
    'method' => 'PUT'
])

@endsection