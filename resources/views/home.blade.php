@extends('app')

@section('content')

<div class="container">
	<div class="row">
		<div class="col-md-12 col-md-offset">
			<div class="panel panel-info">
				<div class="panel-heading">Búsqueda</div>
                                <form>
				<div class="panel-body">
					<div class="row">
                                            <div class="col-md-4">
                                                <b>Esquema</b>
                                                {!! Form::select('esquema', $data['esquema'], null, array('class' => 'form-control')) !!}
                                            </div>
                                            <div class="col-md-4">
                                                <b>Código de Nómina</b>
                                                {!! Form::select('codnom', $data['codnom'], null, array('class' => 'form-control')) !!}
                                            </div>
                                            <div class="col-md-4">
                                                <b>Fecha de Nómina</b>
                                                {!! Form::select('fecnom', $data['fecnom'], null, array('class' => 'form-control')) !!}
                                            </div>
                                        </div> 
					<div class="row">
                                             &nbsp;
                                        </div>                                     
					<div class="row">
                                            <div class="col-md-4">
                                                <b>Código de Empleado</b>
                                                {!! Form::text('q', '', ['id' =>  'q', 'placeholder' =>  '', 'class' => 'form-control']) !!}
                                            </div>
                                            <div class="col-md-4">
                                                <b>Especial</b>
                                                &nbsp;&nbsp;&nbsp;
                                                {!! Form::select('especial', ["No","Sí"], null, array('class' => 'form-control')) !!}
                                            </div>
                                            <div class="col-md-4">
                                                <b>Código de Nómina Especial</b>
                                                {!! Form::select('codnomesp', $data['codnomesp'], null, array('class' => 'form-control')) !!}
                                            </div>
                                        </div>
					<div class="row centered">
                                            <div class="col-md-4">
                                                    &nbsp;                                      
                                            </div>
                                            <div class="col-md-4 col-md-offset-1">
                                                    <input type="hidden" name="_token" value="{!! csrf_token() !!}">
                                            </div>
                                            <div class="col-md-4">
                                                    &nbsp;
                                            </div>
                                            
                                        </div>                                     
					<div class="row centered">
                                            <div class="col-md-4">
                                                                                            
                                            </div>
                                            <div class="col-md-4 col-md-offset-1">
                                                <button type="button" class="btn btn-primary centered search">Buscar</button>
                                            </div>
                                            <div class="col-md-4">
                                            
                                            </div>
                                            
                                        </div>                                    
				</div>
                                </form>        
                                
			</div>
		</div>
	</div>
	<div class="row" id="result">
		<div class="col-md-12 col-md-offset">
			<div class="panel panel-success">
				<div class="panel-heading ">Resultados</div>

				<div class="panel-body">
                                    <div id="resultado">
                                        <table id="jqGrid"></table>
                                        <div id="jqGridPager"></div>
                                    </div>    
				</div>
                                
			</div>
		</div>
	</div>    
</div>
</body>
</html>
<script type="text/javascript">
            $(function() {
                $("#q").autocomplete({
                    source: "home/autocomplete",
                    minLength: 1,
                    select: function( event, ui ) {
                        $('#q').val(ui.item.id);
                    }
                });
            });
                        
            $( ".search" ).click(function() {
                var datastring = $("form").serialize();
                $( "#resultado" ).empty();
                $( "#resultado" ).html("<table id='jqGrid'></table><div id='jqGridPager'></div>");
                $.ajax({
                        type: "POST",
                        url: "home/search",
                        data: datastring,
                        success: function(mydata) {
                            $("#jqGrid").jqGrid({
                                data: mydata,
                                styleUI : 'Bootstrap',
                                datatype: "local",                
                                editurl: 'home/update',
                                colModel: [
                                    { label: 'Esquema', name: 'esquema', editable: true, width: 75 },
                                    { label: 'Id', name: 'id', key: true, width: 75 },
                                    { label: 'Código Concepto', name: 'codcon', width: 140 },
                                    { label: 'Asided', name: 'asided', width: 100 },
                                    { label: 'Nombre Concepto', name: 'nomcon', width: 250 },
                                    { label: 'Acumulado', name: 'acumulado', width: 150,  editable:true },
                                    { label:'Saldo', name: 'saldo', width: 150,  editable:true }
                                ],
                                viewrecords: true,
                                height: 200,
                                rowNum: 10,
                                pager: "#jqGridPager"
                            });

                            $('#jqGrid').navGrid('#jqGridPager',
                                // the buttons to appear on the toolbar of the grid
                                { edit: true, add: false, del: false, search: false, refresh: false, view: false, position: "left", cloneToTop: false, refreshstate: "current" },
                                // options for the Edit Dialog
                                {
                                    editCaption: "Editar Registro",
                                    recreateForm: true,
                                    checkOnUpdate : true,
                                    checkOnSubmit : true,
                                    closeAfterEdit: true,
                                    reloadAfterSubmit: true,
                                    afterSubmit: function(data) {
										   var obj = data.responseText;
                                           var obj = jQuery.parseJSON(obj);
                                           var text = "Se ha modificado el registro de forma exitosa";
                                           text += " en el esquema "+obj.esquema+" con la siguiente información: \n \n";
                                           text += " ID: "+obj.id+"\n";
                                           text += " Código de concepto: "+obj.codcon+"\n";
                                           text += " Nombre de concepto: "+obj.nomcon+"\n";
                                           text += " Acumulado: "+obj.acumulado+"\n";
                                           text += " Saldo: "+obj.saldo+"\n";
										   alert(text);
                                           location.reload(true); 
                                    },
                                    errorTextFormat: function (data) {
                                        return 'Error: ' + data.responseText
                                    }
                                },
                                // options for the Add Dialog
                                {
                                    closeAfterAdd: true,
                                    recreateForm: true,
                                    errorTextFormat: function (data) {
                                        return 'Error: ' + data.responseText
                                    }
                                },
                                // options for the Delete Dailog
                                {
                                    errorTextFormat: function (data) {
                                        return 'Error: ' + data.responseText
                                    }
                                });
                               }
                               
                               // location.reload();
                });                
            });
            
</script>

@endsection
