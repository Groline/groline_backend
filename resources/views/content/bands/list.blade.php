@extends('layouts.contentNavbarLayout')

@section('title', __('Bands'))

@section('content')

    <h4 class="fw-bold py-3 mb-3 row justify-content-between">
        <div class="col-md-auto">
            <span class="text-muted fw-light">{{ __('Bands') }} /</span> {{ __('Browse bands') }}
        </div>
        <div class="col-md-auto">
            <button type="button" class="btn btn-primary" id="create">{{ __('Add band') }}</button>
        </div>
    </h4>

    <div class="card">
        <div class="table-responsive text-nowrap">
            <div class="table-header row justify-content-between">
                <h5 class="col-md-auto">{{ __('Bands table') }}</h5>
            </div>
            <table class="table" id="laravel_datatable">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>{{ __('Name') }}</th>
                        <th>{{ __('Created at') }}</th>
                        <th>{{ __('Brands') }}</th>
                        <th>{{ __('Published') }}</th>
                        <th>{{ __('Actions') }}</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>

    {{-- Band modal --}}
    <div class="modal fade" id="modal" aria-hidden="true">
        <div class="modal-dialog modal-sm" role="document">
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
                            <label class="form-label" for="brands">{{ __('Brands') }}</label>
                            <select class="selectpicker form-control" id="brands" name="brands" multiple
                                data-live-search="true">
                                @foreach ($brands as $brand)
                                    <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                                @endforeach
                            </select>
                            <small>{{ __('Number of brands must be 4 or 6') }}</small>
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
                    ajax: { url: "{{ url('band/list') }}" },
                    type: 'GET',
                    columns: [
                        { data: 'DT_RowIndex', name: 'DT_RowIndex' },
                        { data: 'name', name: 'name' },
                        { data: 'created_at', name: 'created_at' },
                        { data: 'brands', name: 'brands' },
                        {
                            data: 'is_published',
                            name: 'is_published',
                            render: function (data) {
                                return data == false
                                    ? '<span class="badge bg-danger">{{ __('No') }}</span>'
                                    : '<span class="badge bg-success">{{ __('Yes') }}</span>';
                            }
                        },
                        { data: 'action', name: 'action', searchable: false }
                    ]
                });
            }

            // ==================== Create ====================
            $('#create').on('click', function () {
                document.getElementById('form').reset();
                document.getElementById('form_type').value = "create";
                $('#brands').selectpicker('val', []);
                $("#modal").modal('show');
            });

            // ==================== Update ====================
            $(document.body).on('click', '.update', function () {
                document.getElementById('form').reset();
                document.getElementById('form_type').value = "update";
                var band_id = $(this).attr('table_id');
                $("#id").val(band_id);

                $.ajax({
                    url: '{{ url('band/update') }}',
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                    type: 'POST',
                    data: { band_id: band_id },
                    dataType: 'JSON',
                    success: function (response) {
                        if (response.status == 1) {
                            document.getElementById('name_ar').value = response.data.name_ar;
                            document.getElementById('name_en').value = response.data.name_en;
                            document.getElementById('name_fr').value = response.data.name_fr;

                            $.ajax({
                                url: '{{ url('api/v1/brand/get?all=1') }}',
                                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                                type: 'POST',
                                data: { band_id: band_id },
                                dataType: 'JSON',
                                success: function (response) {
                                    if (response.status == 1) {
                                        const getKey = (array, key) => array.map(a => a[key]);
                                        var options = getKey(response.data, 'id');
                                        $('#brands').selectpicker('val', options);
                                        $("#modal").modal("show");
                                    }
                                }
                            });
                        }
                    }
                });
            });

            // ==================== Submit (Create/Update) ====================
            $('#submit').on('click', function () {
                var formdata = new FormData();
                formdata.append('name_ar', $("#name_ar").val());
                formdata.append('name_en', $("#name_en").val());
                formdata.append('name_fr', $("#name_fr").val());

                var brands = document.getElementById('brands');
                for (var i = 0; i < brands.options.length; i++) {
                    if (brands.options[i].selected) {
                        formdata.append(`brands[${i}]`, brands.options[i].value);
                    }
                }

                var formtype = document.getElementById('form_type').value;

                if (formtype == "create") url = "{{ url('band/create') }}";
                if (formtype == "update") {
                    url = "{{ url('band/update') }}";
                    formdata.append("band_id", document.getElementById('id').value);
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
                var band_id = $(this).attr('table_id');

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
                            url: "{{ url('band/delete') }}",
                            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                            type: 'POST',
                            data: { band_id: band_id },
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

            // ==================== Add to Home ====================
            $(document.body).on('click', '.add_to_home', function () {
                var band_id = $(this).attr('table_id');

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
                            data: { type: "band", element: band_id },
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

            // ==================== Modal Header ====================
            $('#modal').on('show.bs.modal', function () {
                var formType = $(this).find('#form_type').val();
                var headerH4 = $(this).find('.modal-header h4');
                if (formType === 'create') {
                    headerH4.text("{{ __('Add band') }}");
                } else if (formType === 'update') {
                    headerH4.text("{{ __('Edit band') }}");
                }
            });
        });
    </script>
@endsection