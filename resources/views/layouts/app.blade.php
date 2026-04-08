<!doctype html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>@yield('title', 'ScholarHub')</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
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
    /* Active nav link styling */
    .nav-link.active {
      background-color: #e9ecef !important;
      font-weight: 600 !important;
      color: #0d6efd !important;
    }
  </style>
  @stack('styles')
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
      <aside class="col-lg-2 d-none d-lg-flex flex-column justify-content-between bg-white border-end p-3 sticky-top"
        style="min-height: calc(100vh - 56px); top: 56px;">

        <div>
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
            <a href="{{ url('/dashboard') }}" class="nav-link rounded px-3 py-2 text-dark {{ request()->is('dashboard') ? 'active' : '' }}">
              <i class="fas fa-th-large me-2"></i> Dashboard
            </a>
            <a href="{{ url('/pages') }}" class="nav-link rounded px-3 py-2 text-dark {{ request()->is('pages') ? 'active' : '' }}">
              <i class="fas fa-sticky-note me-2"></i> Pages
            </a>
          </nav>
        </div>

        <div>
          <button class="btn btn-outline-danger w-100" data-bs-toggle="modal" data-bs-target="#logoutConfirmModal">
            <i class="fas fa-sign-out-alt me-2"></i> Log Out
          </button>
        ->
          <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
          </form>
        </div>

      </aside>

      {{-- MOBILE SIDEBAR --}}
      <div class="offcanvas offcanvas-start" style="width:260px" tabindex="-1" id="mobileSidebar">
        <div class="offcanvas-header border-bottom">
          <span class="fw-bold"><i class="fas fa-book-open me-2"></i>ScholarHub</span>
          <button class="btn-close" data-bs-dismiss="offcanvas"></button>
        </div>
        <div class="offcanvas-body d-flex flex-column justify-content-between p-3">

          <div>
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
              <a href="{{ url('/dashboard') }}" class="nav-link rounded px-3 py-2 text-dark {{ request()->is('dashboard') ? 'active' : '' }}">
                <i class="fas fa-th-large me-2"></i> Dashboard
              </a>
              <a href="{{ url('/pages') }}" class="nav-link rounded px-3 py-2 text-dark {{ request()->is('pages') ? 'active' : '' }}">
                <i class="fas fa-sticky-note me-2"></i> Pages
              </a>
            </nav>
          </div>

          <div>
            <button class="btn btn-outline-danger w-100" data-bs-toggle="modal" data-bs-target="#logoutConfirmModal">
              <i class="fas fa-sign-out-alt me-2"></i> Log Out
            </button>
            <form id="logout-form-mobile" action="{{ route('logout') }}" method="POST" style="display: none;">
              @csrf
            </form>
          </div>

        </div>
      </div>

      {{-- MAIN CONTENT --}}
      <main class="col-lg-10 p-4">
        @yield('content')
      </main>

    </div>
  </div>

  {{-- LOGOUT CONFIRMATION MODAL --}}
  <div class="modal fade" id="logoutConfirmModal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-body text-center py-4">
          <i class="fas fa-sign-out-alt fa-3x text-secondary mb-3"></i>
          <h5 class="fw-semibold mb-2">Confirm Logout</h5>
          <p class="text-muted mb-4">Are you sure you want to log out of your account?</p>
          <div class="d-flex justify-content-center gap-3">
            <button type="button" class="btn btn-outline-secondary px-4" data-bs-dismiss="modal">Cancel</button>
            <button type="button" class="btn btn-danger px-4" id="confirmLogoutBtn">Logout</button>
          </div>
        </div>
      </div>
    </div>
  </div>

  @yield('scripts')
  @stack('scripts')
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    // Handle logout confirmation – submit the appropriate form based on which logout button was clicked
    (function() {
      let activeForm = null;

      // When any logout button is clicked, store which form it should trigger
      document.querySelectorAll('[data-bs-target="#logoutConfirmModal"]').forEach(button => {
        button.addEventListener('click', function(e) {
          // Determine which form is associated with this button
          if (this.closest('.sidebar') || this.closest('.offcanvas-body')) {
            // Desktop sidebar or mobile offcanvas – find the hidden form next to it
            const container = this.closest('.sidebar, .offcanvas-body');
            if (container) {
              const form = container.querySelector('form[id^="logout-form"]');
              if (form) activeForm = form;
            }
          }
          // If not found, fallback to the first logout form (shouldn't happen)
          if (!activeForm) {
            activeForm = document.getElementById('logout-form') || document.getElementById('logout-form-mobile');
          }
        });
      });

      // Confirm button inside modal
      const confirmBtn = document.getElementById('confirmLogoutBtn');
      if (confirmBtn) {
        confirmBtn.addEventListener('click', function() {
          if (activeForm) {
            activeForm.submit();
          } else {
            // Fallback: submit the first available logout form
            const form = document.getElementById('logout-form') || document.getElementById('logout-form-mobile');
            if (form) form.submit();
          }
        });
      }

      // Reset activeForm when modal is hidden
      const modal = document.getElementById('logoutConfirmModal');
      if (modal) {
        modal.addEventListener('hidden.bs.modal', function() {
          activeForm = null;
        });
      }
    })();
  </script>
</body>

</html>