@extends('admin.layouts.header')
@section('title', isset($refurbishment->id) ? 'Edit Refurbnishment' : 'Add Refurbnishment')
@section('content')
<div class="main-panel">
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
                                            <h5 class="pt-2 pb-2">@if(isset($refurbishment->id)) Edit @else Add @endif Refurbishment</h5>
                                        </div>
                                        <div class="col-12 col-sm-5 d-flex justify-content-end align-items-center">
                                            <a href="{{route('admin.refurbishment.index')}}" class="btn btn-sm btn-primary px-3 py-1">
                                                <i class="fa fa-arrow-left"></i> Back </a>
                                        </div>
                                    </div>
                                </div>

                                <div class="card-body">
                                    <div class="row justify-content-center"> <!-- Center the row -->
                                        <div class="col-sm-12">
                                            <form method="post" action="{{route('admin.refurbishment.store')}}">
                                                @csrf
                                                <input type="hidden" name="id" value="{{$refurbishment->id ?? null}}">
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <label for="voucher_date">Voucher Date:</label>
                                                        <input type="date" id="voucher_date" name="voucher_date" class="form-control" value="{{ isset($refurbishment) ? \Carbon\Carbon::parse($refurbishment->voucher_date)->format('Y-m-d') : old('voucher_date') }}">
                                                    </div>
                                                </div>
                                                
                                                <div class="row">
                                                    <div class="col">
                                                        <button id="add-section-btn" class="btn btn-primary float-right mt-3">+</button>
                                                    </div>
                                                </div>
                                                <div id="sections">
                                                    <div class="row section">
                                                        <div class="col-md-3 mt-3">
                                                            <label for="mst_model_id">Model:</label>
                                                            <select name="mst_model_id" id="mst_model_id" class="form-control">
                                                                <option value="">Choose...</option>
                                                                @foreach($models as $value => $label)
                                                                <option value="{{ $value }}" {{ isset($refurbishment->mst_model_id) && $refurbishment->mst_model_id == $value ? 'selected' : '' }}>{{ $label }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="col-md-3 mt-3">
                                                            <label for="registration_number">Registration No.:</label>
                                                            <select name="registration_number" id="registration_number" class="form-control">
                                                                <option value="">Choose...</option>
                                                                @foreach($regNumbers as $value => $label)
                                                                <option value="{{ $value }}" {{ isset($refurbishment->registration_number) && $refurbishment->registration_number == $value ? 'selected' : '' }}>{{ $label }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="col-md-3 mt-3">
                                                            <label for="mst_supplier_id">Supplier:</label>
                                                            <select name="mst_supplier_id" id="mst_supplier_id" class="form-control">
                                                                <option value="">Choose...</option>
                                                                @foreach($suppliers as $value => $label)
                                                                <option value="{{ $value }}" {{ isset($refurbishment->mst_supplier_id) && $refurbishment->mst_supplier_id == $value ? 'selected' : '' }}>{{ $label }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="col-md-3 mt-3">
                                                            <label for="payment_mode">Payment Mode:</label>
                                                            <select name="payment_mode" id="payment_mode" class="form-control">
                                                                <option value="">Choose...</option>
                                                                @foreach($paymentmodes as $value => $label)
                                                                <option value="{{ $value }}" {{ isset($refurbishment->payment_mode) && $value == $refurbishment->payment_mode? 'selected' : '' }}>{{ $label }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="col-md-3 mt-3">
                                                            <label for="head">Head:</label>
                                                            <select name="head" id="head" class="form-control">
                                                                <option value="">Choose...</option>
                                                                @foreach($headOptions as $value => $label)
                                                                <option value="{{ $value }}" {{ isset($refurbishment->head) && $value == $refurbishment->head? 'selected' : '' }}>{{ $label }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="col-md-3 mt-3">
                                                            <label for="mst_executive_id">Sale Executive:</label>
                                                            <select name="mst_executive_id" id="mst_executive_id" class="form-control">
                                                                <option value="">Choose...</option>
                                                                @foreach($executives as $value => $label)
                                                                <option value="{{ $value }}" {{ isset($refurbishment->mst_executive_id) && $refurbishment->mst_executive_id == $value ? 'selected' : '' }}>{{ $label }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="col-md-3 mt-3">
                                                            <label for="amount">Amount:</label>
                                                            <input type="text" name="amount" class="form-control" placeholder="Enter Amount" value="@if(isset($refurbishment->id)){{$refurbishment->amount}}@else{{old('amount')}}@endif" required data-validation-required-message="Name field is required">
                                                        </div>
                                                        <div class="col-md-3 mt-3">
                                                            <label for="description">Description:</label>
                                                            <textarea id="description" name="description" class="form-control" rows="3">@if(isset($refurbishment->id)){{ $refurbishment->description }}@else{{ old('description') }}@endif</textarea>
                                                        </div>
                                                        <div class="col-md-1 mt-3">
                                                            <button class="btn btn-danger remove-section-btn d-none">-</button>
                                                        </div>
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

@push('scripts')
<script>
    $(document).ready(() => {
        $('select').selectize();
    });

    $(document).ready(function() {
        let sectionCounter = 1;

        $('#add-section-btn').click(function() {
            const originalSection = $('.section:first').clone();
            originalSection.find('select, input, textarea').val('');
            originalSection.find('[id]').each(function() {
                const id = $(this).attr('id') + '-' + sectionCounter;
                $(this).attr('id', id);
            });
            originalSection.find('[name]').each(function() {
                const name = $(this).attr('name') + '-' + sectionCounter;
                $(this).attr('name', name);
            });
            originalSection.find('.remove-section-btn').removeClass('d-none');
            $('#sections').append(originalSection);
            sectionCounter++;
        });

        $(document).on('click', '.remove-section-btn', function() {
            $(this).closest('.section').remove();
        });
    });
</script>
@endpush