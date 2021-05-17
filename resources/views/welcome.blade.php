@extends('layouts.app')
@section('content')

    <navbar-component></navbar-component>
    <div class="container pt-5 pb-4">
        <router-view></router-view>
    </div>
    <footer-component></footer-component>

@endsection