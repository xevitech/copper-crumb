@extends('admin.layouts.master')

@section('content')

<div class="page-title-box">
    <div class="row align-items-center">
        <div class="col-sm-6">

            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#" class="ic-javascriptVoid">{{ __('custom.blogs') }}</a></li>
                <li class="breadcrumb-item active">{{ __('custom.edit_blog') }}</li>
            </ol>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h4 class="header-title">{{ __('custom.edit_blog') }}</h4>
                <form class="form-validate" action="{{ route('admin.blogs.update', $blog->id) }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="form-group col-sm-6">
                            <label for="">{{__('custom.blog_title')}} <span class="error">*</span></label>
                            <input type="text" name="title" class="form-control" value="{{ old('title',$blog->title) }}" required>
                            @error('title')
                            <p class="error">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div class="form-group col-sm-6">
                            <label for="">{{__('custom.banner')}}</label>
                            <small>{{ __('custom.blog_image_support_message') }}</small>
                            <div class="row">
                                <div class="col-lg-8 col-md-12 col">
                                    <div class="form-group">
                                        <input type="file" id="uploadFile" class="f-input form-control image_pick" data-image-for="banner" name="banner"
                                               value="{{ old('banner') }}">
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-6">
                                    <img class="img-64 mt-3 mt-md-3 default-image-size" src="{{ $blog->banner_url }}" id="img_banner" alt="avatar" />
                                </div>
                            </div>
                            @error('banner')
                            <p class="error">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="form-group col-sm-12">
                            <label for="description">{{ __('custom.blog_description') }} <span class="error">*</span></label>
                            <textarea id="myeditor" name="description" class="form-control">{{ old('description',$blog->description) }}</textarea>
                            @error('description')
                                <p class="error">{{ $message }}</p>
                            @enderror
                        </div>


                        <div class="form-group col-sm-6">
                            <label class="d-block mb-3">{{ __('custom.status') }} <span class="error">*</span></label>
                            <div class="custom-control custom-radio custom-control-inline">
                                <input type="radio" {{ old('status',$blog->status) == \App\Models\Blog::STATUS_ACTIVE ? 'checked' : '' }} id="status_yes" value="{{ \App\Models\Blog::STATUS_ACTIVE }}"
                                       name="status" class="custom-control-input" >
                                <label class="custom-control-label" for="status_yes">{{__('custom.active')}}</label>
                            </div>
                            <div class="custom-control custom-radio custom-control-inline">
                                <input type="radio" {{ old('status',$blog->status) == \App\Models\Blog::STATUS_INACTIVE ? 'checked' : '' }} id="status_no" value="{{ \App\Models\Blog::STATUS_INACTIVE }}"
                                       name="status" class="custom-control-input">
                                <label class="custom-control-label" for="status_no">{{__('custom.inactive')}}</label>
                            </div>

                            @error('status')
                            <p class="error">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>



                    <div class="form-group">
                        <div>
                            <button class="btn btn-primary waves-effect waves-lightml-2" type="submit">
                                <i class="fa fa-save"></i> <span>{{ __('custom.submit') }}</span>
                            </button>
                            <a class="btn btn-danger waves-effect" href="{{ route('admin.blogs.index') }}">
                                <i class="fa fa-times"></i> <span>{{ __('custom.cancel') }}</span>
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@push('style')
@endpush

@push('script')
<script src="{{ asset('admin/ckeditor/ckeditor.js') }}"></script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        if (document.getElementById('myeditor')) {
            CKEDITOR.replace('myeditor');
        }
    });
</script>
@endpush
