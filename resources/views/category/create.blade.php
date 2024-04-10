@extends('layouts.master')

@section('categoriesCreate')
<div class="container mx-auto p-5">
    <div class="row">
        <div class="col-md-12">

          @if (session('status'))
          <div class="alert alert-success">{{session ('status')}}</div>
          @endif

            <div class="card">
              <div class="card-header">
                <h4>Add Business
                  <a href="{{ url('categories') }}" class="btn btn-primary float-end">Back</a>
                </h4>
              </div>

              <div class="card-body">
                  <form action="{{ url('categories/create') }}" method="POST" enctype="multipart/form-data">
                      @csrf
                      <div class="mb-3">
                          <label>Business Name:</label>
                          <input type="text" name="businessName" value={{old('businessName')}}>
                          @error('businessName') <span class="text-danger"> {{$message}} </span>  @enderror
                      </div>

                      <div class="mb-3">
                          <label>Description:</label>
                          <textarea name="description" class="form-control" rows="3"> {{ old('description') }}</textarea>
                          @error('description') <span class="text-danger"> {{ $message }} </span>  @enderror

                      </div>

                      {{-- <div class="mb-3">
                          <label>Is Active</label>
                          <input type="checkbox" name="is_active" {{old('is_active')  == true ? 'checked':'' }} />
                          @error('is_active') <span class="text-danger"> {{ $message }} </span>  @enderror
                      </div> --}}

                      <div class="mb-3">
                          <label>Upload Business Permit</label>
                          <input type="file" name="image" class="form-control" value={{old('businessName')}}>
                          @error('image') <span class="text-danger"> {{ $message }} </span>  @enderror

                      </div>

                      <div class="mb-3">
                          <button type="submit" class="btn btn-primary">Save</button>
                      </div>
                  </form>
              </div>
            </div>
        </div>
    </div>
</div>

@endsection
