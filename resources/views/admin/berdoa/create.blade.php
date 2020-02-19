@extends('argon')
@section('css')
<link rel="stylesheet" href="{{ asset('css/select2.min.css') }}">
@endsection

@section('js')
    <script src="{{ asset('js/select2.min.js')}}"></script>
    <script src="{{ asset('backend/assets/js/components/select2-init.js')}}"></script>
    <script src="{{ asset('backend/assets/vendor/ckeditor/ckeditor.js')}}"></script>
<script>
    CKEDITOR.replace('editorl');
    $(document).ready(function () {
        $('#select2').select2();
    })
</script>
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Membuat Data Doa</div>
                <div class="card-body">
                    <form action="{{ route('berdoa.store') }}" method="post">
                        {{ csrf_field() }}

                <div class="form-group">
                    <label for="">Judul</label>
                    <input type="text" name="judul" id="" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="">Arab</label>
                    <input type="text" name="arab" id="" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="">Latin</label>
                    <input type="text" name="latin" id="" class="form-control" required>
                </div>
                 <div class="form-group">
                    <label for="">Artinya</label>
                    <input type="text" name="arti" id="" class="form-control" required>
                </div>
                <br>
                <div class="form-group">
        <button type="submit" class="btn btn-outline-info">
        Simpan Data
        </button>
    </div>
            </form>
            </div>
            </div>
        </div>
    </div>              
</div>

                </tbody>
              </table>
            </div>
          </div>
        </div>

      </div>
      @endsection