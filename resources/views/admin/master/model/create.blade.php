@extends('admin.layouts.header')
@section('title', isset($model->id) ? 'Edit Model' : 'Add Model')
@section('content')
<div class="main-panel">
    <!-- BEGIN : Main Content-->
    <div class="main-content">
        <div class="content-overlay"></div>
        <div class="content-wrapper">
            <section id="simple-validation">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-content">
                                <div class="card-header" style="background-color: #d6d6d6; color: #000000;  z-index: 1;">
                                    <div class="row">
                                        <div class="col-12 col-sm-7">
                                            <h5 class="pt-2 pb-2">@if(isset($model->id)) Edit @else Add @endif Model</h5>
                                        </div>
                                        <div class="col-12 col-sm-5 d-flex justify-content-end align-items-center">
                                            <a href="{{route('admin.master.model.index')}}" class="btn btn-sm btn-primary px-3 py-1">
                                                <i class="fa fa-arrow-left"></i> Back </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="row justify-content-center"> <!-- Center the row -->
                                        <div class="col-sm-6">
                                            <form method="post" action="{{route('admin.master.model.store')}}">
                                                @csrf
                                                <input type="hidden" name="id" value="{{$model->id ?? null}}">

                                                <fieldset class="form-group">
                                                    <select class="form-control" name="mst_brand_type_id" id="basicSelect">
                                                        <option disabled selected>Select Vehicle Brand</option>
                                                        @foreach($brands as $brand)
                                                        <option @if(isset($model->brand->id)) {{ $brand->id === $model->brand->id ? 'selected' : '' }} @endif value="{{$brand->id}}">{{$brand->type}}</option>
                                                        @endforeach
                                                    </select>
                                                </fieldset>

                                                <div class="form-group">
                                                    <input type="text" name="model" class="form-control" placeholder="Enter Vehicle Model" value="@if(isset($model->id)){{$model->model}}@else{{old('model')}}@endif" required data-validation-required-message="This First Name field is required">
                                                </div>
                                                <fieldset class="form-group">
                                                    <select class="form-control" name="luxury" id="luxury">
                                                        <option value="" selected disabled>Choose...</option>
                                                        <option value="1" {{ isset($model) && $model->luxury == '1' ? 'selected' : '' }}>Luxury</option>
                                                        <option value="2" {{ isset($model) && $model->luxury == '2' ? 'selected' : '' }}>Not Luxury</option>
                                                    </select>
                                                </fieldset>
                                                <button type="submit" class="btn btn-primary">Save</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>

</div>
@endsection

@push('scripts')
<script>
    $(document).ready(() => {
        $('select').selectize();
    });
</script>
@endpush