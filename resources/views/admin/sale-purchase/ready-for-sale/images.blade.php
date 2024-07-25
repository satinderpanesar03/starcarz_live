@extends('admin.layouts.header')
@section('title', 'Add Images')
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
                                                <h5 class="pt-2 pb-2 font-weight-bold">Add Images </h5>
                                            </div>
                                            <div class="col-12 col-sm-5 d-flex justify-content-end align-items-center">
                                                <a href="{{ route('admin.purchase.purchase.orders') }}"
                                                    class="btn btn-sm btn-primary px-3 py-1">
                                                    <i class="fa fa-arrow-left"></i> Back </a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <form method="post"
                                                    action="{{ route('admin.purchase.purchase.ready-sale-add-image-store') }}"
                                                    enctype="multipart/form-data">
                                                    @csrf
                                                    <input type="hidden" name="purchase_id" value="{{ $id }}">

                                                    <!-- Front Image -->
                                                    <div class="form-group row mb-3">
                                                        <div class="col-sm-2">
                                                            <label for="front"
                                                                class="col-sm-5 col-form-label font-weight-bold">Front
                                                                Image:</label>
                                                        </div>
                                                        <div class="col-sm-2">
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="file"
                                                                    id="front" name="front[]" multiple>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-8">
                                                            @if (isset($image['front']) && $image['front'] != "")
                                                            <div class="row">
                                                                @foreach (explode(',', $image['front']) as $img)
                                                                    <div class="col-sm-3 mb-3">
                                                                        <div class="image-item position-relative">
                                                                            <a href="#" class="image-link">
                                                                                <img src="{{ asset('storage/purchased/' . $img) }}" class="img-fluid" alt="Front Image">
                                                                            </a>
                                                                        </div>
                                                                        <div class="mt-1">
                                                                            <a href="#" class="delete_button"
                                                                               data-img-name="{{ $img }}"
                                                                               data-type="front"
                                                                               data-purchase-id={{$id}}
                                                                               data-confirm="Delete confirmation ?">
                                                                                <button class="btn btn-sm btn-danger"><i class="fa fa-trash" aria-hidden="true"></i></button>
                                                                            </a>
                                                                        </div>
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                        @endif
                                                        </div>

                                                    </div>
                                                    <hr>
                                                    <!-- Side Image -->
                                                    <div class="form-group row mb-3">
                                                        <div class="col-sm-2">
                                                            <label for="side"
                                                                class="col-sm-5 col-form-label font-weight-bold">Side
                                                                Image:</label>
                                                        </div>
                                                        <div class="col-sm-2">
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="file"
                                                                    id="side" name="side[]" multiple>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-8">
                                                            @if (isset($image['side']) && $image['side'] != "")
                                                            <div class="row">
                                                                @foreach (explode(',', $image['side']) as $img)
                                                                    <div class="col-sm-3 mb-3">
                                                                        <div class="image-item position-relative">
                                                                            <a href="#" class="image-link">
                                                                                <img src="{{ asset('storage/purchased/' . $img) }}" class="img-fluid" alt="Side Image">
                                                                            </a>
                                                                        </div>
                                                                        <div class="mt-1">
                                                                            <a href="#" class="delete_button"
                                                                               data-img-name="{{ $img }}"
                                                                               data-type="side"
                                                                               data-purchase-id={{$id}}
                                                                               data-confirm="Delete confirmation ?">
                                                                                <button class="btn btn-sm btn-danger"><i class="fa fa-trash" aria-hidden="true"></i></button>
                                                                            </a>
                                                                        </div>
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                        @endif
                                                        </div>
                                                    </div>
                                                    <hr>
                                                    <!-- Back Image -->
                                                    <div class="form-group row mb-3">
                                                        <div class="col-sm-2">
                                                            <label for="back"
                                                                class="col-sm-5 col-form-label font-weight-bold">Back
                                                                Image:</label>
                                                        </div>
                                                        <div class="col-sm-2">
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="file"
                                                                    id="back" name="back[]" multiple>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-8">
                                                            @if (isset($image['back']) && $image['back'] != "")
                                                            <div class="row">
                                                                @foreach (explode(',', $image['back']) as $img)
                                                                    <div class="col-sm-3 mb-3">
                                                                        <div class="image-item position-relative">
                                                                            <a href="#" class="image-link">
                                                                                <img src="{{ asset('storage/purchased/' . $img) }}" class="img-fluid" alt="Back Image">
                                                                            </a>
                                                                        </div>
                                                                        <div class="mt-1">
                                                                            <a href="#" class="delete_button"
                                                                               data-img-name="{{ $img }}"
                                                                               data-type="back"
                                                                               data-purchase-id={{$id}}
                                                                               data-confirm="Delete confirmation ?">
                                                                                <button class="btn btn-sm btn-danger"><i class="fa fa-trash" aria-hidden="true"></i></button>
                                                                            </a>
                                                                        </div>
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                        @endif
                                                        </div>
                                                    </div>
                                                    <hr>
                                                    <!-- Interior Image -->
                                                    <div class="form-group row mb-3">
                                                        <div class="col-sm-2">
                                                            <label for="interior"
                                                                class="col-sm-6 col-form-label font-weight-bold">Interior
                                                                Image:</label>
                                                        </div>
                                                        <div class="col-sm-2">
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="file"
                                                                    id="interior" name="interior[]" multiple>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-8">
                                                            @if (isset($image['interior']) && $image['interior'] != "")
                                                            <div class="row">
                                                                @foreach (explode(',', $image['interior']) as $img)
                                                                    <div class="col-sm-3 mb-3">
                                                                        <div class="image-item position-relative">
                                                                            <a href="#" class="image-link">
                                                                                <img src="{{ asset('storage/purchased/' . $img) }}" class="img-fluid" alt="Interior Image">
                                                                            </a>
                                                                        </div>
                                                                        <div class="mt-1">
                                                                            <a href="#" class="delete_button"
                                                                               data-img-name="{{ $img }}"
                                                                               data-type="interior"
                                                                               data-purchase-id={{$id}}
                                                                               data-confirm="Delete confirmation ?">
                                                                                <button class="btn btn-sm btn-danger"><i class="fa fa-trash" aria-hidden="true"></i></button>
                                                                            </a>
                                                                        </div>
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                        @endif
                                                        </div>
                                                    </div>
                                                    <hr>
                                                    <!-- Tyre Image -->
                                                    <div class="form-group row mb-3">
                                                        <div class="col-sm-2">
                                                            <label for="tyre"
                                                                class="col-sm-5 col-form-label font-weight-bold">Tyre
                                                                Image:</label>
                                                        </div>
                                                        <div class="col-sm-2">
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="file"
                                                                    id="tyre" name="tyre[]" multiple>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-8">
                                                            @if (isset($image['tyre']) && $image['tyre'] != "")
                                                            <div class="row">
                                                                @foreach (explode(',', $image['tyre']) as $img)
                                                                    <div class="col-sm-3 mb-3">
                                                                        <div class="image-item position-relative">
                                                                            <a href="#" class="image-link">
                                                                                <img src="{{ asset('storage/purchased/' . $img) }}" class="img-fluid" alt="tyre Image">
                                                                            </a>
                                                                        </div>
                                                                        <div class="mt-1">
                                                                            <a href="#" class="delete_button"
                                                                               data-img-name="{{ $img }}"
                                                                               data-type="tyre"
                                                                               data-purchase-id={{$id}}
                                                                               data-confirm="Delete confirmation ?">
                                                                                <button class="btn btn-sm btn-danger"><i class="fa fa-trash" aria-hidden="true"></i></button>
                                                                            </a>
                                                                        </div>
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                        @endif
                                                        </div>
                                                    </div>

                                                    <button type="submit" id="save_button"
                                                        class="btn btn-primary mt-3">Save</button>
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

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script>
    $(document).ready(function() {
        $('.delete_button').on('click', function(e) {
            e.preventDefault();

            var imgName = $(this).data('img-name');
            var type = $(this).data('type');
            var purchase_id = $(this).data('purchase-id');
            var confirmMessage = $(this).data('confirm');

            if (confirm(confirmMessage)) {
                $.ajax({
                    url: '{{ route('admin.purchase.remove.images') }}',
                    type: 'POST',
                    data: {
                        '_token': '{{ csrf_token() }}',
                        'img_name': imgName,
                        'type': type,
                        'purchase_id': purchase_id,
                    },
                    success: function(response) {
                        console.log('Image deleted successfully');
                        $(e.target).closest('.col-sm-3').remove();
                    },
                    error: function(xhr, status, error) {
                        console.error('Error deleting image:', error);
                    }
                });
            }
        });
    });
</script>
