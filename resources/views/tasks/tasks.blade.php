@extends('layouts.default')
@section('styles')
  <style>
    .task-column {
      min-height: 400px;
      border: 2px dashed transparent;
      transition: all 0.3s ease;
    }

    .task-column.ui-sortable-helper {
      border-color: #3b82f6;
      background-color: #eff6ff;
    }

    .task-card {
      cursor: move;
      transition: all 0.3s ease;
      transform: scale(1);
    }

    .task-card:hover {
      transform: scale(1.02);
      box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
    }

    .task-card.ui-sortable-helper {
      transform: rotate(5deg) scale(1.05);
      box-shadow: 0 15px 30px rgba(0, 0, 0, 0.3);
      z-index: 1000;
    }

    .task-placeholder {
      height: 100px;
      background: linear-gradient(45deg, #f3f4f6 25%, transparent 25%, transparent 75%, #f3f4f6 75%),
        linear-gradient(45deg, #f3f4f6 25%, transparent 25%, transparent 75%, #f3f4f6 75%);
      background-size: 20px 20px;
      background-position: 0 0, 10px 10px;
      border: 2px dashed #9ca3af;
      border-radius: 8px;
      margin: 8px 0;
      opacity: 0.7;
    }

    .column-highlight {
      border-color: #10b981 !important;
      background-color: #ecfdf5 !important;
    }

    .drag-preview {
      opacity: 0.8;
      transform: rotate(3deg);
    }

    .status-badge {
      font-size: 10px;
      padding: 2px 6px;
      border-radius: 12px;
      font-weight: 600;
      text-transform: uppercase;
    }

    .loading-spinner {
      border: 2px solid #f3f3f3;
      border-top: 2px solid #3498db;
      border-radius: 50%;
      width: 20px;
      height: 20px;
      animation: spin 1s linear infinite;
      display: inline-block;
      margin-right: 8px;
    }

    @keyframes spin {
      0% {
        transform: rotate(0deg);
      }

      100% {
        transform: rotate(360deg);
      }
    }

    .success-flash {
      animation: flash-success 0.5s ease-in-out;
    }

    @keyframes flash-success {
      0% {
        background-color: #10b981;
      }

      50% {
        background-color: #34d399;
      }

      100% {
        background-color: #10b981;
      }
    }
  </style>
@endsection
@section('content')
  <div class="container mx-auto">
    <!-- Kanban Board -->
    <div class="row g-4">
      <div class="col-md-4">
        <!-- To Do Column -->
        <div class="bg-white rounded-lg shadow-lg p-4">
          <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-semibold text-gray-700">To Do</h3>
            <span
              class="bg-gray-200 text-gray-700 px-2 py-1 rounded-full text-sm todo-count">{{ $todoTasks->count() }}</span>
          </div>
          <div id="todo-column" class="task-column" data-status="todo">
            @foreach ($todoTasks as $task)
              <div class="task-card bg-white border border-gray-200 rounded-lg p-4 mb-3 shadow-sm"
                data-task-id="{{ $task->id }}">
                <div class="flex justify-between items-start mb-2">
                  <h4 class="font-semibold text-gray-800">{{ $task->title }}</h4>
                  <span class="status-badge bg-gray-100 text-gray-600">{{ strtoupper($task->status) }}</span>
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

      <div class="col-md-4">
        <!-- In Progress Column -->
        <div class="bg-white rounded-lg shadow-lg p-4">
          <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-semibold text-blue-700">In Progress</h3>
            <span
              class="bg-blue-200 text-blue-700 px-2 py-1 rounded-full text-sm progress-count">{{ $inProgressTasks->count() }}</span>
          </div>
          <div id="in-progress-column" class="task-column" data-status="in_progress">
            @foreach ($inProgressTasks as $task)
              <div class="task-card bg-white border border-blue-200 rounded-lg p-4 mb-3 shadow-sm"
                data-task-id="{{ $task->id }}">
                <div class="flex justify-between items-start mb-2">
                  <h4 class="font-semibold text-gray-800">{{ $task->title }}</h4>
                  <span class="status-badge bg-blue-100 text-blue-600">{{ strtoupper($task->status) }}</span>
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

      <div class="col-md-4">
        <!-- Done Column -->
        <div class="bg-white rounded-lg shadow-lg p-4">
          <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-semibold text-green-700">Done</h3>
            <span
              class="bg-green-200 text-green-700 px-2 py-1 rounded-full text-sm done-count">{{ $doneTasks->count() }}</span>
          </div>
          <div id="done-column" class="task-column" data-status="done">
            @foreach ($doneTasks as $task)
              <div class="task-card bg-white border border-green-200 rounded-lg p-4 mb-3 shadow-sm"
                data-task-id="{{ $task->id }}">
                <div class="flex justify-between items-start mb-2">
                  <h4 class="font-semibold text-gray-800">{{ $task->title }}</h4>
                  <span class="status-badge bg-green-100 text-green-600">{{ strtoupper($task->status) }}</span>
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



    <!-- Comment Modal -->
    {{-- <div class="modal fade" id="commentModal" tabindex="-1" aria-labelledby="commentModalLabel" aria-hidden="true">
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
  </div> --}}
  @endsection
  @section('scripts')
    <script>
      $(document).ready(function() {
        // Initialize sortable columns with advanced options
        $('.task-column').sortable({
          connectWith: '.task-column',
          placeholder: 'task-placeholder',
          tolerance: 'pointer',
          cursor: 'move',
          opacity: 0.8,
          distance: 10,
          delay: 150,

          // Events
          start: function(event, ui) {
            // Add dragging class and store original position
            ui.item.addClass('drag-preview');
            ui.item.data('original-column', ui.item.parent().data('status'));
            ui.item.data('original-index', ui.item.index());

            // Highlight valid drop zones
            $('.task-column').not(ui.item.parent()).addClass('column-highlight');
          },

          over: function(event, ui) {
            // Enhanced visual feedback when hovering over columns
            $(this).addClass('column-highlight');
          },

          out: function(event, ui) {
            // Remove highlight when leaving column
            $(this).removeClass('column-highlight');
          },

          beforeStop: function(event, ui) {
            // Remove dragging effects
            ui.item.removeClass('drag-preview');
            $('.task-column').removeClass('column-highlight');
          },

          update: function(event, ui) {
            // Only process if item was actually moved to this column
            if (this === ui.item.parent()[0]) {
              var taskId = ui.item.data('task-id');
              var newStatus = ui.item.parent().data('status');
              var newOrder = ui.item.index();
              var oldStatus = ui.item.data('original-column');

              // Update task status and handle the response
              updateTaskStatus(taskId, newStatus, newOrder, oldStatus, ui.item);
            }
          },

          stop: function(event, ui) {
            // Clean up any remaining classes
            ui.item.removeClass('drag-preview');
            $('.task-column').removeClass('column-highlight');
          }
        });

        // Handle like button clicks
        $(document).on('click', '.like-btn', function(e) {
          e.preventDefault();
          var taskId = $(this).data('task-id');
          var likeCount = $(this).find('.like-count');
          var currentCount = parseInt(likeCount.text());

          // Optimistic update
          likeCount.text(currentCount + 1);
          $(this).addClass('success-flash');

          // Remove flash effect
          setTimeout(() => {
            $(this).removeClass('success-flash');
          }, 500);

          // In real implementation, make AJAX call here
          console.log('Liked task:', taskId);
        });
      });

      function updateTaskStatus(taskId, newStatus, newOrder, oldStatus, taskElement) {
        showStatusUpdate('Updating task status...');
        updateTaskCardStatus(taskElement, newStatus);
        updateColumnCounters();

        $.ajax({
          url: `/tasks/${taskId}/status`,
          type: 'PATCH',
          data: {
            status: newStatus,
            order: newOrder,
            _token: $('meta[name="csrf-token"]').attr('content')
          },
          success: function(response) {
            if (response.success) {
              showStatusUpdate('Task updated successfully!', 'success');
            }
          },
          error: function(xhr) {
            showStatusUpdate('Failed to update task. Reverting...', 'error');
            revertTaskPosition(taskElement, oldStatus);
            console.error('Error updating task status:', xhr.responseJSON);
          },
          complete: function() {
            setTimeout(hideStatusUpdate, 3000);
          }
        });
      }

      function updateTaskCardStatus(taskElement, newStatus) {
        var statusBadge = taskElement.find('.status-badge');
        var statusText = newStatus.replace('_', ' ').toUpperCase();

        // Remove old status classes
        statusBadge.removeClass('bg-gray-100 text-gray-600 bg-blue-100 text-blue-600 bg-green-100 text-green-600');

        // Add new status classes
        switch (newStatus) {
          case 'todo':
            statusBadge.addClass('bg-gray-100 text-gray-600');
            taskElement.removeClass('border-blue-200 border-green-200').addClass('border-gray-200');
            break;
          case 'in_progress':
            statusBadge.addClass('bg-blue-100 text-blue-600');
            taskElement.removeClass('border-gray-200 border-green-200').addClass('border-blue-200');
            break;
          case 'done':
            statusBadge.addClass('bg-green-100 text-green-600');
            taskElement.removeClass('border-gray-200 border-blue-200').addClass('border-green-200');
            break;
        }

        statusBadge.text(statusText);
      }

      function updateColumnCounters() {
        // Update counter badges
        $('.todo-count').text($('#todo-column .task-card').length);
        $('.progress-count').text($('#in-progress-column .task-card').length);
        $('.done-count').text($('#done-column .task-card').length);
      }

      function revertTaskPosition(taskElement, originalStatus) {
        var originalColumn = $(`[data-status="${originalStatus}"]`);
        originalColumn.append(taskElement);
        updateTaskCardStatus(taskElement, originalStatus);
        updateColumnCounters();
      }

      function showStatusUpdate(message, type = 'loading') {
        var statusDisplay = $('#status-display');
        var statusText = $('#status-text');
        var spinner = statusDisplay.find('.loading-spinner');

        statusText.text(message);

        if (type === 'success') {
          spinner.hide();
          statusDisplay.removeClass('bg-white').addClass('bg-green-100 border border-green-300');
          statusText.addClass('text-green-700');
        } else if (type === 'error') {
          spinner.hide();
          statusDisplay.removeClass('bg-white').addClass('bg-red-100 border border-red-300');
          statusText.addClass('text-red-700');
        } else {
          spinner.show();
          statusDisplay.removeClass('bg-green-100 bg-red-100 border-green-300 border-red-300').addClass('bg-white');
          statusText.removeClass('text-green-700 text-red-700');
        }

        statusDisplay.removeClass('hidden');
      }

      function hideStatusUpdate() {
        $('#status-display').addClass('hidden');
      }

      function showTaskComments(taskId) {
        // Placeholder for comment functionality
        alert(`Show comments for task ${taskId} - implement with AJAX modal`);
      }
    </script>
  @endsection
