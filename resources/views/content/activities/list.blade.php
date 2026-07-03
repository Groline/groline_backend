@extends('layouts/contentNavbarLayout')

@section('title', __('Activities'))

@section('content')

    <h4 class="fw-bold py-3 mb-3 row justify-content-between">
        <div class="col-md-auto">
            <span class="text-muted fw-light">{{ __('Activities') }} /</span> {{ __('Browse activities') }}
        </div>
        <div class="col-md-auto">
            <button type="button" class="btn btn-primary" id="create">{{ __('Add activity') }}</button>
        </div>
    </h4>

    <!-- Basic Bootstrap Table -->
    <div class="card">
        <div class="table-responsive text-nowrap">
            <table class="table" id="laravel_datatable">
              <div class="table-header row justify-content-between">
                <h5 class="col-md-auto">{{ __('Activities table') }}</h5>
              </div>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>{{ __('Name') }}</th>
                        <th>{{ __('Created at') }}</th>
                        <th>{{ __('Actions') }}</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>

    {{-- activity modal --}}
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
                    <form class="form-horizontal" onsubmit="event.preventDefault()" action="#"
                        enctype="multipart/form-data" id="form">
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
        $(document).ready(function() {
            load_data();

            function load_data() {
                var table = $('#laravel_datatable').DataTable({
                    language:  {!! file_get_contents(base_path('lang/'.session('locale','en').'/datatable.json')) !!},
                    responsive: true,
                    processing: true,
                    serverSide: true,
                    pageLength: 10,

                    ajax: {
                        url: "{{ url('activity/list') }}",
                    },

                    type: 'GET',

                    columns: [

                        {
                            data: 'DT_RowIndex',
                            name: 'DT_RowIndex'
                        },

                        {
                            data: 'name',
                            name: 'name'
                        },

                        {
                            data: 'created_at',
                            name: 'created_at'
                        },

                        {
                            data: 'action',
                            name: 'action',
                            searchable: false
                        }

                    ]
                });
            }

            $('#create').on('click', function() {
                document.getElementById('form').reset();
                document.getElementById('form_type').value = "create";
                $("#modal").modal('show');
            });


            $(document.body).on('click', '.update', function() {
                document.getElementById('form').reset();
                document.getElementById('form_type').value = "update";
                var activity_id = $(this).attr('table_id');
                $("#id").val(activity_id);

                $.ajax({
                    url: '{{ url('activity/update') }}',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    type: 'POST',
                    data: {
                        activity_id: activity_id
                    },
                    dataType: 'JSON',
                    success: function(response) {
                        if (response.status == 1) {
                            document.getElementById('id').value = response.data.id;
                            document.getElementById('name_ar').value = response.data.name_ar;
                            document.getElementById('name_en').value = response.data.name_en;
                            document.getElementById('name_fr').value = response.data.name_fr;

                            $("#modal").modal("show");
                        }
                    }
                });
            });

            $('#submit').on('click', function() {

                var formdata = new FormData($("#form")[0]);
                var formtype = document.getElementById('form_type').value;

                if (formtype == "create") {
                    url = "{{ url('activity/create') }}";
                }

                if (formtype == "update") {
                    url = "{{ url('activity/update') }}";
                    formdata.append("activity_id", document.getElementById('id').value)
                }

                $("#modal").modal("hide");

                $.ajax({
                    url: url,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    type: 'POST',
                    data: formdata,
                    dataType: 'JSON',
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        if (response.status == 1) {
                            Swal.fire({
                                title: "{{ __('Success') }}",
                                text: "{{ __('success') }}",
                                icon: 'success',
                                confirmButtonText: 'Ok'
                            }).then((result) => {
                                $('#laravel_datatable').DataTable().ajax.reload();
                            });
                        } else {
                            console.log(response.message);
                            Swal.fire(
                                "{{ __('Error') }}",
                                response.message,
                                'error'
                            );
                        }
                    },
                    error: function(data) {
                        var errors = data.responseJSON;
                        console.log(errors);
                        Swal.fire(
                            "{{ __('Error') }}",
                            errors.message,
                            'error'
                        );
                    }
                });
            });

            $(document.body).on('click', '.delete', function() {

                var activity_id = $(this).attr('table_id');

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
                            url: "{{ url('activity/delete') }}",
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            type: 'POST',
                            data: {
                                activity_id: activity_id
                            },
                            dataType: 'JSON',
                            success: function(response) {
                                if (response.status == 1) {

                                    Swal.fire(
                                        "{{ __('Success') }}",
                                        "{{ __('success') }}",
                                        'success'
                                    ).then((result) => {
                                        $('#laravel_datatable').DataTable().ajax.reload();
                                    });
                                } else {
                                    Swal.fire(
                                        "{{ __('Error') }}",
                                        response.message,
                                        'error'
                                    )
                                }
                            }
                        });


                    }
                })
            });

            $('#modal').on('show.bs.modal', function() {
                var formType = $(this).find('#form_type').val();
                var headerH4 = $(this).find('.modal-header h4');
                if (formType === 'create') {
                    headerH4.text("{{ __('Add activity') }}");
                } else if (formType === 'update') {
                    headerH4.text("{{ __('Edit activity') }}");
                }
            });
        });
    </script>
@endsection
