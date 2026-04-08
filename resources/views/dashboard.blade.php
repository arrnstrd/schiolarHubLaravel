@extends('layouts.app')

@section('content')
    {{-- Custom styles for this page --}}
    <style>
        .task-scroll {
            max-height: 320px;
            overflow-y: auto;
        }

        .task-item {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            padding: 8px 0;
            border-bottom: 1px solid #f0f0f0;
        }

        .task-item:last-child {
            border-bottom: none;
        }

        .task-actions {
            display: flex;
            gap: 4px;
            flex-shrink: 0;
        }
    </style>

    
    <div class="mb-4">
        <h2 class="fw-bold">Welcome, {{ Auth::user()?->name ?? 'Guest' }}</h2>
        <p class="text-muted">Your personal academic workspace.</p>
    </div>

    {{-- TASK SUMMARY --}}
    <div class="card shadow-sm mb-4">
        <div class="card-header fw-bold bg-white">Task Summary</div>
        <div class="card-body d-flex gap-3 flex-wrap">
            <div class="flex-fill text-center rounded p-3 bg-warning bg-opacity-25">
                <div class="fs-1 fw-bold text-warning-emphasis">{{ $taskCounts['pending'] ?? 0 }}</div>
                <div class="small text-uppercase fw-semibold text-warning-emphasis">Pending</div>
            </div>
            <div class="flex-fill text-center rounded p-3 bg-primary bg-opacity-10">
                <div class="fs-1 fw-bold text-primary">{{ $taskCounts['in_progress'] ?? 0 }}</div>
                <div class="small text-uppercase fw-semibold text-primary">In Progress</div>
            </div>
            <div class="flex-fill text-center rounded p-3 bg-success bg-opacity-10">
                <div class="fs-1 fw-bold text-success">{{ $taskCounts['completed'] ?? 0 }}</div>
                <div class="small text-uppercase fw-semibold text-success">Done</div>
            </div>
        </div>
    </div>

    {{-- TASKS / NOTES / RESOURCES --}}
    <div class="row p-2 g-4">
        {{-- TASKS --}}
        <div class="col-12 col-md-4">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <span class="fw-bold">Tasks</span>
                    <button class="btn btn-sm btn-dark" data-bs-toggle="modal" data-bs-target="#taskModal">
                        + Add Task
                    </button>
                </div>
                <div class="d-flex gap-2 flex-wrap small text-muted p-2 mx-3">
                    <span><span class="badge bg-warning text-dark">&nbsp;</span> Pending</span>
                    <span><span class="badge bg-primary">&nbsp;</span> In Progress</span>
                    <span><span class="badge bg-success">&nbsp;</span> Done</span>
                </div>
                <div class="card-body border task-scroll" style="max-height: 400px; overflow-y: auto;">
                    @forelse ($tasks as $task)
                        <div class="task-item">
                            <div>
                                @php
                                    $badgeMap = [
                                        'pending' => 'warning text-dark',
                                        'in_progress' => 'primary',
                                        'completed' => 'success',
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
                                <button class="btn btn-sm btn-outline-secondary py-0 px-1" data-bs-toggle="modal"
                                    data-bs-target="#editTaskModal" data-id="{{ $task->id }}"
                                    data-task_name="{{ $task->task_name }}" data-due_date="{{ $task->due_date }}"
                                    data-subject="{{ $task->subject }}" data-status="{{ $task->status }}" title="Edit">
                                    <i class="fas fa-pen fa-xs"></i>
                                </button>
                                <form action="/tasks/{{ $task->id }}" method="POST"
                                    onsubmit="return confirm('Delete this task?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger py-0 px-1" title="Delete">
                                        <i class="fas fa-trash fa-xs"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    @empty
                        <p class="text-muted small">No tasks yet.</p>
                    @endforelse
                </div>
            </div>
        </div>
        {{-- NOTES / RESOURCES --}}
        <div class="col-12 col-md-4">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <span class="fw-bold">Resources</span>
                    <button class="btn btn-sm btn-dark" data-bs-toggle="modal" data-bs-target="#noteModal">
                        + Add Resources
                    </button>
                </div>
                <div class="card-body p-0 task-scroll" style="max-height: 400px; overflow-y: auto;">
                    <ul class="list-group border shadow-sm list-group-flush">
                        @forelse ($notes as $note)
                            <li class="list-group-item px-3 py-2">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="min-vw-0">
                                        <div class="fw-bold mb-0 text-truncate">{{ $note->name }}</div>
                                        <div class="d-flex gap-2">
                                            <small class="text-muted text-truncate">
                                                <i class="fas fa-link fa-xs"></i> {{ $note->url }}
                                            </small>
                                        </div>
                                        <small class="text-muted">
                                            <i class="far fa-calendar-alt fa-xs"></i> {{ $note->date }}
                                        </small>
                                    </div>
                                    <div class="d-flex align-items-center gap-1">
                                        <button class="btn btn-link text-secondary p-1" data-bs-toggle="modal"
                                            data-bs-target="#editNoteModal" data-id="{{ $note->id }}"
                                            data-name="{{ $note->name }}" data-string="{{ $note->edit ?? '' }}"
                                            data-url="{{ $note->url }}" data-date="{{ $note->date }}" title="Edit">
                                            <i class="fas fa-pen fa-xs"></i>
                                        </button>
                                        <form action="/dashboard/{{ $note->id }}" method="POST" class="m-0"
                                            onsubmit="return confirm('Delete this note?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-link text-danger p-1" title="Delete">
                                                <i class="fas fa-trash fa-xs"></i>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </li>
                        @empty
                            <div class="p-3 text-center">
                                <p class="text-muted small mb-0">No resources yet.</p>
                            </div>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>

        {{-- TODAY'S FOCUS --}}
        <div class="col-12 col-md-4">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <span class="fw-bold">Today's Focus</span>
                    <button class="btn btn-sm btn-outline-danger border-0" onclick="clearFocus()">
                        <i class="fas fa-redo fa-xs"></i>
                    </button>
                </div>
                <div class="card-body d-flex flex-column justify-content-center align-items-center p-4">
                    <textarea id="focus-input" class="form-control border-0 text-center fw-bold"
                        placeholder="What is your main goal?" style="font-size: 1.5rem; resize: none; background: transparent;"
                        rows="3"></textarea>
                    <p class="text-muted small mt-2">Current priority</p>
                </div>
            </div>
        </div>
    </div>

    {{-- ===================== MODALS ===================== --}}

    {{-- Add Task Modal --}}
    <div class="modal fade" id="taskModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add New Task</h5>
                    <button class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form action="/tasks" method="POST">
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
                            <input type="text" class="form-control" name="subject" required/>
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

    {{-- Edit Task Modal --}}
    <div class="modal fade" id="editTaskModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Task</h5>
                    <button class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="editTaskForm" action="" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label class="form-label">Task Name</label>
                            <input type="text" class="form-control" name="task_name" id="edit_task_name" required />
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Due Date</label>
                            <input type="date" class="form-control" name="due_date" id="edit_due_date" required />
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Subject</label>
                            <input type="text" class="form-control" name="subject" id="edit_subject" />
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Status</label>
                            <select class="form-select" name="status" id="edit_status" required>
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

    {{-- Add Note Modal --}}
    <div class="modal fade" id="noteModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add New Note</h5>
                    <button class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form action="/dashboard" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Resource Title</label>
                            <input type="text" class="form-control" name="name" required />
                        </div>
                        <div class="mb-3">
                            <label class="form-label">URL</label>
                            <input type="url" class="form-control" name="url" required />
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Date</label>
                            <input type="date" class="form-control" name="date" required />
                        </div>
                        <button type="submit" class="btn btn-dark w-100">Add Note</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- Edit Note Modal --}}
    <div class="modal fade" id="editNoteModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Note</h5>
                    <button class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="editNoteForm" action="" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label class="form-label">Resource Title</label>
                            <input type="text" class="form-control" name="name" id="edit_name" required />
                        </div>
                        <div class="mb-3">
                            <label class="form-label">URL</label>
                            <input type="url" class="form-control" name="url" id="edit_url" required />
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Date</label>
                            <input type="date" class="form-control" name="date" id="edit_date" required />
                        </div>
                        <button type="submit" class="btn btn-dark w-100">Save Changes</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        // Edit Task Modal - populate fields
        const editTaskModal = document.getElementById('editTaskModal');
        if (editTaskModal) {
            editTaskModal.addEventListener('show.bs.modal', function(event) {
                const btn = event.relatedTarget;
                document.getElementById('edit_task_name').value = btn.dataset.task_name;
                document.getElementById('edit_due_date').value = btn.dataset.due_date;
                document.getElementById('edit_subject').value = btn.dataset.subject;
                document.getElementById('edit_status').value = btn.dataset.status;
                document.getElementById('editTaskForm').action = '/tasks/' + btn.dataset.id;
            });
        }

        // Edit Note Modal - populate fields
        const editNoteModal = document.getElementById('editNoteModal');
        if (editNoteModal) {
            editNoteModal.addEventListener('show.bs.modal', function(event) {
                const btn = event.relatedTarget;
                document.getElementById('edit_name').value = btn.dataset.name;
                document.getElementById('edit_url').value = btn.dataset.url;
                document.getElementById('edit_date').value = btn.dataset.date;
                document.getElementById('editNoteForm').action = '/notes/' + btn.dataset.id;
            });
        }

      document.addEventListener("DOMContentLoaded", function() {
    // Kinukuha natin ang ID ng user mula sa Laravel Auth
    const userId = "{{ Auth::id() }}"; 
    const storageKey = `daily_focus_${userId}`; // Halimbawa: daily_focus_1
    
    const focusInput = document.getElementById('focus-input');

    // 1. Load data based sa User ID
    const savedFocus = localStorage.getItem(storageKey);
    if (savedFocus) {
        focusInput.value = savedFocus;
    }

    // 2. Save data based sa User ID
    focusInput.addEventListener('input', function(e) {
        localStorage.setItem(storageKey, e.target.value);
    });
});

function clearFocus() {
    const userId = "{{ Auth::id() }}";
    const storageKey = `daily_focus_${userId}`;
    
    if(confirm('Clear your focus?')) {
        document.getElementById('focus-input').value = '';
        localStorage.removeItem(storageKey);
    }
}
    </script>
@endsection