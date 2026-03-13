@extends('adminlte::layouts.fixed-sidebar')

@section('title', 'Administration')

{{-- Navbar --}}
@section('content_header')
    <h1>@yield('page-title', 'Dashboard')</h1>
@stop

{{-- Sidebar dynamique selon le rôle --}}
@section('sidebar')
    @php
        $role = auth()->user()->role ?? 'stagiaire';
    @endphp

    @if($role === 'admin')
        @include('layouts.partials.sidebar-admin')
    @elseif($role === 'agent')
        @include('layouts.partials.sidebar-agent')
    @elseif($role === 'responsable')
        @include('layouts.partials.sidebar-responsable')
    @else
        @include('layouts.partials.sidebar-stagiaire')
    @endif
@stop

