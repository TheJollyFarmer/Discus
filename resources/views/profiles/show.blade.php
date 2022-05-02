@extends('layouts.app')

@section('content')
    <profile-view :user="{{ $profileUser }}"></profile-view>
@endsection
