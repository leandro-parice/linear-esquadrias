@extends('adminlte::page')

@section('title', 'Usuários')

@section('content_header')
<h1>Usuários</h1>
@stop

@section('content')
<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <div class="box-header">
                <h3 class="box-title">
                    <a href="{{ route('admin.user.create') }}" class="btn btn-success">Adicionar</a>
                </h3>

                <div class="box-tools">
                    <!--
                    <form method="POST" action="">
                        {{ csrf_field() }}

                        <div class="input-group">
                            <div class="input-group-btn">
                                <button type="submit" class="btn btn-default"><i class="fa fa-times"></i></button>
                            </div>
                                
                            <input type="text" name="table_search" class="form-control pull-right" placeholder="Buscar">
                            <div class="input-group-btn">
                                <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
                            </div>
                        </div>
                    </form>
                    -->
                </div>
            </div>

            <div class="box-body table-responsive no-padding">
                <table class="table table-striped table-bordered table-hover" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th style="display: none;"></th>
                            <th>Nome</th>
                            <th>E-mail</th>
                            <th>Tipo</th>
                            <th>Status</th>
                            <th>Editar</th>
                            <th>Remover</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                        <tr>
                            <td style="display: none;"><input type="checkbox"></td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->showType() }}</td>
                            <td>{{ $user->showStatus() }}</td>
                            <td><a href="{{ route('admin.user.edit', $user->id) }}" class="btn btn-sm btn-primary">Editar</a></td>
                            <td>
                                <button type="button" class="btn btn-sm btn-danger open-remove-modal" data-toggle="modal" data-target="#modal-remove" data-id="{{ $user->id }}">Remover</button>
                                <form action="{{ route('admin.user.destroy', $user->id) }}" method="POST" id="remove{{ $user->id }}">
                                    {{ csrf_field() }}
                                    {{ method_field('DELETE') }}                            
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="box-footer clearfix">
                {{ $users->links() }}
            </div>
        </div>
    </div>
</div>



<div class="modal fade" id="modal-remove" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Remover</h4>
            </div>

            <div class="modal-body">
                <p>Tem certeza que deseja remover?</p>
            </div>
            
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary send-remove-modal">Sim, remover</button>
            </div>
        </div>
    </div>
</div>
@stop

@section('css')
    <style>
        td{
            vertical-align: middle !important;
        }

        .box-header>.box-tools{
            top: 10px !important;
        }

        .box-tools .input-group{
            width: 200px;
        }
    </style>
@stop

@section('js')
    <script>
        $(document).on('click', '.open-remove-modal', function () {
            var id = $(this).data('id');
            $('.send-remove-modal').attr('data-id', id);
        });

        $(document).on('click', '.send-remove-modal', function () {
            var id = $(this).data('id');
            $('.modal-body p').html('<i class="fa fa-spinner fa-spin"></i> Enviando, aguarde...');
            $('.modal').find('button').attr('disabled', 'disabled');
            $('#remove'+id).submit();
        });
    </script>
@stop