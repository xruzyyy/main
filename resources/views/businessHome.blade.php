@extends('layouts.businessHome')

@section('content')
    @include('business-section.business-section-category')
    @include('business-section.business-section-post')
    @include('about')
    @include('servicesMain')

    @endsection
