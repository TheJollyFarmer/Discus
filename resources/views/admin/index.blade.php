@extends('layouts.app')

@section('content')
  <admin-view
    :channels="{{ $channels }}"
    :threads="{{ $threads }}">
  </admin-view>
@endsection