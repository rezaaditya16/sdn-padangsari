@extends('layouts.admin')

@section('title', 'Response Pengaduan')

@section('content')
    @livewire('admin.response-pengaduan', ['pengaduanId' => $id])
@endsection
