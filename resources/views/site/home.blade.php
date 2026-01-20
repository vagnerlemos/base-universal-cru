@extends('site.layouts.app')

@section('title', 'Site — Home')

@section('content')
    <h1>Site Institucional</h1>

    <ul>
        <li>
            <a href="{{ url('/') }}">
                Home
            </a>
        </li>

        <li>
            <a href="{{ url('/sobre') }}">
                Sobre
            </a>
        </li>

        <li>
            <a href="{{ url('/contato') }}">
                Contato
            </a>
        </li>

        <li>
            <a href="{{ url('/system') }}">
                System
            </a>
        </li>

        <li>
            <a href="{{ url('/vendas') }}">
                Vendas
            </a>
        </li>
    </ul>
@endsection
