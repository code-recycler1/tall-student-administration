@extends('errors::minimal')

@section('title', __('Not Found'))
@section('code', '404')
@section('message', __('Not Found'))

@push('script')
    <script>
        document.querySelector('header nav  div:last-child').remove();
    </script>
@endpush
