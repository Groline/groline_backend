@extends('layouts.contentNavbarLayout')

@section('title', __('Brands'))

@section('content')

    <h4 class="fw-bold py-3 mb-3 row justify-content-between">
        <div class="col-md-auto">
            <span class="text-muted fw-light">{{ __('Brands') }} /</span> {{ __('Browse brands') }}
        </div>
        <div class="col-md-auto d-flex gap-2">
            <button type="button" class="btn btn-success" id="add_brands_to_home_btn">{{ __('Add to Homepage') }}</button>
            <button type="button" class="btn btn-primary" id="create">{{ __('Add brand') }}</button>
        </div>
    </h4>

    <div class="card">
        <div class="table-responsive text-nowrap">
            <div class="table-header row justify-content-between">
                <h5 class="col-md-auto">{{ __('Brands table') }}</h5>
            </div>
            <table class="table" id="laravel_datatable">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>{{ __('Name') }}</th>
                        <th>{{ __('Created at') }}</th>
                        <th>{{ __('Status') }}</th>
                        <th>{{ __('Published') }}</th>
                        <th>{{ __('Actions') }}</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>

    {{-- Brand modal --}}
    <div class="modal fade" id="modal" aria-hidden="true">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="fw-bold py-1 mb-1"></h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="text" id="form_type" hidden />
                    <input type="text" class="form-control" id="id" name="id" hidden />
                    <form class="form-horizontal" onsubmit="event.preventDefault()" action="#" enctype="multipart/form-data"
                        id="form">
                        <div class="card-body">
                            <div class="d-flex align-items-start align-items-sm-center gap-4">
                                <div hidden><img src="{{ asset('assets/img/icons/file-not-found.jpg') }}" alt="image"
                                        class="d-block rounded" height="100" width="100" id="old-image" /></div>
                                <img src="{{ asset('assets/img/icons/file-not-found.jpg') }}" alt="image"
                                    class="d-block rounded" height="100" width="100" id="uploaded-image" />
                                <div class="button-wrapper">
                                    <label for="image" class="btn btn-primary" tabindex="0">
                                        <span class="d-none d-sm-block">{{ __('New image') }}</span>
                                        <i class="bx bx-upload d-block d-sm-none"></i>
                                        <input class="image-input" type="file" id="image" name="image" hidden
                                            accept="image/png, image/jpeg" />
                                    </label>
                                    <button type="button" class="btn btn-outline-secondary image-reset">
                                        <i class="bx bx-reset d-block d-sm-none"></i>
                                        <span class="d-none d-sm-block">{{ __('Reset') }}</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <hr class="my-0">
                        <div class="mb-3">
                            <label class="form-label" for="name_ar">{{ __('Name in Arabic') }}</label>
                            <input type="text" class="form-control" id="name_ar" name="name_ar" />
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="name_en">{{ __('Name in English') }}</label>
                            <input type="text" class="form-control" id="name_en" name="name_en" />
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="name_fr">{{ __('Name in French') }}</label>
                            <input type="text" class="form-control" id="name_fr" name="name_fr" />
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="slug">Slug</label>
                            <input type="text" class="form-control" id="slug" name="slug" />
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="status">Status</label>
                            <select class="form-control" id="status" name="status">
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
                            </select>
                        </div>
                        <div class="mb-3" style="text-align: center">
                            <button type="submit" id="submit" name="submit"
                                class="btn btn-primary">{{ __('Send') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- Add brands to home modal --}}
    <div class="modal fade" id="home_modal" aria-hidden="true">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="fw-bold py-1 mb-1">{{ __('Add Brands to Homepage') }}</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">{{ __('Select Brands') }}</label>
                        <select class="selectpicker form-control" id="home_brands" name="home_brands" multiple
                            data-live-search="true">
                            @foreach ($brands as $brand)
                                <option value="{{ $brand->id }}">{{ $brand->name_ar }} - {{ $brand->name_en }}</option>
                            @endforeach
                        </select>
                        <small class="text-muted">{{ __('Number of brands must be 4 or 6') }}</small>
                    </div>
                    <div class="mb-3" style="text-align: center">
                        <button type="button" id="home_submit" class="btn btn-primary">{{ __('Send') }}</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('page-script')
    <script>
        $(document).ready(function () {
            load_data();

            function load_data() {
                var table = $('#laravel_datatable').DataTable({
                    language: {!! file_get_contents(base_path('lang/' . session('locale', 'en') . '/datatable.json')) !!},
                    responsive: true,
                    processing: true,
                    serverSide: true,
                    pageLength: 10,
                    ajax: { url: "{{ url('brand/list') }}" },
                    type: 'GET',
                    columns: [
                        { data: 'DT_RowIndex', name: 'DT_RowIndex' },
                        { data: 'name_ar', name: 'name_ar' },
                        { data: 'created_at', name: 'created_at' },
                        { data: 'status', name: 'status', orderable: false, searchable: false },
                        {
                            data: 'is_published',
                            name: 'is_published',
                            render: function (data) {
                                return data == false
                                    ? '<span class="badge bg-danger">{{ __('No') }}</span>'
                                    : '<span class="badge bg-success">{{ __('Yes') }}</span>';
                            }
                        },
                        { data: 'action', name: 'action', searchable: false, orderable: false }
                    ]
                });
            }

            // ==================== Create ====================
            $('#create').on('click', function () {
                document.getElementById('form').reset();
                document.getElementById('form_type').value = "create";
                document.getElementById('uploaded-image').src = "{{ asset('assets/img/icons/file-not-found.jpg') }}";
                document.getElementById('old-image').src = "{{ asset('assets/img/icons/file-not-found.jpg') }}";
                $("#modal").modal('show');
            });

            // ==================== Update ====================
            $(document.body).on('click', '.update', function () {
                document.getElementById('form').reset();
                document.getElementById('form_type').value = "update";
                var brand_id = $(this).attr('table_id');
                $("#id").val(brand_id);

                $.ajax({
                    url: '{{ url('brand/update') }}',
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                    type: 'POST',
                    data: { brand_id: brand_id },
                    dataType: 'JSON',
                    success: function (response) {
                        if (response.status == 1) {
                            document.getElementById('id').value = response.data.id;
                            document.getElementById('name_ar').value = response.data.name_ar;
                            document.getElementById('name_en').value = response.data.name_en;
                            document.getElementById('name_fr').value = response.data.name_fr;

                            var image = response.data.image == null
                                ? "{{ asset('assets/img/icons/file-not-found.jpg') }}"
                                : response.data.image;

                            document.getElementById('uploaded-image').src = image;
                            document.getElementById('old-image').src = image;
                            $("#modal").modal("show");
                        }
                    }
                });
            });

            // ==================== Submit (Create/Update) ====================
            $('#submit').on('click', function () {
                var formdata = new FormData($("#form")[0]);
                var formtype = document.getElementById('form_type').value;

                if (formtype == "create") url = "{{ url('brand/create') }}";
                if (formtype == "update") {
                    url = "{{ url('brand/update') }}";
                    formdata.append("brand_id", document.getElementById('id').value);
                }

                $("#modal").modal("hide");

                $.ajax({
                    url: url,
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                    type: 'POST',
                    data: formdata,
                    dataType: 'JSON',
                    contentType: false,
                    processData: false,
                    success: function (response) {
                        if (response.status == 1) {
                            Swal.fire({
                                title: "{{ __('Success') }}",
                                text: "{{ __('success') }}",
                                icon: 'success',
                                confirmButtonText: 'Ok'
                            }).then(() => { $('#laravel_datatable').DataTable().ajax.reload(); });
                        } else {
                            Swal.fire("{{ __('Error') }}", response.message, 'error');
                        }
                    },
                    error: function (data) {
                        Swal.fire("{{ __('Error') }}", data.responseJSON.message, 'error');
                    }
                });
            });

            // ==================== Delete ====================
            $(document.body).on('click', '.delete', function () {
                var brand_id = $(this).attr('table_id');

                Swal.fire({
                    title: "{{ __('Warning') }}",
                    text: "{{ __('Are you sure?') }}",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: "{{ __('Delete') }}",
                    cancelButtonText: "{{ __('Cancel') }}"
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "{{ url('brand/delete') }}",
                            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                            type: 'POST',
                            data: { brand_id: brand_id },
                            dataType: 'JSON',
                            success: function (response) {
                                if (response.status == 1) {
                                    Swal.fire("{{ __('Success') }}", "{{ __('success') }}", 'success')
                                        .then(() => { $('#laravel_datatable').DataTable().ajax.reload(); });
                                } else {
                                    Swal.fire("{{ __('Error') }}", response.message, 'error');
                                }
                            }
                        });
                    }
                });
            });

            // ==================== Add to Home (per row) ====================
            $(document.body).on('click', '.add_to_home', function () {
                var brand_id = $(this).attr('table_id');

                Swal.fire({
                    title: "{{ __('Warning') }}",
                    text: "{{ __('Are you sure?') }}",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: "{{ __('Yes') }}",
                    cancelButtonText: "{{ __('No') }}"
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "{{ url('section/add') }}",
                            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                            type: 'POST',
                            data: { type: "brand", element: brand_id },
                            dataType: 'JSON',
                            success: function (response) {
                                if (response.status == 1) {
                                    Swal.fire("{{ __('Success') }}", "{{ __('success') }}", 'success')
                                        .then(() => { $('#laravel_datatable').DataTable().ajax.reload(); });
                                } else {
                                    Swal.fire("{{ __('Error') }}", response.message, 'error');
                                }
                            }
                        });
                    }
                });
            });

            // ==================== Remove from Home ====================
            $(document.body).on('click', '.remove_from_home', function () {
                var section_id = $(this).attr('table_id');

                Swal.fire({
                    title: "{{ __('Warning') }}",
                    text: "{{ __('Are you sure?') }}",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: "{{ __('Yes') }}",
                    cancelButtonText: "{{ __('No') }}"
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "{{ url('section/delete') }}",
                            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                            type: 'POST',
                            data: { section_id: section_id },
                            dataType: 'JSON',
                            success: function (response) {
                                if (response.status == 1) {
                                    Swal.fire("{{ __('Success') }}", "{{ __('success') }}", 'success')
                                        .then(() => { $('#laravel_datatable').DataTable().ajax.reload(); });
                                } else {
                                    Swal.fire("{{ __('Error') }}", response.message, 'error');
                                }
                            }
                        });
                    }
                });
            });

            // ==================== Add multiple brands to Home ====================
            $('#add_brands_to_home_btn').on('click', function () {
                $('#home_brands').selectpicker('val', []);
                $('#home_modal').modal('show');
            });

            $('#home_submit').on('click', function () {
                var selected = $('#home_brands').val();

                if (!selected || (selected.length !== 4 && selected.length !== 6)) {
                    Swal.fire(
                        "{{ __('Error') }}",
                        "{{ __('Number of brands must be 4 or 6') }}",
                        'error'
                    );
                    return;
                }

                $('#home_modal').modal('hide');

                $.ajax({
                    url: "{{ url('section/add') }}",
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                    type: 'POST',
                    data: { type: "brand", elements: selected },
                    dataType: 'JSON',
                    success: function (response) {
                        if (response.status == 1) {
                            Swal.fire("{{ __('Success') }}", "{{ __('success') }}", 'success')
                                .then(() => { $('#laravel_datatable').DataTable().ajax.reload(); });
                        } else {
                            Swal.fire("{{ __('Error') }}", response.message, 'error');
                        }
                    },
                    error: function (data) {
                        Swal.fire("{{ __('Error') }}", data.responseJSON.message, 'error');
                    }
                });
            });

            // ==================== Image ====================
            $(document.body).on('change', '.image-input', function () {
                const fileInput = document.querySelector('.image-input');
                if (fileInput.files[0]) {
                    document.getElementById('uploaded-image').src = window.URL.createObjectURL(fileInput.files[0]);
                }
            });

            $(document.body).on('click', '.image-reset', function () {
                const fileInput = document.querySelector('.image-input');
                fileInput.value = '';
                document.getElementById('uploaded-image').src = document.getElementById('old-image').src;
            });

            // ==================== Modal Header ====================
            $('#modal').on('show.bs.modal', function () {
                var formType = $(this).find('#form_type').val();
                var headerH4 = $(this).find('.modal-header h4');
                if (formType === 'create') {
                    headerH4.text("{{ __('Add Brand') }}");
                } else if (formType === 'update') {
                    headerH4.text("{{ __('Edit Brand') }}");
                }
            });
        });
    </script>
@endsection