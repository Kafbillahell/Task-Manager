@extends('layouts.default')
@section('content')
<!-- Page Heading -->
<h1 class="h3 mb-2 text-gray-800">Form</h1>
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Create/Edit Form</h6>
    </div>
    <div class="card-body">
        <form action="{{ empty($result) ? url('task/add') : url("task/$result->id/edit") }}" enctype="multipart/form-data" method="POST">
            {{ @csrf_field() }}

            @if (!empty($result))
            {{ method_field('patch') }}
            @endif

            <div class="form-group">
                <label for="name">Title</label>
                <input type="text" class="form-control" id="title" name="title" required value="{{@$result->title}}">
            </div>

            <div class="form-group">
                <label for="name">Description</label>
                <input type="text" class="form-control" id="description" name="description" required value="{{@$result->description}}">
            </div>

            <div class="form-group">
                <label for="name">Project id</label>
                <input type="number" class="form-control" id="project_id" name="project_id" required value="{{@$result->project->id}}">
            </div>

            <div class="form-group">
                <label for="name">Assigned to</label>
                <input type="number" class="form-control" id="assigned_to" name="assigned_to" required value="{{@$result->assignedUser->id}}">
            </div>

            <div class="form-group">
                <label for="name">Created By</label>
                <input type="number" class="form-control" id="created_by" name="created_by" required value="{{@$result->creator->id}}">
            </div>

            <div class="form-group">
                <label for="name">Status</label>
                <select name="status" class="form-control">
                    <option value="todo" {{ @$result->status == 'todo' ? 'selected' : '' }}>To Do</option>
                    <option value="in_progress" {{ @$result->status == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                    <option value="done" {{ @$result->status == 'done' ? 'selected' : '' }}>Done</option>
                </select>  
            </div>

            <div class="form-group">
                <label for="name">Order</label>
                <input type="number" class="form-control" id="order" name="order" required value="{{@$result->order}}">
            </div>

            <div class="form-group">
                <label for="name">Likes Count</label>
                <input type="number" class="form-control" id="likes_count" name="likes_count" required value="{{@$result->likes_count}}">
            </div>

            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
</div>
@endsection