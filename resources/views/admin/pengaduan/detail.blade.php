@extends('layouts.admin')

@section('title', 'Detail Pengaduan')

@section('content')
    @livewire('admin.pengaduan-detail', ['id' => $id])
@endsection
