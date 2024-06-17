@extends('layouts.businessHome')

@section('content')
    @include('business-section.section1')
    @include('business-section.business-section-category')
    @include('business-section.business-section-post')
    @include('business-section.postsFeatured')
    @include('business-section.aboutBusiness')
    @include('business-section.servicesMainBusiness')
    @include('footer')
@endsection
