@extends('layouts.admin')
@section('content')

    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex">
            <h6 class="m-0 font-weight-bold text-primary">Edit Neighborhood {{ $neighborhood->name }}</h6>
            <div class="ml-auto">
                <a href="{{ route('admin.neighborhoods.index') }}" class="btn btn-primary">
                    <span class="icon text-white-50">
                        <i class="fa fa-home"></i>
                    </span>
                    <span class="text">Neighborhoods</span>
                </a>
            </div>
        </div>
        <div class="card-body">

            <form action="{{ route('admin.neighborhoods.update', $neighborhood->id) }}" method="post">
                @csrf
                @method('PATCH')
                <div class="row">
                    <div class="col-9">
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" name="name" value="{{ old('name', $neighborhood->name) }}" class="form-control">
                            @error('name')<span class="text-danger">{{ $message }}</span>@enderror
                        </div>
                    </div>

                    <div class="col-4">
                        <label for="city_id">City</label>
                        <select name="city_id" class="form-control">
                            <option value=""> ----- </option>
                            @foreach ($cities as $city)
                                
                            <option value="{{ $city->id }}" {{ old('city_id', $neighborhood->city_id) == $city->id ? 'selected' : null }}>{{ $city->name }}</option>
                            @endforeach

                        </select>
                        @error('state_id')<span class="text-danger">{{ $message }}</span>@enderror
                    </div>
                    
                    <div class="col-3">
                        <label for="status">Status</label>
                        <select name="status" class="form-control">
                            <option value="1" {{ old('status', $neighborhood->status) == '1' ? 'selected' : null }}>Active</option>
                            <option value="0" {{ old('status', $neighborhood->status) == '0' ? 'selected' : null }}>Inactive</option>
                        </select>
                        @error('status')<span class="text-danger">{{ $message }}</span>@enderror
                    </div>
                </div>

                <div class="form-group pt-4">
                    <button type="submit" name="submit" class="btn btn-primary">Update Neighborhood</button>
                </div>
            </form>
        </div>
    </div>

@endsection
