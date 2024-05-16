@extends('adminlte::page')

@section('title', 'Imagens')

@section('content_header')
<h1>Imagens</h1>
@stop

@section('content')
<div class="callout callout-warning alert-loading" style="display: none;">
    <p><i class="fa fa-spinner fa-spin"></i> Atualizando, aguarde...</p>
</div>

<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <div class="box-header">
                <a href="{{ route('admin.product.image.create', $productId) }}" class="btn btn-sm btn-success">Adicionar Imagem</a>
                <a href="{{ route('admin.product.edit', $productId) }}" class="btn btn-sm btn-primary">Editar dados</a>

                <div class="box-tools">
                    <form method="POST" action="{{ route('admin.product.image.multiple', $productId) }}" enctype="multipart/form-data" class="input-group input-group-sm" style="width: 250px;">
                        {{ csrf_field() }}
                        <label for="image" class="form-control pull-right">Adicionar multiplas imagens</label>
                        <input type="file" id="image" name="images[]" required class="form-control pull-right" multiple style="display: none;">
                        <div class="input-group-btn">
                            <button type="submit" class="btn btn-success"><i class="fa fa-plus"></i></button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="box-body no-padding">
                <ul id="sortable">
                    @foreach($productImages as $productImage)
                        <li class="ui-state-default" id="image-{{ $productImage->id }}">

                            <img src="{{ asset($productImage->path.$productImage->image) }}" style="width: 150px;">
                            
                            <div class="buttons">
                                <form action="{{ route('admin.product.image.status', [$productId, $productImage->id]) }}" method="POST">
                                    {{ csrf_field() }}
                                    {{ method_field('PUT') }}

                                    @if($productImage->status)
                                        <button type="submit" class="btn btn-xs btn-success"><i class="fa fa-check-circle"></i></button>
                                    @else
                                        <button type="submit" class="btn btn-xs btn-danger"><i class="fa fa-circle-o"></i></button>
                                    @endif
                                </form>

                                <a href="{{ route('admin.product.image.edit', [$productId, $productImage->id]) }}" class="btn btn-xs btn-primary"><i class="fa fa-pencil"></i></a>

                                <button type="button" class="btn btn-xs btn-danger open-remove-modal" data-toggle="modal" data-target="#modal-remove" data-id="{{ $productImage->id }}"><i class="fa fa-times"></i></button>
                            </div>
                            <form action="{{ route('admin.product.image.destroy', [$productId, $productImage->id]) }}" method="POST" id="remove{{ $productImage->id }}">
                                {{ csrf_field() }}
                                {{ method_field('DELETE') }}                            
                            </form>

                        </li>
                        @endforeach
                </ul>
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

        .buttons
        {
            display: flex;
            justify-content: space-around;
            width: 100%;
            padding: 5px;
        }

        #sortable { list-style-type: none; margin: 0; padding: 0; width: 100%; display: table; }
        #sortable li { margin: 3px; padding: 5px; display: inline-block; }
    </style>
@stop

@section('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
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

        $( function() {
            $("#sortable").sortable({
                stop: function(event, ui) {
                    $('.alert-loading').show();
                    var jsonObj = [];

                    $("#sortable li").each(function(i, el){
                        var id = $(el).attr('id').toLowerCase().replace("image-", "");
                        var order = $(el).index();

                        var item = {}
                        item ["id"] = id;
                        item ["order"] = order;

                        jsonObj.push(item);
                    });

                    $.ajax({
                        url: "{{ url('api/product-images-order') }}",
                        type: 'POST',
                        data: { data: jsonObj},
                        dataType: 'json',
                        success: function (response) {
                            $('.alert-loading').hide();
                        },
                        error: function () {
                            console.error("error");
                        }
                    }); 
                }
            });
            $( "#sortable" ).disableSelection();
        } );
    </script>
@stop