@extends('layouts.default')
@section('content')
  <!-- Kanban Board -->
  <div class="row g-4">
    <!-- To Do Column -->
    <span class="status-badge bg-purple-900 text-white text-uppercase">TODO</span>
    <div class="col-md-4">
      <div class="card shadow-sm">
        <div class="card-body">
          <div class="d-flex justify-content-between align-items-center mb-3">
            <h3 class="h5 text-secondary">To Do</h3>
            <span class="badge bg-secondary todo-count">{{ count($todoTasks) }}</span>
          </div>
          <div id="todo-column" class="task-column p-2" data-status="todo">
            @foreach ($todoTasks as $task)
              <div class="task-card bg-white border border-gray-200 rounded-lg p-4 mb-3 shadow-sm"
                data-task-id="{{ $task->id }}">
                <div class="flex justify-between items-start mb-2">
                  <h4 class="font-semibold text-gray-800">{{ $task->title }}</h4>
                  <span class="status-badge bg-gray-100 text-gray-600 uppercase">{{ strtoupper($task->status) }}
                  </span>
                </div>
                <p class="text-gray-600 text-sm mb-3">{{ $task->description }}</p>
                <div class="flex justify-between items-center">
                  <div class="flex items-center space-x-2">
                    <span class="text-xs text-gray-500">👤 {{ $task->assigned_to_name ?? 'Unassigned' }}</span>
                    <button class="like-btn text-red-500 hover:text-red-700" data-task-id="{{ $task->id }}">
                      ❤️ <span class="like-count">{{ $task->likes_count }}</span>
                    </button>
                  </div>
                  <button class="text-blue-500 hover:text-blue-700 text-sm"
                    onclick="showTaskComments({{ $task->id }})">💬 Comments</button>
                </div>
              </div>
            @endforeach
          </div>
        </div>
      </div>
    </div>

    <!-- In Progress Column -->
    <div class="col-md-4">
      <div class="card shadow-sm">
        <div class="card-body">
          <div class="d-flex justify-content-between align-items-center mb-3">
            <h3 class="h5 text-primary">In Progress</h3>
            <span class="badge bg-primary progress-count">{{ count($inProgressTasks) }}</span>
          </div>
          <div id="in-progress-column" class="task-column p-2" data-status="in_progress">
            @foreach ($inProgressTasks as $task)
              <div class="task-card bg-white border border-gray-200 rounded-lg p-4 mb-3 shadow-sm"
                data-task-id="{{ $task->id }}">
                <div class="flex justify-between items-start mb-2">
                  <h4 class="font-semibold text-gray-800">{{ $task->title }}</h4>
                  <span class="status-badge bg-blue-100 text-primary uppercase">{{ strtoupper($task->status) }}
                  </span>
                </div>
                <p class="text-gray-600 text-sm mb-3">{{ $task->description }}</p>
                <div class="flex justify-between items-center">
                  <div class="flex items-center space-x-2">
                    <span class="text-xs text-gray-500">👤 {{ $task->assigned_to_name ?? 'Unassigned' }}</span>
                    <button class="like-btn text-red-500 hover:text-red-700" data-task-id="{{ $task->id }}">
                      ❤️ <span class="like-count">{{ $task->likes_count }}</span>
                    </button>
                  </div>
                  <button class="text-blue-500 hover:text-blue-700 text-sm"
                    onclick="showTaskComments({{ $task->id }})">💬 Comments</button>
                </div>
              </div>
            @endforeach
          </div>
        </div>
      </div>
    </div>

    <!-- Done Column -->
    <div class="col-md-4">
      <div class="card shadow-sm">
        <div class="card-body">
          <div class="d-flex justify-content-between align-items-center mb-3">
            <h3 class="h5 text-success">Done</h3>
            <span class="badge bg-success done-count">{{ count($doneTasks) }}</span>
          </div>
          <div id="done-column" class="task-column p-2" data-status="done">
            @foreach ($doneTasks as $task)
              <div class="task-card bg-white border border-gray-200 rounded-lg p-4 mb-3 shadow-sm"
                data-task-id="{{ $task->id }}">
                <div class="flex justify-between items-start mb-2">
                  <h4 class="font-semibold text-gray-800">{{ $task->title }}</h4>
                  <span
                    class="status-badge bg-blue-100 text-success text-uppercase">{{ strtoupper($task->status) }}</span>
                </div>
                <p class="text-gray-600 text-sm mb-3">{{ $task->description }}</p>
                <div class="flex justify-between items-center">
                  <div class="flex items-center space-x-2">
                    <span class="text-xs text-gray-500">👤 {{ $task->assigned_to_name ?? 'Unassigned' }}</span>
                    <button class="like-btn text-red-500 hover:text-red-700" data-task-id="{{ $task->id }}">
                      ❤️ <span class="like-count">{{ $task->likes_count }}</span>
                    </button>
                  </div>
                  <button class="text-blue-500 hover:text-blue-700 text-sm"
                    onclick="showTaskComments({{ $task->id }})">💬 Comments</button>
                </div>
              </div>
            @endforeach
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Status Display -->
  <div id="status-display" class="mt-4 p-3 bg-white rounded shadow-sm d-none">
    <div class="d-flex align-items-center">
      <div class="loading-spinner"></div>
      <span id="status-text">Updating task status...</span>
    </div>
  </div>

  <!-- Comment Modal -->
  <div class="modal fade" id="commentModal" tabindex="-1" aria-labelledby="commentModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="commentModalLabel">Comments for Task <span id="modal-task-id"></span></h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div id="modal-comments-list">
            <!-- Comments will be loaded here -->
            <p class="text-muted">No comments yet.</p>
          </div>
          <div class="mt-3">
            <textarea id="new-comment-text" class="form-control" rows="3" placeholder="Add a new comment"></textarea>
            <button class="btn btn-primary mt-2" id="add-comment-btn">Add Comment</button>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
