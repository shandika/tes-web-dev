@extends('master')
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-4">
        <button type="button" class="btn btn-primary mt-2 mb-2" data-bs-toggle="modal" id="tambah" data-bs-target="#exampleModal">
            Tambah Data
        </button>
        </div>
        <div class="col-md-4"></div>
        <div class="col-md-4 mt-2">
            <div class="form-group">
                <select name="filter_sumber" id="filter_sumber" class="form-control" required>
                    <option value="">Pilih Sumber Dana</option>
                    @foreach($sumber as $s)
                    <option value="{{ $s->sumber_dana }}">{{ $s->sumber_dana }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group mt-2">
                <select name="filter_keterangan" id="filter_keterangan" class="form-control" required>
                    <option value="">Pilih Keterangan</option>
                    @foreach($keterangan as $ket)
                    <option value="{{ $ket->keterangan }}">{{ $ket->keterangan }}</option>
                    @endforeach
                </select>
            </div>
            
            <div class="form-group mt-2" align="center">
                <button type="button" name="filter" id="filter" class="btn btn-info">Filter</button>

                <button type="button" name="reset" id="reset" class="btn btn-default">Reset</button>
            </div>
        </div>
    </div>
    <div class="table-responsive">
    <table class="table table-striped" id="tabel1">
        <thead>
            <tr>
                <th>No</th>
                <th>Sumber Dana</th>
                <th>Program</th>
                <th>Keterangan</th>
                <th>Aksi</th>
            </tr>
        </thead>
    </table>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Tambah Data</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            @csrf
            <form class="program-form">
                <div class="mb-3">
                <label for="exampleFormControlInput1" class="form-label">Sumber Dana</label>
                <input type="text" class="form-control" name="sumber_dana" id="sumber_dana" placeholder="Masukkan Sumber Dana">
                <input type="hidden" id="id" name="id">
                </div>
                <div class="mb-3">
                <label for="exampleFormControlInput1" class="form-label">Program</label>
                <input type="text" class="form-control" id="program"  name="program" placeholder="Masukan Program">
                </div>
                <div class="mb-3">
                <label for="exampleFormControlInput1" class="form-label">Keterangan</label>
                <textarea name="keterangan" class="form-control" id="keterangan" cols="30" rows="5"></textarea>
                </div>
            </form>
        </div>
        <div class="modal-footer">
            <button type="button" id="tutup" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="button" id="simpan" class="btn btn-primary">Simpan</button>
        </div>
        </div>
    </div>
</div>
@push('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script>
    $(document).ready(function () {
        isi()
        function fill_datatable(filter_sumber = '', filter_keterangan = '')
        {
            var dataTable = $('#tabel1').DataTable({   
                processing: true,
                serverside : true,
                responseive : true,
                searching: true,
                ajax : {
                    url : "{{route('cari')}}",
                    data:{filter_sumber:filter_sumber, filter_keterangan:filter_keterangan}
                },
                columns:[
                    {
                        "data" :null, "sortable": false,
                        render : function (data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1
                        }
                    },
                    {data: 'sumber_dana', name: 'sumber_dana'},
                    {data: 'program', name: 'program'},
                    {data: 'keterangan', name: 'keterangan'},
                    {data: 'aksi', name: 'aksi'}
                ]
            });
        }

        $('#filter').click(function(){
            var filter_sumber = $('#filter_sumber').val();
            var filter_keterangan = $('#filter_keterangan').val();

            if(filter_sumber != '' &&  filter_keterangan != '')
            {
                $('#tabel1').DataTable().destroy();
                fill_datatable(filter_sumber, filter_keterangan);
            }
            else
            {
                swal(
                    "Info!",
                    "Silahkan Isi Filter Terlebih Dahulu",
                    "info"
                );
            }
        });

        $('#reset').click(function(){
            $('#filter_sumber').val('');
            $('#filter_keterangan').val('');
            $('#tabel1').DataTable().destroy();
            fill_datatable();
        });
    })

    function isi() {
        $('#tabel1').DataTable({
            serverside : true,
            responseive : true,
            searching: true,
            ajax : {
                url : "{{route('data')}}"
            },
            columns:[
                {
                    "data" :null, "sortable": false,
                    render : function (data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1
                    }
                },
                {data: 'sumber_dana', name: 'sumber_dana'},
                {data: 'program', name: 'program'},
                {data: 'keterangan', name: 'keterangan'},
                {data: 'aksi', name: 'aksi'}
            ]
        })
    }
</script>
<script>
    $('#simpan').on('click',function () {
        if ($(this).text() === 'Simpan Edit') {
           edits()
        } else {
          tambah()
        }
    })

    $('#tutup').on('click',function () {
        $('#tabel1').DataTable().ajax.reload()
        $('#sumber_dana').val(null)
        $('#program').val(null)
        $('#keterangan').val(null)
        $('#sumber_dana').removeAttr('readonly')
        $('#program').removeAttr('readonly')
        $('#keterangan').removeAttr('readonly')
        $('#simpan').show()
        $('#simpan').text('Simpan')
    })

    $('.btn-close').on('click',function () {
        $('#tabel1').DataTable().ajax.reload()
        $('#sumber_dana').val(null)
        $('#program').val(null)
        $('#keterangan').val(null)
        $('#sumber_dana').removeAttr('readonly')
        $('#program').removeAttr('readonly')
        $('#keterangan').removeAttr('readonly')
        $('#simpan').show()
        $('#simpan').text('Simpan')
    })

    $(document).on('click','.lihat', function () {
        let id = $(this).attr('id')
        $('#tambah').click()
        $('#exampleModalLabel').text('Lihat Data')
        $('#simpan').hide()
        $('#sumber_dana').attr('readonly', true)
        $('#program').attr('readonly', true)
        $('#keterangan').attr('readonly', true)

        $.ajax({
            url : "{{route('views')}}",
            type : 'post',
            data : {
                id : id,
                _token : "{{csrf_token()}}"
            },
            success: function (res) {
                $('#id').val(res.data.id)
                $('#sumber_dana').val(res.data.sumber_dana)
                $('#program').val(res.data.program)
                $('#keterangan').val(res.data.keterangan)
            }
        })

    })
    
    $(document).on('click','.edit', function () {
        let id = $(this).attr('id')
        $('#tambah').click()
        $('#simpan').text('Simpan Edit')
        $('#simpan').show()
        $('#exampleModalLabel').text('Edit Data')
        $('#sumber_dana').removeAttr('readonly')
        $('#program').removeAttr('readonly')
        $('#keterangan').removeAttr('readonly')

        $.ajax({
            url : "{{route('edits')}}",
            type : 'post',
            data : {
                id : id,
                _token : "{{csrf_token()}}"
            },
            success: function (res) {
                $('#id').val(res.data.id)
                $('#sumber_dana').val(res.data.sumber_dana)
                $('#program').val(res.data.program)
                $('#keterangan').val(res.data.keterangan)
            }
        })

    })

    function tambah() {
        $.ajax({
                url : "{{route('data.store')}}",
                type : "post",
                data : {
                    sumber_dana : $('#sumber_dana').val(),
                    program : $('#program').val(),
                    keterangan : $('#keterangan').val(),
                    "_token" : "{{csrf_token()}}"
                },
                success : function (res) {
                    console.log(res);
                    swal(
                        "Berhasil!",
                        "Data Berhasil Disimpan",
                        "success"
                    );
                    $('#tutup').click()
                    $('#tabel1').DataTable().ajax.reload()
                    $('#sumber_dana').val(null)
                    $('#program').val(null)
                    $('#keterangan').val(null)
                },
                error : function (xhr) {
                    alert(xhr.responJson.text)
                }
            })
    }

    function edits() {
        $.ajax({
                url : "{{route('updates')}}",
                type : "post",
                data : {
                    id : $('#id').val(),
                    sumber_dana : $('#sumber_dana').val(),
                    program : $('#program').val(),
                    keterangan : $('#keterangan').val(),
                    "_token" : "{{csrf_token()}}"
                },
                success : function (res) {
                    console.log(res);
                    swal(
                        "Berhasil!",
                        "Data Berhasil Diedit",
                        "success"
                    );
                    $('#tutup').click()
                    $('#tabel1').DataTable().ajax.reload()
                    $('#sumber_dana').val(null)
                    $('#program').val(null)
                    $('#keterangan').val(null)
                    $('#simpan').text('Simpan')
                },
                error : function (xhr) {
                    alert(xhr.responJson.text)
                }
            }) 
    }

    $(document).on('click','.hapus', function () {
        let id = $(this).attr('id')
        swal({
            title: "Yakin?",
            text: "Kamu akan menghapus barang",
            icon: "warning",
            buttons: true,
            dangerMode: true,
            })
            .then((willDelete) => {
            if (willDelete) {
                $.ajax({
                url : "{{route('hapus')}}",
                type : 'post',
                data: {
                    id: id,
                    "_token" : "{{csrf_token()}}"
                },
                success: function (params) {
                    swal(
                            "Berhasil!",
                            "Data Berhasil Dihapus",
                            "success"
                        );
                    $('#tabel1').DataTable().ajax.reload()
                }
            })
            } else {
                swal(
                    "Info!",
                    "Data Tidak Jadi Dihapus",
                    "info"
                );
            }
        });
    });
</script>
@endpush
@endsection