@extends('layouts.template')
@section('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.4/toastr.min.css">
    <script src="https://code.jquery.com/jquery-3.3.1.js"></script>
    <style>
        #users_table_wrapper{
            margin: 10px;
        }
    </style>
@endsection
@section('content')

{{-- Success flash messages --}}
@if(Session::has('success_deleted'))
    <div class="alert alert-success" role="alert">
        {{ Session::get('success_deleted') }}
    </div>
@endif

{{-- Error flash messages --}}

@if(Session::has('error_deleted'))
    <div class="alert alert-danger" role="alert">
        {{ Session::get('error_deleted') }}
    </div>
@endif

@if(Session::has('error_yourself'))
    <div class="alert alert-danger" role="alert">
        {{ Session::get('error_yourself') }}
    </div>
@endif


<div class="text-right" style="margin: 20px">
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#add-user">
        Crear usuario
      </button>
</div>

<table id="users_table" class="display table table-bordered" style="width: 100%">
    <thead>
        <tr>
            <th class="text-center" scope="col">User ID</th>
            <th class="text-center" scope="col">Name</th>
            <th class="text-center" scope="col">Email</th>
            <th class="text-center" scope="col">Admin</th>
            <th class="text-center" scope="col">Created At</th>
            <th class="text-center" scope="col">Updated At</th>
            <th class="text-center" scope="col">Editar Registro</th>
            <th class="text-center" scope="col">Borrar Registro</th>
        </tr>
    </thead>
    <tbody>
        
    </tbody>
</table>
{{--Add Modal--}}
<div class="modal fade" id="add-user" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLongTitle">Modal title</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <form id="adduser_modalform">
                @csrf

                <div class="form-group row">
                    <label for="name"
                        class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>

                    <div class="col-md-6">
                        <input id="name_adduser" type="text" class="form-control @error('name') is-invalid @enderror"
                            name="name" value="{{ old('name') }}" required autocomplete="name"
                            autofocus>

                        @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label for="username"
                        class="col-md-4 col-form-label text-md-right">{{ __('username') }}</label>

                    <div class="col-md-6">
                        <input id="username_adduser" type="text"
                            class="form-control @error('username') is-invalid @enderror" name="username"
                            value="{{ old('username') }}" required autocomplete="username">

                        @error('username')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label for="email"
                        class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                    <div class="col-md-6">
                        <input id="email_adduser" type="email"
                            class="form-control @error('email') is-invalid @enderror" name="email"
                            value="{{ old('email') }}" required autocomplete="email">

                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label for="password_adduser"
                        class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                    <div class="col-md-6">
                        <input id="password_adduser" type="password"
                            class="form-control @error('password') is-invalid @enderror" name="password" required
                            autocomplete="new-password">

                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label for="password_confirm_adduser"
                        class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>

                    <div class="col-md-6">
                        <input id="password_confirm_adduser" type="password" class="form-control"
                            name="password_confirmation" required autocomplete="new-password">
                    </div>
                </div>
            </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="button" id="add_modalform_btn" class="btn btn-primary">Save changes</button>
        </div>
      </div>
    </div>
  </div>

{{--Delete Modal--}}
<div id="delete-user" class="modal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Eliminar Usuario</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <form>
            @csrf
          <p id="delete-user-txt"></p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" id="remove_btn" class="btn btn-danger">Delete</button>
        </div>
    </form>
      </div>
    </div>
  </div>

<!-- Edit Modal -->
<div class="modal fade" id="edit-user" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Editar</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="update_modalform">
                    @csrf

                    <div class="form-group row">
                        <label for="name"
                            class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>

                        <div class="col-md-6">
                            <input id="name_update" type="text" class="form-control @error('name') is-invalid @enderror"
                                name="name" value="{{ old('name') }}" required autocomplete="name"
                                autofocus>

                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="username"
                            class="col-md-4 col-form-label text-md-right">{{ __('username') }}</label>

                        <div class="col-md-6">
                            <input id="username_update" type="text"
                                class="form-control @error('username') is-invalid @enderror" name="username"
                                value="{{ old('username') }}" required autocomplete="username">

                            @error('username')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="email"
                            class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                        <div class="col-md-6">
                            <input id="email_update" type="email"
                                class="form-control @error('email') is-invalid @enderror" name="email"
                                value="{{ old('email') }}" required autocomplete="email">

                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="password_update"
                            class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                        <div class="col-md-6">
                            <input id="password_update" type="password"
                                class="form-control @error('password') is-invalid @enderror" name="password" required
                                autocomplete="new-password">

                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="password-confirm"
                            class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>

                        <div class="col-md-6">
                            <input id="password-confirm_update" type="password" class="form-control"
                                name="password_confirmation" required autocomplete="new-password">
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" id="update_modalform_btn" class="btn btn-primary">{{ __('Update') }}</button>
            </div>
        </div>
    </div>
</div>

@section('scripts')
<script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.10.25/datatables.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.4/toastr.min.js"></script>


{{--Add users table--}}
<script>
$('#add_modalform_btn').click(function (e){
    const name = $('#name_adduser').val();
    const username = $('#username_adduser').val();
    const email = $('#email_adduser').val();
    const password = $('#password_adduser').val();
    const confirm_password = $('#password_confirm_adduser').val();
    const token = $('input[name=_token]').val();
    

    if (password != confirm_password) {
         toastr.warning('Las contraseñas no coinciden, por favor, introdúzcalas de nuevo',
                            'Las contraseñas no coinciden', {
                                timeout: 3000
                            });
    } else{
            $.ajax({
            url: "{{route('add_users')}}",
            method: "POST",
            data: {
            name: name,
            username: username,
            email: email,
            password: password,
            _token: token
                },
                success: function (res) {
                    if (res == true) {
                        console.log(res);
                        $('#edit-user').modal('hide');
                        toastr.info('El registro fue creado correctamente',
                            'Actualizar Registro', {
                                timeout: 3000
                            });

                            $('#users_table').DataTable().ajax.reload();
                            


                    } else {
                        console.log(res);
                        toastr.warning('Ha habido un error al crear el registro', 'Crear Registro', {
                            timeout: 3000
                        });
                    }
                }
            })
    }

})
</script>

{{--Show users table--}}
<script>
    $(document).ready(function() {
    var $tablausuarios = $('#users_table').DataTable( {
        processing: true,
        serverSide: true,
        ajax: {
            url: "{{ route('control_panel') }}",
        },
        columns: [
            {data: "id"},
            {data: "name"},
            {data: "email"},
            {data: "is_admin"},
            {data: "created_at"},
            {data: "updated_at"},
            {data: "edit"},
            {data: "delete"},
            
        ]
    } );
} );
</script>

{{--Edit users popup--}}
<script>
    function edit_user(id) {
        $.get('/admin/edit-users/' + id, function (user) {
            $('#name_update').val(user.name);
            $('#username_update').val(user.username);
            $('#email_update').val(user.email);
            $('#password_update').val(user.password);
            $('#password-confirm_update').val(user.confirm_password);
            $('#edit-user').modal('toggle');
        })
    }
</script>

{{--Edit user request--}}
<script>
    $('#update_modalform_btn').click(function (e) {
        e.preventDefault();
        const name = $('#name_update').val();
        const username = $('#username_update').val();
        const email = $('#email_update').val();
        const password = $('#password_update').val();
        const token = $('input[name=_token]').val();
        const confirm_password = $('#password-confirm_update').val();
        if (password == confirm_password) {
            $.ajax({
                url: "{{ route('update_register') }}",
                method: "POST",
                data: {
                    name: name,
                    username: username,
                    email: email,
                    password: password,
                    _token: token
                },
                success: function (res) {
                    if (res) {
                        console.log(res);
                        $('#edit-user').modal('hide');
                        toastr.info('El registro fue actualizado correctamente',
                            'Actualizar Registro', {
                                timeout: 3000
                            });

                            $('#users_table').DataTable().ajax.reload();
                            


                    } else {
                        toastr.warning('Ha habido un error', 'Actualizar Registro', {
                            timeout: 3000
                        });
                    }
                }
            })
        }
    })
</script>
@endsection

{{--Delete users--}}
<script>
    function show_delete_form(id) {
        
        $.get('/admin/show-delete-form/' + id, function (user) {
        $("#delete-user-txt").html('¿Desea eliminar el usuario ' + user + '?');
        $('#delete-user').modal('toggle');
        })
        const token = $("input[name=_token]").val();
        $(document).off('click.req', '#remove_btn'); 
        $(document).unbind('click.req', '#remove_btn'); 
        $(document).on('click.req', '#remove_btn', function(e, xhr, settings){
            e.preventDefault();
            console.log('/admin/show-delete-form/' + id);
            $.ajax({
                url: "/admin/delete-register",
                method: "POST",
                data: {
                    id: id,
                    _token: token
                },
                success: function (res) {
                    if (res == true) {
                        console.log(res);
                        id_empty= "";
                        $('#delete-user').modal('hide');
                        toastr.info('El registro fue eliminado correctamente',
                            'Eliminar Registro', {
                                timeout: 3000
                            });

                            $('#users_table').DataTable().ajax.reload();
                            


                    }  
                    if (res == "same_admin") {
                        toastr.warning('No puedes eliminarte a ti mismo', 'Eliminar Registro', {
                            timeout: 3000
                        });
                    }
                    if (res == false) {
                        toastr.warning('Ha ocurrido un error', 'Eliminar Registro', {
                            timeout: 3000
                        });
                    }
                }
            })
})
    }

</script>
@endsection