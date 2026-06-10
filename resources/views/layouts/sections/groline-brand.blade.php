<style id="groline-brand-inline">
  :root {
    --groline-orange: #ff6500;
    --groline-orange-dark: #df5400;
    --groline-orange-soft: #fff0e4;
    --groline-peach: #fff7f0;
    --groline-ink: #2b2f33;
    --groline-line: #ffd0ae;
  }

  html body {
    color: var(--groline-ink) !important;
    background:
      radial-gradient(circle at 100% 0, rgba(255, 101, 0, 0.16), transparent 34rem),
      linear-gradient(180deg, #fffaf6 0%, var(--groline-peach) 48%, #fff 100%) !important;
  }

  html body:before {
    content: "";
    position: fixed;
    inset: 0 0 auto;
    z-index: 99999;
    height: 6px;
    pointer-events: none;
    background: linear-gradient(90deg, var(--groline-orange), #ff8b3d, var(--groline-orange));
  }

  .layout-wrapper,
  .layout-container,
  .layout-page,
  .content-wrapper {
    background: transparent !important;
  }

  .layout-menu.bg-menu-theme,
  .bg-menu-theme {
    background:
      linear-gradient(180deg, rgba(255, 101, 0, 0.12), rgba(255, 255, 255, 0) 9rem),
      rgba(255, 255, 255, 0.98) !important;
    border-right: 1px solid rgba(255, 101, 0, 0.18) !important;
    box-shadow: 0 16px 40px rgba(43, 47, 51, 0.1) !important;
  }

  .layout-navbar,
  #app .navbar {
    background:
      linear-gradient(135deg, rgba(255, 101, 0, 0.12), rgba(255, 255, 255, 0)),
      rgba(255, 255, 255, 0.94) !important;
    border: 1px solid rgba(255, 101, 0, 0.16) !important;
    box-shadow: 0 10px 30px rgba(43, 47, 51, 0.08) !important;
  }

  .menu .app-brand.demo {
    height: 78px !important;
    margin-top: 0 !important;
    background:
      linear-gradient(135deg, rgba(255, 101, 0, 0.18), rgba(255, 101, 0, 0.04)),
      #fff !important;
    border-bottom: 1px solid rgba(255, 101, 0, 0.18) !important;
  }

  .app-brand-text,
  .app-brand-text.demo,
  #app .navbar-brand,
  a,
  .text-primary {
    color: var(--groline-orange) !important;
  }

  .app-brand-text.demo,
  #app .navbar-brand {
    font-weight: 800 !important;
    letter-spacing: 0 !important;
    text-transform: uppercase !important;
  }

  .app-brand .app-brand-link img {
    width: 42px !important;
    max-height: 42px !important;
    object-fit: contain !important;
  }

  .authentication-wrapper .app-brand .app-brand-link img {
    width: 76px !important;
    max-height: 76px !important;
    padding: 0.35rem !important;
    border-radius: 50% !important;
    background: #fff !important;
    box-shadow: 0 10px 28px rgba(255, 101, 0, 0.24) !important;
  }

  .card,
  .modal-content,
  .dropdown-menu,
  .swal2-popup {
    border: 1px solid rgba(255, 101, 0, 0.14) !important;
    border-radius: 0.5rem !important;
    box-shadow: 0 14px 36px rgba(43, 47, 51, 0.08) !important;
  }

  .btn-primary,
  .btn-primary:focus,
  .btn-primary:active,
  .swal2-confirm,
  .swal2-styled.swal2-confirm {
    background-color: var(--groline-orange) !important;
    border-color: var(--groline-orange) !important;
    color: #fff !important;
  }

  .btn-primary:hover {
    background-color: var(--groline-orange-dark) !important;
    border-color: var(--groline-orange-dark) !important;
  }

  .btn-outline-primary {
    color: var(--groline-orange) !important;
    border-color: var(--groline-orange) !important;
  }

  .menu-link,
  .menu-item .menu-link {
    border-radius: 0.5rem !important;
  }

  .menu-link i,
  .menu-link .menu-icon,
  .navbar i {
    color: var(--groline-orange) !important;
  }

  .bg-menu-theme .menu-inner > .menu-item.active > .menu-link,
  .bg-menu-theme .menu-inner > .menu-item.open > .menu-link,
  .bg-menu-theme .menu-inner .menu-item .menu-link:hover {
    color: var(--groline-orange) !important;
    background: var(--groline-orange-soft) !important;
  }

  .bg-menu-theme .menu-inner > .menu-item.active:before,
  .bg-menu-theme .menu-sub > .menu-item.active > .menu-link:not(.menu-toggle):before {
    background: var(--groline-orange) !important;
  }

  .form-control,
  .form-select,
  .bootstrap-select > .dropdown-toggle,
  .filter-select {
    border-color: var(--groline-line) !important;
    border-radius: 0.5rem !important;
  }

  .form-control:focus,
  .form-select:focus,
  .filter-select:focus {
    border-color: var(--groline-orange) !important;
    box-shadow: 0 0 0 0.18rem rgba(255, 101, 0, 0.14) !important;
  }

  .table thead th,
  table.dataTable thead th {
    color: var(--groline-ink) !important;
    background: #fff2e8 !important;
    border-bottom-color: var(--groline-line) !important;
  }

  .page-item.active .page-link,
  .pagination .page-link:hover,
  .badge.bg-label-primary,
  .bg-label-primary {
    background-color: var(--groline-orange-soft) !important;
    color: var(--groline-orange) !important;
  }

  .authentication-wrapper.authentication-basic {
    min-height: 100vh !important;
    background:
      linear-gradient(180deg, rgba(255, 255, 255, 0.92), rgba(255, 101, 0, 0.18)),
      repeating-linear-gradient(90deg, rgba(255, 101, 0, 0.06) 0 1px, transparent 1px 96px) !important;
  }

  .authentication-wrapper .card {
    overflow: hidden !important;
  }

  .authentication-wrapper .card:before {
    content: "";
    display: block;
    height: 136px;
    margin: -1.5rem -1.5rem 1.75rem;
    background:
      linear-gradient(135deg, rgba(255, 255, 255, 0.1), transparent),
      var(--groline-orange);
    border-bottom: 8px solid #fff;
    border-radius: 0 0 50% 50% / 0 0 22% 22%;
  }

  .authentication-wrapper .app-brand {
    margin-top: -116px !important;
    margin-bottom: 2rem !important;
    position: relative !important;
    z-index: 1 !important;
  }
</style>
