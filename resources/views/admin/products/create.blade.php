@extends('admin.layouts.master')

@section('content')

<div class="page-title-box">
    <div class="row align-items-center">
        <div class="col-sm-6">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#" class="ic-javascriptVoid">{{ __('custom.product') }}</a></li>
                <li class="breadcrumb-item active">{{ __('custom.add_product') }}</li>
            </ol>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h4 class="header-title">{{ __('custom.add_product') }}</h4>
                <form class="form-validate edit-font" action="{{ route('admin.products.store') }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="row">

                        <div class="form-group col-sm-12">
                            <label for="">{{__('custom.name')}} <span class="error">*</span></label>
                            <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
                            @error('name')
                            <p class="error">{{ $message }}</p>
                            @enderror
                        </div>
                        {{-- barcode  --}}
                        <div class="form-group col-sm-6">
                            <label for="">{{__('custom.sku')}} <span class="error">*</span></label>
                            <input type="text"
                                   name="sku"
                                   class="form-control" value="{{ $skuSetting['auto'] == 'yes' ? $skuSetting['generated_sku'] : '' }}"
                                   {{ $skuSetting['editable'] == 'no' ? 'readonly' : '' }}
                                   required>
                            @error('sku')
                            <p class="error">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="form-group col-sm-6">
                            <label for="">{{__('custom.barcode')}}</label>
                            <div class="row">
                                <div class="col-sm-8">
                                    <input type="text" id="barcode" name="barcode" class="form-control"
                                        placeholder="Product Barcode" value="{{ $barcode }}">
                                    @error('barcode')
                                    <p class="error">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="col-sm-4">
                                    <img class="img-fluid max-width-50p barcode-image barcode-max-height"
                                        id="b-image-show" alt="barcode">
                                    <input id="barcode-value" type="hidden" name="barcode_image">
                                </div>
                            </div>
                        </div>
                        {{-- category --}}
                        <div class="form-group col-sm-6">
                            <label for="">{{__('custom.category')}} <span class="error">*</span></label>
                            <select name="category_id" class="form-control select2" required>
                                <option value="">{{ __('custom.select_category') }}</option>
                                @foreach ($categories as $item)
                                    <option {{ old('category_id') == $item->id ? 'selected' : '' }} value="{{ $item->id }}">{{ $item->name }}</option>
                                    @foreach ($item->subCategory as $subCategory)
                                        @include('admin.product_categories.child-categories', ['sub_category' => $subCategory])
                                    @endforeach
                                @endforeach
                            </select>
                            @error('category_id')
                            <p class="error">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- brand  --}}
                        <div class="form-group col-sm-6">
                            <label for="">{{__('custom.brand')}}</label>
                            <select name="brand_id" class="form-control select2">
                                <option value="">{{ __('custom.select_brand') }}</option>
                                @foreach ($brands as $item)
                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                                @endforeach
                            </select>
                            @error('brand_id')
                            <p class="error">{{ $message }}</p>
                            @enderror
                        </div>
                        {{-- Manufacturer  --}}
                        <input type="hidden" name="manufacturer_id" id="">
                        {{--
                        <div class="form-group col-sm-6">
                            <label for="">{{__('custom.manufacturer')}}</label>
                            <select name="manufacturer_id" class="form-control select2">
                                <option value="">{{ __('custom.select_manufacturer') }}</option>
                                @foreach ($manufacturers as $item)
                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                                @endforeach
                            </select>
                            @error('manufacturer_id')
                            <p class="error">{{ $message }}</p>
                            @enderror
                        </div> 
                        --}}

                        {{-- Quantity --}}
                        <input type="hidden" name="quantity" value="">
                        <!--<div class="form-group col-sm-6">-->
                        <!--    {{-- <label for="">{{__('custom.model')}}</label> --}}-->
                        <!--    <label for="">{{__('custom.quantity')}} <span class="error">*</span></label>-->
                        <!--    <input type="number" name="quantity" class="form-control" value="{{ old('quantity') }}" required>-->
                        <!--    @error('quantity')-->
                        <!--    <p class="error">{{ $message }}</p>-->
                        <!--    @enderror-->
                        <!--</div>-->
                        {{-- Price  --}}

                        <div class="form-group col-sm-6">
                            <label for="">{{__('custom.price')}}({{currencySymbol()}}) <span
                                    class="error">*</span></label>
                            <input type="number" name="price" class="form-control" value="{{ old('price') }}"
                                step="any">
                            @error('price')
                            <p class="error">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="form-group col-sm-6">
                            <label for="">{{__('custom.customer_buying_price')}}({{currencySymbol()}}) <small
                                    class="text-muted">({{ __('custom.if_blank_then_actual_price_will_be_buying_price') }})</small></label>
                            <input type="number" name="customer_buying_price" class="form-control" value="{{ old('customer_buying_price') }}"
                                   step="any">
                            @error('customer_buying_price')
                            <p class="error">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- weight/weight unit  --}}
                        <input type="hidden" name="weight" value="">
                        <input type="hidden" name="weight_unit_id" value="">

                        {{--

                        <div class="form-group col-sm-6">
                            <label for="">{{__('custom.weight')}}</label>
                            <input type="number" step="any" name="weight" class="form-control" value="{{ old('weight') }}" min="0">
                            @error('weight')
                            <p class="error">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="form-group col-sm-6">
                            <label for="">{{__('custom.weight_unit')}}</label>
                            <select name="weight_unit_id" class="form-control select2">
                                <option value="">{{ __('custom.select_weight_unit') }}</option>
                                @foreach ($weight_units as $item)
                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                                @endforeach
                            </select>
                            @error('weight_unit_id')
                            <p class="error">{{ $message }}</p>
                            @enderror
                        </div>

                        --}}

                        {{-- dimension  --}}
                        <input type="hidden" name="dimension_l" value="">
                        <input type="hidden" name="dimension_w" value="">
                        <input type="hidden" name="dimension_d" value="">


                        {{--

                        <div class="col-sm-12">
                            <label for="">{{ __('custom.dimension') }}</label>
                            <div class="row">
                                <div class="form-group col-sm-3">
                                    <label for="" class="text-muted">{{__('custom.length')}}</label>
                                    <input type="number" name="dimension_l" class="form-control" min="0" step="any"
                                        value="{{ old('dimension_l') }}">
                                    @error('dimension_l')
                                    <p class="error">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="form-group col-sm-3">
                                    <label for="" class="text-muted">{{__('custom.width')}}</label>
                                    <input type="number" name="dimension_w" class="form-control" min="0"
                                        value="{{ old('dimension_w') }}" step="any">
                                    @error('dimension_w')
                                    <p class="error">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="form-group col-sm-3">
                                    <label for="" class="text-muted">{{__('custom.depth')}}</label>
                                    <input type="number" name="dimension_d" class="form-control" min="0"
                                        value="{{ old('dimension_d') }}" step="any">
                                    @error('dimension_d')
                                    <p class="error">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="" class="">{{__('custom.measurement_unit')}}</label>
                                    <select name="measurement_unit_id" class="form-control select2">
                                        <option value="">{{ __('custom.select_measurement_unit') }}</option>
                                        @foreach ($measurement_units as $item)
                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('measurement_unit_id')
                                    <p class="error">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        --}}
                        {{-- measurement unit  --}}

                        <div class="form-group col-sm-6">
                            <label for="" class="">{{__('custom.measurement_unit')}}</label>
                            <select name="measurement_unit_id" class="form-control select2">
                                <option value="">{{ __('custom.select_measurement_unit') }}</option>
                                @foreach ($measurement_units as $item)
                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                                @endforeach
                            </select>
                            @error('measurement_unit_id')
                            <p class="error">{{ $message }}</p>
                            @enderror
                        </div>

                        
                        {{-- tax --}}
                        <div class="col-sm-12">
                            <label class="d-block mb-3">{{ __('custom.tax') }}</label>
                            <div class="row">
                                <div class="form-group col-sm-6">
                                    <div class="custom-control custom-radio custom-control-inline">
                                        <input type="radio" id="tax_include" value="{{ \App\Models\Product::TAX_INCLUDED }}"
                                            name="tax_status" class="custom-control-input" checked="">
                                        <label class="custom-control-label" for="tax_include">{{__('custom.include')}}</label>
                                    </div>
                                    <div class="custom-control custom-radio custom-control-inline">
                                        <input type="radio" id="tax_exclude" value="{{ \App\Models\Product::TAX_EXCLUDED }}"
                                            name="tax_status" class="custom-control-input">
                                        <label class="custom-control-label" for="tax_exclude">{{__('custom.exclude')}}</label>
                                    </div>
        
                                    @error('tax_exclude')
                                    <p class="error">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div id="sgst-tax" class="form-group col-sm-6">
                                    <label for="" class="text-muted">{{__('custom.sgst_tax_amount')}} (%)</label>
                                    <input type="number" name="sgst_tax" class="form-control" value="{{ old('sgst_tax') }}"
                                        min="0" step="any">
                                    @error('sgst_tax')
                                    <p class="error">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div id="igst-tax" class="form-group col-sm-6">
                                    <label for="" class="text-muted">{{__('custom.igst_tax_amount')}} (%)</label>
                                    <input type="number" name="igst_tax" class="form-control" value="{{ old('igst_tax') }}"
                                        min="0" step="any">
                                    @error('igst_tax')
                                    <p class="error">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        {{-- notes --}}
                        
                        <div class="form-group col-sm-12">
                            <label for="">{{__('custom.notes')}}</label>
                            <input type="text" name="notes" class="form-control" value="{{ old('notes') }}">
                            @error('notes')
                            <p class="error">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- thumb image  --}}

                        <div class="form-group col-sm-12">
                            <label for="">{{__('custom.thumb')}}</label>
                            <small class="font-12">{{ __('custom.image_support_message') }}</small>
                            <div class="form-group">
                                <input type="file" id="uploadFile" class="f-input form-control" name="thumb"
                                       value="{{ old('thumb') }}">
                            </div>
                            @error('thumb')
                            <p class="error">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- website-images  --}}
                        <div class="col-sm-12">
                            <label for="">{{__('custom.website_images')}}</label>
                            <small class="font-12">{{ __('custom.website_image_support_message') }}</small>
                            <div class="row">
                                <div class="form-group col-sm-4">
                                    <label for="" class="text-muted">{{__('custom.feature_image')}}</label>
                                    {{-- <small class="font-12">{{ __('custom.website_image_support_message') }}</small> --}}
                                    <div class="form-group">
                                        <input type="file" id="uploadFile0" class="f-input form-control" name="feature_image"
                                               value="{{ old('feature_image') }}">
                                    </div>
                                    @error('feature_image')
                                    <p class="error">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="form-group col-sm-4">
                                    <label for="" class="text-muted">{{__('custom.image_1')}}</label>
                                    <div class="form-group">
                                        <input type="file" id="uploadFile1" class="f-input form-control" name="image_1"
                                               value="{{ old('image_1') }}">
                                    </div>
                                    @error('image_1')
                                    <p class="error">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="form-group col-sm-4">
                                    <label for="" class="text-muted">{{__('custom.image_2')}}</label>
                                    <div class="form-group">
                                        <input type="file" id="uploadFile2" class="f-input form-control" name="image_2"
                                               value="{{ old('image_2') }}">
                                    </div>
                                    @error('image_2')
                                    <p class="error">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                           
                        {{-- Description  --}}

                        <div class="form-group col-sm-12">
                            <label for="">{{__('custom.desc')}}</label>
                            <textarea class="form-control summernote" name="desc">{{ old('desc')}}</textarea>
                            @error('desc')
                            <p class="error">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- tags --}}
                        <div class="col-sm-12">
                            <label for="">{{__('custom.tags')}}</label>
                            <div class="row">
                                <div class="form-group col-sm-4">
                                    <label for="" class="text-muted">{{__('custom.tag_1')}}</label>
                                    {{-- <small class="font-12">{{ __('custom.website_image_support_message') }}</small> --}}
                                    <div class="form-group">
                                        <input type="text" class="f-input form-control" name="tag_1"
                                               value="{{ old('tag_1') }}">
                                    </div>
                                    @error('tag_1')
                                    <p class="error">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="form-group col-sm-4">
                                    <label for="" class="text-muted">{{__('custom.tag_2')}}</label>
                                    {{-- <small class="font-12">{{ __('custom.website_image_support_message') }}</small> --}}
                                    <div class="form-group">
                                        <input type="text" class="f-input form-control" name="tag_2"
                                               value="{{ old('tag_2') }}">
                                    </div>
                                    @error('tag_2')
                                    <p class="error">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="form-group col-sm-4">
                                    <label for="" class="text-muted">{{__('custom.tag_3')}}</label>
                                    {{-- <small class="font-12">{{ __('custom.website_image_support_message') }}</small> --}}
                                    <div class="form-group">
                                        <input type="text" class="f-input form-control" name="tag_3"
                                               value="{{ old('tag_3') }}">
                                    </div>
                                    @error('tag_3')
                                    <p class="error">{{ $message }}</p>
                                    @enderror
                                </div>
                                
                            </div>
                        </div>



                        {{-- attributes --}}

                         <div class="col-sm-12">
                            <label for="">{{ __('custom.attributes') }}</label>
                            <product-attribute-add :attributes="{{ $attributes }}"></product-attribute-add>
                        </div>

                        {{-- status --}}

                        <div class="form-group col-sm-6">
                            <label class="d-block mb-3">{{ __('custom.status') }} <span class="error">*</span></label>
                            <div class="custom-control custom-radio custom-control-inline">
                                <input type="radio" id="status_yes" value="{{ \App\Models\Product::STATUS_ACTIVE }}"
                                    name="status" class="custom-control-input" checked="">
                                <label class="custom-control-label" for="status_yes">{{__('custom.active')}}</label>
                            </div>
                            <div class="custom-control custom-radio custom-control-inline">
                                <input type="radio" id="status_no" value="{{ \App\Models\Product::STATUS_INACTIVE }}"
                                    name="status" class="custom-control-input">
                                <label class="custom-control-label" for="status_no">{{__('custom.inactive')}}</label>
                            </div>

                            @error('status')
                            <p class="error">{{ $message }}</p>
                            @enderror

                            {{--
                            <label class="d-block mb-3 mt-3">{{ __('custom.available_for') }} <span class="error">*</span></label>

                            <div class="custom-control custom-radio custom-control-inline">
                                <input type="radio" id="available_for_customer" value="{{ \App\Models\Product::SALE_AVAILABLE_FOR['customer'] }}"
                                       name="available_for" class="custom-control-input">
                                <label class="custom-control-label" for="available_for_customer">{{__('custom.customer')}}</label>
                            </div>
                            <div class="custom-control custom-radio custom-control-inline">
                                <input type="radio" id="available_for_warehouse" value="{{ \App\Models\Product::SALE_AVAILABLE_FOR['warehouse'] }}"
                                       name="available_for" class="custom-control-input">
                                <label class="custom-control-label" for="available_for_warehouse">{{__('custom.warehouse')}}</label>
                            </div>
                            <div class="custom-control custom-radio custom-control-inline">
                                <input type="radio" id="available_for_all" value="{{ \App\Models\Product::SALE_AVAILABLE_FOR['all'] }}"
                                       name="available_for" class="custom-control-input" checked="">
                                <label class="custom-control-label" for="available_for_all">{{__('custom.both')}}</label>
                            </div>

                            @error('available_for')
                            <p class="error">{{ $message }}</p>
                            @enderror


                            <div class="custom-control custom-checkbox">
                                <label for="" class=" "></label><br>
                                <input class="form-check-input custom-control-input" type="checkbox" value="1"
                                    id="isVariant" name="is_variant">
                                <label class="form-check-label custom-control-label checkbox-label" for="isVariant">
                                    {{ __('custom.is_variant_product')}}
                                </label>
                            </div>

                            @error('is_variant')
                            <p class="error">{{ $message }}</p>
                            @enderror

                            <div class="custom-control custom-checkbox">
                                <label for="" class=" "></label><br>
                                <input class="form-check-input custom-control-input" type="checkbox" value="1"
                                       id="split_sale" name="split_sale">
                                <label class="form-check-label custom-control-label checkbox-label" for="split_sale">
                                    {{ __('custom.is_split_sale')}}
                                </label>
                            </div>

                            --}}
                        </div>
                    </div>
                    <div class="form-group">
                        <div>
                            <button class="btn btn-primary waves-effect waves-lightml-2" type="submit">
                                <i class="fa fa-save"></i> <span>{{ __('custom.submit') }}</span>
                            </button>

                             <input type="hidden" id="is_submit_with_stock" name="is_submit_with_stock">
                             <button class="btn btn-info waves-effect waves-lightml-2" type="submit" id="submit_with_stock">
                                <i class="fa fa-save"></i> <span>{{ __('custom.submit_with_stock') }}</span>
                            </button>
                            <a class="btn btn-danger waves-effect" href="{{ route('admin.products.index') }}">
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

@push('script')-

@endpush
