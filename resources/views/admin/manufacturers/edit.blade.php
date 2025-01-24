@extends('admin.layouts.master')

@section('content')

<div class="page-title-box">
    <div class="row align-items-center">
        <div class="col-sm-6">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#" class="ic-javascriptVoid">{{ __('custom.manufacturer') }}</a>
                </li>
                <li class="breadcrumb-item active">{{ __('custom.edit_manufacturer') }}</li>
            </ol>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h4 class="header-title">{{ __('custom.edit_manufacturer') }}</h4>
                <form class="form-validate" action="{{ route('admin.manufacturers.update', $manufacturer->id) }}"
                    method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="form-group col-sm-6">
                            <label for="">{{__('custom.manufacturer_name')}} <span class="error">*</span></label>
                            <input type="text" name="name" class="form-control" value="{{ $manufacturer->name }}"
                                required>
                            @error('name')
                            <p class="error">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="form-group col-sm-6">
                            <label for="">{{__('custom.desc')}}</label>
                            <input type="text" name="desc" class="form-control" value="{{ $manufacturer->desc }}">
                            @error('desc')
                            <p class="error">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="form-group col-sm-6">
                            <label for="">{{__('custom.image')}}</label>
                            <small>{{ __('custom.image_support_message') }}</small>
                            <div class="row">
                                <div class="col-sm-8">
                                    <div class="form-group">
                                        <input type="file" id="uploadFile" class="f-input form-control" name="image"
                                            value="{{ old('image') }}">
                                    </div>
                                    @error('image')
                                    <p class="error">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="col-sm-4">
                                    <img class="img-32" src="{{ $manufacturer->file_url }}" alt="image" />
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="d-block mb-3">{{ __('custom.status') }} <span class="error">*</span></label>
                            <div class="custom-control custom-radio custom-control-inline">
                                <input type="radio" id="status_yes" value="{{ \App\Models\Brand::STATUS_ACTIVE }}"
                                    name="status" class="custom-control-input"
                                    @if(\App\Models\Brand::STATUS_ACTIVE==$manufacturer->status) checked @endif>
                                <label class="custom-control-label" for="status_yes">{{ __('custom.active') }}</label>
                            </div>
                            <div class="custom-control custom-radio custom-control-inline">
                                <input type="radio" id="status_no" value="{{ \App\Models\Brand::STATUS_INACTIVE }}"
                                    name="status" class="custom-control-input"
                                    @if(\App\Models\Brand::STATUS_INACTIVE==$manufacturer->status) checked @endif>
                                <label class="custom-control-label" for="status_no">{{ __('custom.inactive') }}</label>
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
                            <a class="btn btn-danger waves-effect" href="{{ route('admin.manufacturers.index') }}">
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

@endpush