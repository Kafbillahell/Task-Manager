<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <meta name="description" content="" />
  <meta name="author" content="" />
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>SB Admin 2 - Blank</title>

  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet"
    type="text/css" />
  <link
    href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
    rel="stylesheet" />

  <link href="{{ asset('assets/css/sb-admin-2.min.css') }}" rel="stylesheet" />
  <link href="{{ asset('assets/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
  <link rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.13.2/themes/ui-lightness/jquery-ui.min.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body id="page-top">
  <div id="wrapper">
    @include('layouts.sidebar')

    <div id="content-wrapper" class="d-flex flex-column">
      <div id="content">
        @include('layouts.header')

        <div class="container-fluid">
          @yield('content')
        </div>
      </div>
      <footer class="sticky-footer bg-white">
        <div class="container my-auto">
          <div class="copyright text-center my-auto">
            <span>Copyright &copy; Your Website 2020</span>
          </div>
        </div>
      </footer>
    </div>
  </div>
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

  <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal">
            Cancel
          </button>
          <a class="btn btn-primary" href="login.html">Logout</a>
        </div>
      </div>
    </div>
  </div>

  <script src="{{ asset('assets/vendor/jquery/jquery.min.js') }}"></script>
  <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
  <script src="{{ asset('assets/vendor/jquery-easing/jquery.easing.min.js') }}"></script>
  <script src="{{ asset('assets/js/sb-admin-2.min.js') }}"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.13.2/jquery-ui.min.js"></script>

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
</body>

</html>
