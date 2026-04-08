@extends('layouts.app')

@section('content')
    <style>
        .page-card {
            transition: transform 0.18s ease, box-shadow 0.18s ease;
            cursor: pointer;
        }

        .page-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.10) !important;
        }

        .page-icon-badge {
            font-size: 2rem;
            line-height: 1;
        }

        .page-preview {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
            font-size: .82rem;
        }

        /* ── Shared overlay ── */
        .page-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.55);
            z-index: 1055;
            align-items: center;
            justify-content: center;
        }

        .page-overlay.active {
            display: flex;
        }

        /* ── Editor panel ── */
        .editor-panel,
        .view-panel {
            background: #fff;
            border-radius: 12px;
            width: 95vw;
            max-width: 860px;
            height: 88vh;
            display: flex;
            flex-direction: column;
            overflow: hidden;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.25);
        }

        .editor-topbar,
        .view-topbar {
            display: flex;
            justify-content: flex-end;
            align-items: center;
            gap: 8px;
            padding: 12px 18px;
            border-bottom: 1px solid #f0f0f0;
            background: #fafafa;
            flex-shrink: 0;
        }

        .view-topbar {
            justify-content: space-between;
        }

        .editor-body,
        .view-body {
            flex: 1;
            overflow-y: auto;
            padding: 36px 48px;
        }

        .editor-icon {
            font-size: 3.2rem;
            cursor: pointer;
            user-select: none;
            margin-bottom: 8px;
            display: inline-block;
            transition: opacity 0.2s;
        }

        .editor-icon:hover {
            opacity: 0.65;
        }

        #editorTitle {
            font-size: 2rem;
            font-weight: 700;
            border: none;
            outline: none;
            width: 100%;
            margin-bottom: 18px;
            color: #1a1a1a;
            background: transparent;
            padding: 0;
        }

        #editorTitle::placeholder {
            color: #ccc;
            font-weight: 400;
        }

        #editorContent {
            font-size: 1rem;
            line-height: 1.8;
            outline: none;
            min-height: 200px;
            color: #333;
            background: transparent;
            word-wrap: break-word;
        }

        #editorContent:empty::before {
            content: 'Start writing…';
            color: #bbb;
        }

        #editorContent:focus::before {
            content: '';
        }

        /* ── View mode content ── */
        .view-page-icon {
            font-size: 3.2rem;
            margin-bottom: 8px;
            display: block;
        }

        .view-page-title {
            font-size: 2rem;
            font-weight: 700;
            color: #1a1a1a;
            margin-bottom: 18px;
            word-wrap: break-word;
        }

        .view-page-content {
            font-size: 1rem;
            line-height: 1.8;
            color: #333;
            word-wrap: break-word;
        }

        /* Normalize pasted/saved HTML — strip inline styles visually */
        .view-page-content * {
            font-family: inherit !important;
            font-size: inherit !important;
            color: inherit !important;
            background: transparent !important;
            white-space: normal !important;
        }

        .view-page-content p {
            margin-bottom: 1rem;
        }

        .view-page-content h1,
        .view-page-content h2,
        .view-page-content h3 {
            font-weight: 700;
            margin: 1.2rem 0 .5rem;
        }

        .view-page-content ul,
        .view-page-content ol {
            padding-left: 1.5rem;
            margin-bottom: 1rem;
        }

        .view-page-content li {
            margin-bottom: .25rem;
        }

        .view-page-content br {
            display: block;
            content: '';
            margin: .3rem 0;
        }

        .empty-state {
            padding: 60px 20px;
            color: #adb5bd;
        }

        @media (max-width: 576px) {

            .editor-body,
            .view-body {
                padding: 22px 18px;
            }

            #editorTitle,
            .view-page-title {
                font-size: 1.5rem;
            }

            .editor-panel,
            .view-panel {
                width: 100vw;
                height: 100vh;
                border-radius: 0;
            }
        }
    </style>

    {{-- Page Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
           <div>
        <h2 class="fw-bold">Pages</h2>
        <p class="text-muted">A distraction-free space for your long-form notes and documents.</p>
    </div>

        <button class="btn btn-dark" id="createPageBtn">
            <i class="fas fa-plus me-1"></i> Create Page
        </button>
    </div>

    {{-- Pages Grid --}}
    {{-- Page data is passed via a JS variable to avoid HTML attribute encoding issues --}}
    <script>
        const pagesData = {
            @foreach ($pages as $page)
                "{{ $page->id }}": {
                    id: "{{ $page->id }}",
                    title: {!! json_encode($page->title) !!},
                    content: {!! json_encode($page->content) !!},
                    date: "{{ $page->created_at->format('M d, Y') }}"
                },
            @endforeach
        };
    </script>

    <div class="row g-3">
        @forelse ($pages as $page)
            <div class="col-12 col-sm-6 col-lg-4">
                <div class="card shadow-sm h-100 page-card open-view-btn" data-id="{{ $page->id }}">
                    <div class="card-body d-flex flex-column">
                        <div class="page-icon-badge mb-2">📄</div>
                        <h5 class="card-title fw-semibold mb-1 text-truncate">{{ $page->title }}</h5>
                        <p class="text-muted page-preview mb-3">{{ strip_tags($page->content) }}</p>
                        <div class="text-muted mb-3" style="font-size:.75rem">
                            <i class="far fa-calendar-alt me-1"></i>
                            {{ $page->created_at->format('M d, Y') }}
                        </div>
                        <div class="mt-auto d-flex gap-2 pt-2 border-top">
                            <button class="btn btn-sm btn-outline-secondary flex-fill edit-page-btn" data-id="{{ $page->id }}">
                                <i class="fas fa-pen fa-xs me-1"></i> Edit
                            </button>
                            <form action="/pages/{{ $page->id }}" method="POST" class="flex-fill"
                                onsubmit="return confirm('Delete this page?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger w-100">
                                    <i class="fas fa-trash fa-xs me-1"></i> Delete
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="text-center empty-state">
                    <i class="fas fa-file-alt fa-3x mb-3 d-block" style="color:#dee2e6"></i>
                    <p class="mb-1">No pages yet.</p>
                    <small>Click <strong>Create Page</strong> to start writing.</small>
                </div>
            </div>
        @endforelse
    </div>



    <div class="page-overlay" id="viewOverlay">
        <div class="view-panel">
            <div class="view-topbar">
                <small class="text-muted" id="viewDate"></small>
                <div class="d-flex gap-2">
                    <button class="btn btn-sm btn-outline-secondary" id="viewEditBtn">
                        <i class="fas fa-pen me-1"></i> Edit
                    </button>
                    <button class="btn btn-sm btn-outline-secondary" id="closeViewBtn">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
            <div class="view-body">
                <span class="view-page-icon">📄</span>
                <div class="view-page-title" id="viewTitle"></div>
                <div class="view-page-content" id="viewContent"></div>
            </div>
        </div>
    </div>


    <div class="page-overlay" id="pageEditorOverlay">
        <div class="editor-panel">
            <div class="editor-topbar">
                <button class="btn btn-sm btn-outline-secondary" id="closeEditorBtn">
                    <i class="fas fa-times me-1"></i> Close
                </button>
                <button class="btn btn-sm btn-dark" id="savePageBtn">
                    <i class="fas fa-save me-1"></i> Save
                </button>
            </div>

            {{-- Hidden form — create --}}
            <form id="createPageForm" action="/pages" method="POST" style="display:none">
                @csrf
                <input type="hidden" name="title" id="createTitle">
                <input type="hidden" name="content" id="createContent">
            </form>

            {{-- Hidden form — update --}}
            <form id="updatePageForm" action="" method="POST" style="display:none">
                @csrf
                @method('PUT')
                <input type="hidden" name="title" id="updateTitle">
                <input type="hidden" name="content" id="updateContent">
            </form>

            <div class="editor-body">
                <span class="editor-icon" id="editorIcon">📄</span>
                <input type="text" id="editorTitle" placeholder="Untitled" autocomplete="off" />
                <div contenteditable="true" id="editorContent"></div>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
    <script>
        // ── Refs ──────────────────────────────────────────────────
        const editorOverlay = document.getElementById('pageEditorOverlay');
        const viewOverlay = document.getElementById('viewOverlay');
        const editorIcon = document.getElementById('editorIcon');
        const editorTitle = document.getElementById('editorTitle');
        const editorContent = document.getElementById('editorContent');
        const createForm = document.getElementById('createPageForm');
        const updateForm = document.getElementById('updatePageForm');

        let editingId = null;
        let currentView = null;

        const emojis = ['📄', '📝', '📚', '🧪', '📊', '💡', '🎯', '📖', '✏️', '🎨', '🔬', '📋'];

        // ── Cycle emoji icon ──────────────────────────────────────
        editorIcon.addEventListener('click', () => {
            let i = emojis.indexOf(editorIcon.textContent);
            editorIcon.textContent = emojis[(i + 1) % emojis.length];
        });

        // ── Open VIEW when clicking the card (not buttons) ────────
        document.querySelectorAll('.open-view-btn').forEach(card => {
            card.addEventListener('click', (e) => {
                if (e.target.closest('.edit-page-btn') || e.target.closest('form')) return;

                // Pull data from pagesData JS object instead of data attributes
                const pageId = card.dataset.id;
                const page = pagesData[pageId];
                if (!page) return;

                currentView = page;

                document.getElementById('viewTitle').textContent = page.title;
                document.getElementById('viewContent').innerHTML = page.content; // raw HTML, no escaping
                document.getElementById('viewDate').textContent = page.date;
                viewOverlay.classList.add('active');
            });
        });

        // ── Edit button inside view → switch to editor ────────────
        document.getElementById('viewEditBtn').addEventListener('click', () => {
            viewOverlay.classList.remove('active');
            openEditorWith(currentView.id, currentView.title, currentView.content);
        });

        // ── Close view ────────────────────────────────────────────
        document.getElementById('closeViewBtn').addEventListener('click', closeView);
        viewOverlay.addEventListener('click', e => { if (e.target === viewOverlay) closeView(); });

        function closeView() {
            viewOverlay.classList.remove('active');
            currentView = null;
        }

        // ── Create page button ────────────────────────────────────
        document.getElementById('createPageBtn').addEventListener('click', () => {
            editingId = null;
            editorTitle.value = '';
            editorContent.innerHTML = '';
            editorIcon.textContent = '📄';
            editorOverlay.classList.add('active');
            setTimeout(() => editorTitle.focus(), 120);
        });

        // ── Edit from card ────────────────────────────────────────
        document.querySelectorAll('.edit-page-btn').forEach(btn => {
            btn.addEventListener('click', e => {
                e.stopPropagation();
                const page = pagesData[btn.dataset.id];
                if (!page) return;
                openEditorWith(page.id, page.title, page.content);
            });
        });

        function openEditorWith(id, title, content) {
            editingId = id;
            editorTitle.value = title;
            editorContent.innerHTML = content; // raw HTML, renders correctly
            editorIcon.textContent = '📄';
            updateForm.action = '/pages/' + id;
            editorOverlay.classList.add('active');
            setTimeout(() => editorTitle.focus(), 120);
        }

        // ── Close editor ──────────────────────────────────────────
        document.getElementById('closeEditorBtn').addEventListener('click', closeEditor);
        editorOverlay.addEventListener('click', e => { if (e.target === editorOverlay) closeEditor(); });

        function closeEditor() {
            if (!editingId && (editorTitle.value.trim() || editorContent.innerHTML.trim())) {
                if (!confirm('Discard unsaved changes?')) return;
            }
            editorOverlay.classList.remove('active');
            editingId = null;
        }

        // ── Save ──────────────────────────────────────────────────
        document.getElementById('savePageBtn').addEventListener('click', () => {
            const title = editorTitle.value.trim();
            const content = editorContent.innerHTML.trim();

            if (!title) {
                editorTitle.focus();
                editorTitle.style.outline = '2px solid #dc3545';
                setTimeout(() => editorTitle.style.outline = '', 1500);
                return;
            }

            if (editingId) {
                document.getElementById('updateTitle').value = title;
                document.getElementById('updateContent').value = content;
                updateForm.submit();
            } else {
                document.getElementById('createTitle').value = title;
                document.getElementById('createContent').value = content;
                createForm.submit();
            }
        });
    </script>
@endsection