@extends('admin.layouts.header')

@section('title', 'Add Article')
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
                                            <h5 class="pt-2 pb-2">@if(isset($article->id)) Edit @else Add @endif Article</h5>
                                        </div>
                                        <div class="col-12 col-sm-5 d-flex justify-content-end align-items-center">
                                            <a href="{{route('admin.master.article.index')}}" class="btn btn-sm btn-primary px-3 py-1">
                                                <i class="fa fa-arrow-left"></i> Back </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="row justify-content-center"> <!-- Center the row -->
                                        <div class="col-sm-6">
                                            <form method="post" action="{{route('admin.master.article.store')}}">
                                                @csrf
                                                <input type="hidden" name="id" value="{{$article->id ?? null}}">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <label for="article_type_id">Article Flag:</label>
                                                        <input type="text" name="name" class="form-control" placeholder="Enter Article" value="@if(isset($article->id)){{$article->name}}@else{{old('name')}}@endif" required data-validation-required-message="Name field is required">
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label for="article_type_id">Article Type:</label>
                                                        <select name="article_type_id" id="article_type_id" class="form-control" required data-validation-required-message="Article Type field is required">
                                                            <option value="">Select Status</option>
                                                            @foreach($articleTypes as $value => $label)
                                                            <option value="{{ $value }}" {{ isset($article->article_type_id) && $article->article_type_id == $value ? 'selected' : '' }}>{{ $label }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-12 mt-2">
                                                        <label for="description">Description:</label>
                                                        <textarea id="description" name="description" class="form-control" rows="4">@if(isset($article->id)){{ $article->description }}@else{{ old('description') }}@endif</textarea>
                                                    </div>
                                                </div>

                                                <button type="submit" class="btn btn-primary mt-3">Save</button>
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