@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                
                <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data">
                    @csrf
                
                <div class="card-header">{{ __('Register As:') }}
                    
                <!-- User Type -->
                <div class="row mb-3">
                    <label for="type" class="col-md-4 col-form-label text-md-end">{{ __('User Type') }}</label>

                    <div class="col-md-6">
                        <select id="type" class="form-control @error('type') is-invalid @enderror" name="type" required onchange="toggleBusinessPermitSection(this.value)">
                            <option value="business" {{ old('type') == 'business' ? 'selected' : '' }}>Business</option>
                            <option value="user" {{ old('type') == 'user' ? 'selected' : '' }}>User</option>
                        </select>

                        @error('type')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                </div>

                <div class="card-body">
                    

                        <div class="row mb-3">
                            <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('Name') }} of account</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-end">{{ __('Confirm Password') }}</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>
                            
                        
                        <!-- Image Upload -->
                        <div class="row mb-3" id="business_permit_section" style="display: {{ old('type') == 'user' ? 'none' : 'block' }}">
                            <label for="image" class="col-md-4 col-form-label text-md-end">{{ __('Upload Business Permit') }}</label>

                            <div class="col-md-6">
                                <input id="image" type="file" class="form-control @error('image') is-invalid @enderror" name="image" value="{{ old('image') }}" required>
                                
                                @error('image')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Register') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

<script>
    function toggleBusinessPermitSection(userType) {
    var businessPermitSection = document.getElementById('business_permit_section');
    var imageInput = document.getElementById('image');

    if (userType === 'user') {
        businessPermitSection.style.display = 'none';
        imageInput.removeAttribute('required');
    } else {
        businessPermitSection.style.display = 'block';
        imageInput.setAttribute('required', 'required');
    }
}


</script>
