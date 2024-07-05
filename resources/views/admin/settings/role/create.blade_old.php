@extends('admin.layouts.header')

@section('title', 'Add Role')
@section('content')
    <div class="main-panel">
        <!-- BEGIN : Main Content-->
        <div class="main-content">
            <div class="content-overlay"></div>
            <div class="content-wrapper">
                <div class="row">
                    <div class="col-12">
                        <div class="content-header"></div>
                    </div>
                </div>
                <section id="simple-validation">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title"><b><a href="{{route('admin.setting.role.index')}}">All Roles</a></b> / @if(isset($color->id)) Edit @else Add @endif Role</h4>
                                </div>
                                <div class="card-content">
                                        <div class="row justify-content-center"> <!-- Center the row -->
                                            <div class="col-sm-6">
                                                <form
                                                    method="post"
                                                    action="{{route('admin.setting.role.store')}}"
                                                >
                                                    @csrf
                                                    <input type="hidden" name="role_id" value="{{$role->id ?? null}}">
                                                    <div class="mb-3">
                                                        <label for="" class="form-label">Name</label>
                                                        <input type="text" class="form-control" name="title" value="{{ $role->title ?? old('name') }}" required>
                                                    </div>
                                                    
                                                    <div class="mb-3">
                                                        <label for="" class="form-label">Permissions</label>
                                                        <select id="permissions-select" name="permissions[]" class="form-select mb-1" multiple required>
                                                            <option selected value="">Choose...</option>
                                                            
                                                            @if(isset($role))
                                                                @foreach($permissions as $id => $permission)
                                                                    <option value="{{ $id }}" {{ $roleP->contains($id) ? 'selected' : '' }}>{{ $permission }}</option>
                                                                @endforeach
                                                            @else
                                                                <option selected value="">Choose...</option>
                                                                @foreach($permissions as $id => $permission)
                                                                    <option value="{{ $id }}">{{ $permission }}</option>
                                                                @endforeach
                                                            @endif
                                                        </select>
                                                    </div>
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
        $(document).ready(()=>{
            $('select').selectize({
                plugins: ["remove_button"],
            });
        });
    </script>
@endpush
