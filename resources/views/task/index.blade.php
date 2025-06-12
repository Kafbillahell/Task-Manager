@extends('layouts.default')
@section('content')
<!-- Page Heading -->
<h1 class="h3 mb-2 text-gray-800">Tables</h1>
<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Employees Table</h6>

        <a href="{{ url('task/add') }}" class="btn btn-success">
            <i class="fa fa-fw fa-plus-circle"></i>
            Tambah
        </a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Description</th>
                        <th>Project</th>
                        <th>Assigned To</th>
                        <th>Created By</th>
                        <th>Status</th>
                        <th>Order</th>
                        <th>Likes Count</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($result as $row)
                    <tr>
                        <td>{{ $row->title }}</td>
                        <td>{{ $row->description }}</td>
                        <td>{{ $row->project->name }}</td>
                        <td>{{ $row->assignedUser->name ?? ' - ' }}</td>
                        <td>{{ $row->creator->name ?? ' - ' }}</td>
                        <td>{{ $row->status }}</td>
                        <td>{{ $row->order }}</td>
                        <td>{{ $row->likes_count }}</td>
                        <td>
                            <a href="{{ url("task/$row->id/edit") }}" class="btn btn-warning">
                                <i class="fa fa-fw fa-pencil"></i>
                            </a>
                            <form method="POST" style="display: inline;" action="{{ url("task/$row->id/delete") }}">
                                {{ csrf_field() }}
                                {{ method_field('DELETE') }}
                                <button type="submit" class="btn  btn-danger">
                                    <i class="fa fa-fw fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <th>Title</th>
                        <th>Description</th>
                        <th>Project</th>
                        <th>Assigned To</th>
                        <th>Created By</th>
                        <th>Status</th>
                        <th>Order</th>
                        <th>Likes Count</th>
                        <th>Action</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>
@endsection