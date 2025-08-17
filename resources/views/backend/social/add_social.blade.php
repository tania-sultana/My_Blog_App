@extends('backend.admin.master')
@section('content')
    <div class="page-content">
        <!--breadcrumb-->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">Add Social</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Data Table</li>
                    </ol>
                </nav>
            </div>
            <div class="ms-auto">
                <div class="btn-group">
                    <button type="button" class="btn btn-primary">Settings</button>
                    <button type="button" class="btn btn-primary split-bg-primary dropdown-toggle dropdown-toggle-split"
                        data-bs-toggle="dropdown"> <span class="visually-hidden">Toggle Dropdown</span>
                    </button>
                    <div class="dropdown-menu dropdown-menu-right dropdown-menu-lg-end"> <a class="dropdown-item"
                            href="javascript:;">Action</a>
                        <a class="dropdown-item" href="javascript:;">Another action</a>
                        <a class="dropdown-item" href="javascript:;">Something else here</a>
                        <div class="dropdown-divider"></div> <a class="dropdown-item" href="javascript:;">Separated link</a>
                    </div>
                </div>
            </div>
        </div>
        <!--end breadcrumb-->
        <h6 class="mb-0 text-uppercase mx-5">
            <a href="{{ route('add.social') }}">Add Social</a>
        </h6>
        <hr />
        <div class="card-body">
            <form action="{{ route('social.store') }}" method="post"  class="mx-5" style="width: 80%; float: right;">
                @csrf
                <div class="form-row">
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="facebook">Facebook <span class="text-danger"></span></label>
                            <input type="text" name="facebook" class="form-control" placeholder="facebook">
                            @error('facebook')
                              <span class="text-danger">{{$message}}</span>
                            @enderror
                        </div>
                        <div class="form-group col-md-6">
                            <label for="linkedin">Linkedin<span class="text-danger"></span></label>
                            <input type="text" name="linkedin" class="form-control" placeholder="linkedin">
                            @error('linkedin')
                              <span class="text-danger">{{$message}}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="twitter">Twitter<span class="text-danger"></span></label>
                            <input type="text" name="twitter" class="form-control" placeholder="twitter">
                            @error('twitter')
                              <span class="text-danger">{{$message}}</span>
                            @enderror
                        </div>
                        <div class="form-group col-md-6">
                            <label for="youtube">YouTube<span class="text-danger"></span></label>
                            <input type="text" name="youtube" class="form-control" placeholder="youtube">
                            @error('youtube')
                              <span class="text-danger">{{$message}}</span>
                            @enderror
                        </div>
                        <div class="row mt-4">
                            <button type="submit" class="btn btn-success form-control">Submit</button>
                        </div>
                    </div>

            </form>


        </div>
    </div>
@endsection
