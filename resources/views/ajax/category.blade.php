@extends('argon')
<!DOCTYPE html>
<html>
<head>
    <title>Laravel 6 Crud operation using ajax(Real Programmer)</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css" />
    <link href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet">
    <link href="/assets/package/dist/sweetalert2.css" rel="stylesheet"/>
    <link href="style.css" rel="stylesheet"/>
</head>
<body>
@section('content')
<section class="page-content container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">   
                <div class="container">
    <h1>Category</h1>
    <center><a class="btn btn-success" href="javascript:void(0)" id="createNewBook"> Create New Book</a></center>
    <br>
    <table class="table table-bordered data-table">
        <thead>
            <tr>
                <th width="50px">No</th>
                <th width="400px">Nama category</th>
                <th width="400px">Slug</th>
                <th width="300px">Action</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
</div>

<!-- {{-- modal mulai --}} -->
<div class="modal fade" id="modal" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
           
            <div class="modal-header">
                <h4 class="modal-title" id="modelHeading"></h4>
            </div>
            
            <!-- Bagian Body Modal-->
            <div class="modal-body">
                <!-- Form-->
                <form id="form" name="form" class="form-horizontal">
                    <input type="hidden" name="category_id" id="category_id">
                    <div class="form-group">
                        <div class="col-lg-12">
                            <label for="name" class="control-label">Nama category</label>
                            <input type="text" class="form-control" id="nama" name="nama" placeholder="Nama category" maxlength="50" autocomplete="off" required>
                            <span style="color: red;" id="error_nama"></span>
                            <br>
                        </div>
                    </div>
                </form>
                <!-- Akhir Form-->
            </div>
            <!-- modal footer-->
            <div class="modal-footer">
                <button data-dismiss="modal" type="button" class="btn btn-danger pull-left"
                id="reset">Batal</button>

                <button align="right" type="submit" class="btn btn-primary" id="simpan">Simpan</button>
            </div>
            <!-- Akhir modal footer-->
        </div>
    </div>
</div>
<!-- modal berakhir -->

@endsection

@section('js')
<script>
$('#modal').on('hidden.bs.modal',function(){
    $('#error_nama').css('display','none');
})
</script>
<script type="text/javascript">

    $(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

      //INDEX TABEL
    var table = $('.datatable').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ url('admin/category') }}",
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex'},
            {data: 'nama', name: 'nama'},
            {data: 'slug', name: 'slug'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ]
    });

    $('#createNewBook').click(function () {
        $('.modal-title').html('Tambah Data');
        $('#category_id').val('');
        $('#form').trigger("reset");
        $('#modal').modal({backdrop: 'static', keyboard: false});
        $('#modal').modal('show');
        $('#nama').keypress(function(){
            $('#error_nama').css('display','none');
        });
    });

    $('body').on('click','.edit',function(){
        var idcategory = $(this).data('id');
        $.get("{{ url('admin/category') }}"+"/"+idcategory+"/edit", function(data){
            // console.log(data);
            $('#modal').modal({backdrop: 'static', keyboard: false});
            $('#modal').modal('show');
            $('.modal-title').html('Edit Data');
            $('#category_id').val(data.id);
            $('#nama').val(data.nama);
            $('#nama').keypress(function(){
                $('#error_nama').css('display','none');
            });
        });
    });

    $('body').on('click','.hapus', function(){
        var idcategory = $(this).data('id');
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
            if (result.value) {
                $.ajax({
                    type: "DELETE",
                    url: "{{ url('admin/category-destroy') }}"+"/"+idcategory,
                    success: function(data){
                        table.draw();
                    },
                    error: function(request, status, error) {
                        console.log(error);
                    }
                });
                Swal.fire({
                    title: 'Deleted!',
                    text: 'Your file has been deleted.',
                    icon: 'success',
                    showConfirmButton: false,
                    timer: 1000
                })
            }
        })
    });

    //KETIKA BUTTON SAVE DI KLIK
    $('#simpan').click(function (e) {
        e.preventDefault();
        // $(this).hide();
        $.ajax({
            data: $('#form').serialize(),
            url: "{{ url('admin/category-store') }}",
            type: "POST",
            dataType: 'json',
            success: function (data) {
                $('#form').trigger("reset");
                $('#modal').modal('hide');
                table.draw();
                Swal.fire({
                    icon: 'success',
                    title: data.success,
                    showConfirmButton: false,
                    timer: 1000
                });
            },

            error: function (request, status, error) {
                $('#error_nama').empty().show();
                json = $.parseJSON(request.responseText);
                $('#error_nama').html(json.errors.nama);
            }
        });
    });

});

</script>
@endsection