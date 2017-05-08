<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="{{ asset ("/bower_components/admin-lte/bootstrap/css/bootstrap.min.css") }}" >
    <link rel="stylesheet" type="text/css" href="{{asset("/bower_components/admin-lte/dist/css/AdminLTE.min.css")}}">
    <style type="text/css">
    	tbody:before, tbody:after { display: none; }
      	.footer { position: fixed; bottom: 60px; }
      	.page {  margin-left: 49%; }
      	.pagenum:before { content: counter(page); }
      	.resumen { text-align: right;}
	</style>
</head>
<body>
	<img src="/var/www/html/eLearning/public/dist/img/encabezado-cus-sin-linea.jpg" style="margin-left: 2%; width: 100%;">
	
	<p class="resumen"><b>,</b></p>

	<p><b><u>INFORMACIÓN DE </u></b></p>
	<div style="width: 100%; margin-left: 1%;">
		<table class="table table-condensed table-bordered">
			<tr class="active" style="text-align:center;">
				<th>Usuario</th>
			</tr>
			<tr style="text-align:right;">
				<td></td>
			</tr>
			<tr class="active">
				<td>Totales</td>
			</tr>
		</table>
	</div>	
</body>