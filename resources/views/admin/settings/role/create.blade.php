@extends('admin.layouts.header')

@section('title', 'Edit Permission')
@section('content')

<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<div class="main-panel">
    <div class="main-content">
        <div class="content-overlay"></div>
        <div class="content-wrapper">
            <section id="positioning">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-content">
                                <div class="card-header">
                                    <div class="row">
                                        <div class="col-12 col-sm-7">
                                            <h5 class="pt-2">Edit Permission Role : {{$role->role}}</h5>
                                        </div>
                                        <div class="col-12 col-sm-5 d-flex justify-content-end align-items-center">
                                            <a href="{{route('admin.setting.role.index')}}" class="btn btn-sm btn-primary px-3 py-1"><i class="fa fa-arrow-left"></i> Back</a>
                                        </div>
                                    </div>
                                </div>
                                <!-- <hr class="mb-0"> -->
                                <input type="hidden" id="role_id" name="role_id" value="{{$id}}">
                                <div class="card-body table-responsive">
                                    <table class="table table-striped table-bordered dom-jQuery-events">
                                        <thead style="background-color: #d6d6d6; color: #000000;  z-index: 1;">
                                            <tr>
                                                <th>Permissions</th>
                                                <th>List</th>
                                                <th>Add</th>
                                                <th>Edit</th>
                                                <th>View</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>

                                        <tbody>

                                            @foreach ($grouped as $value => $permission)
                                            <tr>
                                                <td><strong>{{ ucfirst(str_replace('_', ' ', $value)) }}</strong></td>
                                                @foreach ($permission as $item)
                                                <td>
                                                    <div class="custom-switch custom-control-inline mb-1 mb-xl-0">
                                                        <input type="checkbox" data-url="{{$item->id}}" value="{{$item->permissions}}" data-role="{{ $item->permissions }}" data-type="list" class="custom-control-input permission" id="custom-switch-{{$item->id}}" {{ in_array($item->id, $permissionIds) ? 'checked' : '' }}>
                                                        <label class="custom-control-label mr-1" for="custom-switch-{{ $item->id }}"></label>
                                                    </div>

                                                </td>
                                                @endforeach
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
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
<!-- Script -->
<script type="text/javascript">
    $('#event_highlight').keyup(function(e) {
        var sampleInput = $('#event_highlight').val(),
            sampleInputLength = sampleInput.length;
        $('#highlight_text_count').text(sampleInputLength);
    });

    $('#what_is_it').keyup(function(e) {
        var sampleInput = $('#what_is_it').val(),
            sampleInputLength = sampleInput.length;
        $('#whatisit_text_count').text(sampleInputLength);
    });

    var screensize = document.documentElement.clientWidth;
    if (screensize < 600) {
        alert
        $('#multi-select').hide();
    }

    $(document).ready(function() {
        $('.permission').click(function() {
            var permissionId = $(this).attr('data-url');
            var status = $(this).prop('checked') ? 1 : 0;
            var roleId = $('#role_id').val();

            $.ajax({
                url: "{{route('update.permission')}}",
                type: 'POST',
                data: {
                    permissionId: permissionId,
                    status: status,
                    roleId: roleId,
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    console.log(response);
                }
            });

        });
    });
</script>
@endpush
