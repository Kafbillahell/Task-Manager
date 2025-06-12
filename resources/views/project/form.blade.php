@extends('layouts.default')
@section('content')
<!-- Page Heading -->
<h1 class="h3 mb-2 text-gray-800">Form</h1>
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Create/Edit Form</h6>
    </div>
    <div class="card-body">
        <form action="{{ empty($result) ? url('project/add') : url("project/$result->id/edit") }}" enctype="multipart/form-data" method="POST">
            {{ @csrf_field() }}

            @if (!empty($result))
            {{ method_field('patch') }}
            @endif

            <div class="form-group">
                <label for="name">Nama Project</label>
                <input type="text" class="form-control" id="name" name="name" required value="{{@$result->name}}">
            </div>
            
            <div class="form-group">
                <label for="name">Description</label>
                <input type="text" class="form-control" id="description" name="description" required value="{{@$result->description}}">
            </div>

            <div class="form-group">
                <label for="name">Team</label>
                <input type="number" class="form-control" id="team_id" name="team_id" required value="{{@$result->team_id}}">
            </div>

            <div class="form-group">
                <label for="name">Created By</label>
                <input type="number" class="form-control" id="created_by" name="created_by" required value="{{@$result->created_by}}">
            </div>
            
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
</div>
@endsection