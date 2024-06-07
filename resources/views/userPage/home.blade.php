@extends('layouts.userHome')

@section('contentUserHome')
@include('userPage.section1User')
@include('business-section.business-section-category')
@include('business-section.postsFeatured')
@include('business-section.business-section-post')
@include('userPage.aboutUser')
@include('userPage.servicesUser')
@include('footer')
@endsection
