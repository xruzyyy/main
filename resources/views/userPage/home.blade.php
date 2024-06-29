@extends('layouts.userHome')

@section('contentUserHome')
@include('userPage.section1User')
@include('business-section.business-section-category')
@include('business-section.business-section-post')
@include('business-section.postsFeatured')
@include('userPage.aboutUser')
@include('userPage.servicesUser')
@include('footer')
@endsection
