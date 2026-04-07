<!doctype html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Dashboard | ScholarHub</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
  <style>
    .task-scroll { max-height: 320px; overflow-y: auto; }
    .task-item {
      display: flex;
      justify-content: space-between;
      align-items: flex-start;
      padding: 8px 0;
      border-bottom: 1px solid #f0f0f0;
    }
    .task-item:last-child { border-bottom: none; }
    .task-actions { display: flex; gap: 4px; flex-shrink: 0; }
  </style>
</head>
<body class="bg-light">

{{-- NAVBAR --}}
<nav class="navbar bg-white border-bottom sticky-top px-3">
  <div class="d-flex align-items-center gap-2">
    <button class="btn btn-light d-lg-none" data-bs-toggle="offcanvas" data-bs-target="#mobileSidebar">
      <i class="fas fa-bars"></i>
    </button>
    <i class="fas fa-book-open"></i>
    <span class="fw-bold fs-5">ScholarHub</span>
  </div>
</nav>

<div class="container-fluid">
<div class="row">

  {{-- DESKTOP SIDEBAR --}}
  <aside class="col-lg-2 d-none d-lg-flex flex-column bg-white border-end p-3 sticky-top" style="min-height: calc(100vh - 56px); top: 56px;">
    <div class="d-flex align-items-center gap-2 bg-light border rounded p-3 mb-3">
      <i class="fas fa-user-circle fa-2x text-secondary"></i>
      @auth
        <div class="user-profile">
          <div class="fw-bold small">{{ Auth::user()->name }}</div>
          <div class="text-muted" style="font-size:.75rem">{{ Auth::user()->email }}</div>
        </div>
      @endauth
    </div>
    <nav class="nav flex-column gap-1 mb-3">
      <a href="#" class="nav-link rounded px-3 py-2 text-dark bg-light fw-semibold">
        <i class="fas fa-th-large me-2"></i> Dashboard
      </a>
      <a href="#" class="nav-link rounded px-3 py-2 text-dark">
        <i class="fas fa-sticky-note me-2"></i> Pages
      </a>
      <a href="#" class="nav-link rounded px-3 py-2 text-dark">
        <i class="fas fa-bookmark me-2"></i> Spaces
      </a>
    </nav>
    <form id="logout-form" action="{{ route('logout') }}" method="POST">
      @csrf
      <div class="mt-auto">
        <a href="{{ route('logout') }}"
           onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
           class="btn btn-outline-danger w-100">
          <i class="fas fa-sign-out-alt me-2"></i> Log Out
        </a>
      </div>
    </form>
  </aside>

  {{-- MOBILE SIDEBAR --}}
  <div class="offcanvas offcanvas-start" style="width:260px" tabindex="-1" id="mobileSidebar">
    <div class="offcanvas-header border-bottom">
      <span class="fw-bold"><i class="fas fa-book-open me-2"></i>ScholarHub</span>
      <button class="btn-close" data-bs-dismiss="offcanvas"></button>
    </div>
    <div class="offcanvas-body d-flex flex-column p-3">
      <div class="d-flex align-items-center gap-2 bg-light border rounded p-3 mb-3">
        <i class="fas fa-user-circle fa-2x text-secondary"></i>
        @auth
          <div class="user-profile">
            <div class="fw-bold small">{{ Auth::user()->name }}</div>
            <div class="text-muted" style="font-size:.75rem">{{ Auth::user()->email }}</div>
          </div>
        @endauth
      </div>
      <nav class="nav flex-column gap-1 mb-3">
        <a href="#" class="nav-link rounded px-3 py-2 text-dark bg-light fw-semibold">
          <i class="fas fa-th-large me-2"></i> Dashboard
        </a>
        <a href="#" class="nav-link rounded px-3 py-2 text-dark">
          <i class="fas fa-sticky-note me-2"></i> Pages
        </a>
        <a href="#" class="nav-link rounded px-3 py-2 text-dark">
          <i class="fas fa-bookmark me-2"></i> Spaces
        </a>
      </nav>
      <form id="logout-form-mobile" action="{{ route('logout') }}" method="POST">
        @csrf
        <div class="mt-auto">
          <a href="{{ route('logout') }}"
             onclick="event.preventDefault(); document.getElementById('logout-form-mobile').submit();"
             class="btn btn-outline-danger w-100">
            <i class="fas fa-sign-out-alt me-2"></i> Log Out
          </a>
        </div>
      </form>
    </div>
  </div>

  {{-- MAIN CONTENT --}}
  <main class="col-lg-10 p-4">

    <div class="mb-4">
      <h2 class="fw-bold">Welcome, {{ Auth::user()->name }}</h2>
      <p class="text-muted">Your personal academic workspace.</p>
    </div>

    {{-- TASK SUMMARY
    <div class="card shadow-sm mb-4">
      <div class="card-header fw-bold bg-white">Task Management</div>
      <div class="card-body d-flex gap-3 flex-wrap">
        <div class="flex-fill text-center rounded p-3 bg-warning bg-opacity-25">
          <div class="fs-1 fw-bold text-warning-emphasis">
            {{ $tasks->where('status', 'pending')->count() }}
          </div>
          <div class="small text-uppercase fw-semibold text-warning-emphasis">Pending</div>
        </div>
        <div class="flex-fill text-center rounded p-3 bg-primary bg-opacity-10">
          <div class="fs-1 fw-bold text-primary">
            {{ $tasks->where('status', 'in_progress')->count() }}
          </div>
          <div class="small text-uppercase fw-semibold text-primary">In Progress</div>
        </div>
        <div class="flex-fill text-center rounded p-3 bg-success bg-opacity-10">
          <div class="fs-1 fw-bold text-success">
            {{ $tasks->where('status', 'completed')->count() }}
          </div>
          <div class="small text-uppercase fw-semibold text-success">Done</div>
        </div>
      
      </div>
    </div> --}}

    {{-- TASKS / NOTES / RESOURCES --}}
    <div class="row   p-4 g-4">

      {{-- TASKS --}}
      <div class="col-12 col  col-md-4">
        <div class="card shadow-sm h-100">
          <div class="card-header bg-white d-flex justify-content-between align-items-center">
            <span class="fw-bold">Tasks</span>
            <button class="btn btn-sm btn-dark" data-bs-toggle="modal" data-bs-target="#taskModal">
              + Add Task
            </button>
          </div>
          <div class="card-body task-scroll">
            @forelse ($tasks as $task)
              <div class="task-item">
                <div>
                  {{-- Status badge --}}
                  @php
                    $badgeMap = [
                      'pending'     => 'warning text-dark',
                      'in_progress' => 'primary',
                      'completed'   => 'success',
                      'overdue'     => 'danger',
                    ];
                    $badge = $badgeMap[$task->status] ?? 'secondary';

                  @endphp
                 
                 <span class="badge bg-{{ $badge }} mb-1">{{ ucfirst(str_replace('_', ' ', $task->status)) }}</span>
                  <div class="fw-semibold small">{{ $task->task_name }}</div>
                  <div class="text-muted" style="font-size:.75rem">
                    {{ $task->subject }} &middot; Due: {{ $task->due_date }}
                  </div>
                </div>
                <div class="task-actions">
                  {{-- Edit button --}}
                  <button
                    class="btn btn-sm btn-outline-secondary py-0 px-1"
                    data-bs-toggle="modal"
                    data-bs-target="#editTaskModal"
                    data-id="{{ $task->id }}"
                    data-task_name="{{ $task->task_name }}"
                    data-due_date="{{ $task->due_date }}"
                    data-subject="{{ $task->subject }}"
                    data-status="{{ $task->status }}"
                    title="Edit"
                  >
                    <i class="fas fa-pen fa-xs"></i>
                  </button>

                  {{-- Delete button --}}
                  <form action="/dashboard/{{ $task->id }}" method="POST" onsubmit="return confirm('Delete this task?')">
                    @csrf
                   
                    <button type="submit" class="btn btn-sm btn-outline-danger py-0 px-1" title="Delete">
                      <i class="fas fa-trash fa-xs"></i>
                    </button>
                  </form>
                </div>
              </div>
            @empty
              <p class="text-muted small">No tasks yet.</p>
            @endforelse

            <div class="d-flex gap-2 flex-wrap small text-muted mt-3">
              <span><span class="badge bg-warning text-dark">&nbsp;</span> Pending</span>
              <span><span class="badge bg-primary">&nbsp;</span> In Progress</span>
              <span><span class="badge bg-success">&nbsp;</span> Done</span>
              <span><span class="badge bg-danger">&nbsp;</span> Overdue</span>
            </div>
          </div>
        </div>
      </div>

      {{-- NOTES --}}
      <div class="col-12 col-md-4">
        <div class="card shadow-sm h-100">
          <div class="card-header bg-white d-flex justify-content-between align-items-center">
            <span class="fw-bold">Notes</span>
            <button class="btn btn-sm btn-dark" data-bs-toggle="modal" data-bs-target="#noteModal">
              + Add Note
            </button>
          </div>
          <div class="card-body task-scroll">
            <p class="text-muted small">No notes yet.</p>
          </div>
        </div>
      </div>

      {{-- RESOURCES --}}
      <div class="col-12 col-md-4">
        <div class="card shadow-sm h-100">
          <div class="card-header bg-white d-flex justify-content-between align-items-center">
            <span class="fw-bold">Resources</span>
            <button class="btn btn-sm btn-dark" data-bs-toggle="modal" data-bs-target="#resourceModal">
              + Add Resource
            </button>
          </div>
          <div class="card-body task-scroll">
            <p class="text-muted small">No resources yet.</p>
          </div>
        </div>
      </div>

    </div>
  </main>

</div>
</div>

{{-- ===================== MODALS ===================== --}}

{{-- Add Task --}}
<div class="modal fade" id="taskModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Add New Task</h5>
        <button class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <form action="/dashboard" method="POST">
          @csrf
          <div class="mb-3">
            <label class="form-label">Task Name</label>
            <input type="text" class="form-control" name="task_name" required />
          </div>
          <div class="mb-3">
            <label class="form-label">Due Date</label>
            <input type="date" class="form-control" name="due_date" required />
          </div>
          <div class="mb-3">
            <label class="form-label">Subject</label>
            <input type="text" class="form-control" name="subject" />
          </div>
          <div class="mb-3">
            <label class="form-label">Status</label>
            <select class="form-select" name="status" required>
              <option value="pending">Pending</option>
              <option value="in_progress">In Progress</option>
              <option value="completed">Completed</option>
            </select>
          </div>
          <button type="submit" class="btn btn-dark w-100">Add Task</button>
        </form>
      </div>
    </div>
  </div>
</div>

{{-- Edit Task --}}
<div class="modal fade" id="editTaskModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Edit Task</h5>
        <button class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <form id="editTaskForm" action="/dashboard" method="POST">
          @csrf
           <div class="mb-3">
            <label class="form-label">Task Name</label>
            <input type="text" class="form-control" value="{{ $task->task_name }}"  name="task_name" id="edit_task_name" required />
          </div>
          <div class="mb-3">
            <label class="form-label">Due Date</label>
            <input type="date" class="form-control" name="due_date" value="{{ $task->due_date }}" id="edit_due_date" required />
          </div>
          <div class="mb-3">
            <label class="form-label">Subject</label>
            <input type="text" class="form-control" name="subject" value="{{ $task->subject }}"  id="edit_subject" />
          </div>
          <div class="mb-3">
            <label class="form-label">Status</label>
            <select class="form-select" value="{{ $task->status }}"  name="status" id="edit_status" required>
              <option value="pending">Pending</option>
              <option value="in_progress">In Progress</option>
              <option value="completed">Completed</option>
             
            </select>
          </div>
          <button type="submit" class="btn btn-dark w-100">Save Changes</button>
        </form>
      </div>
    </div>
  </div>
</div>

{{-- Add Note --}}
<div class="modal fade" id="noteModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Add New Note</h5>
        <button class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <form>
          <div class="mb-3">
            <label class="form-label">Note Title</label>
            <input type="text" class="form-control" name="title" required />
          </div>
          <div class="mb-3">
            <label class="form-label">URL</label>
            <input type="url" class="form-control" name="url" required />
          </div>
          <div class="mb-3">
            <label class="form-label">Date</label>
            <input type="date" class="form-control" name="note_date" required />
          </div>
          <button type="submit" class="btn btn-dark w-100">Add Note</button>
        </form>
      </div>
    </div>
  </div>
</div>

{{-- Add Resource --}}
<div class="modal fade" id="resourceModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Add New Resource</h5>
        <button class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <form>
          <div class="mb-3">
            <label class="form-label">Resource Title</label>
            <input type="text" class="form-control" name="title" required />
          </div>
          <div class="mb-3">
            <label class="form-label">URL</label>
            <input type="url" class="form-control" name="url" required />
          </div>
          <div class="mb-3">
            <label class="form-label">Date</label>
            <input type="date" class="form-control" name="resource_date" required />
          </div>
          <button type="submit" class="btn btn-dark w-100">Add Resource</button>
        </form>
      </div>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
 
  const editTaskModal = document.getElementById('editTaskModal');
  editTaskModal.addEventListener('show.bs.modal', function (event) {
    const btn = event.relatedTarget;
    document.getElementById('edit_task_name').value = btn.dataset.task_name;
    document.getElementById('edit_due_date').value  = btn.dataset.due_date;
    document.getElementById('edit_subject').value   = btn.dataset.subject;
    document.getElementById('edit_status').value    = btn.dataset.status;

    // Set form action dynamically
    document.getElementById('editTaskForm').action = '/dashboard/' + btn.dataset.id;
  });
</script>
</body>
</html>