@extends('adminlte::page')

@section('title', 'Banners')

@section('content_header')
<h1>Banners</h1>
@stop

@section('content')
<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <div class="box-header">
                <h3 class="box-title">
                    <a href="{{ route('admin.banner.create') }}" class="btn btn-success">Adicionar</a>
                </h3>
            </div>

            <div class="box-body table-responsive no-padding">
                <table class="table table-striped table-bordered table-hover" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th>Nome</th>
                            <th>Posição</th>
                            <th>Link</th>
                            <th>Início</th>
                            <th>Fim</th>
                            <th>Status</th>
                            <th>Editar</th>
                            <th>Remover</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($banners as $banner)
                        <tr>
                            <td>{{ $banner->name }}</td>
                            <td>{{ $banner->position }}</td>
                            <td>{{ $banner->url }}</td>
                            <td>{{ ($banner->start) ? $banner->start->format('d/m/Y') : '' }}</td>
                            <td>{{ ($banner->end) ? $banner->end->format('d/m/Y') : '' }}</td>
                            <td>
                                <form action="{{ route('admin.banner.status', $banner->id) }}" method="POST">
                                    {{ csrf_field() }}
                                    {{ method_field('PUT') }}

                                    @if($banner->status)
                                        <button type="submit" class="btn btn-sm btn-success" data-id="{{ $banner->id }}"><i class="fa fa-check-circle"></i> &nbsp; Ativo</button>
                                    @else
                                        <button type="submit" class="btn btn-sm btn-danger" data-id="{{ $banner->id }}"><i class="fa fa-circle-o"></i> &nbsp; Inativo</button>
                                    @endif
                                </form>
                            </td>
                            <td><a href="{{ route('admin.banner.edit', $banner->id) }}" class="btn btn-sm btn-primary">Editar</a></td>
                            <td>
                                <button type="button" class="btn btn-sm btn-danger open-remove-modal" data-toggle="modal" data-target="#modal-remove" data-id="{{ $banner->id }}">Remover</button>
                                <form action="{{ route('admin.banner.destroy', $banner->id) }}" method="POST" id="remove{{ $banner->id }}">
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
                {{ $banners->links() }}
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