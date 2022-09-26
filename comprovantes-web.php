<?php
	$vari = 'lerDocumentos_BaixaWeb.exe';
	$variavel = exec($vari);
	//echo $variavel;
	
	//exec($vari, $resultado);
	//echo $resultado;
	
	header("Refresh:120"); //REFRESH NA PÁGINA DE 3 EM 3 MINUTOS
	require_once "conexaoSQL/Conexao.php";
	
	date_default_timezone_set('America/Sao_Paulo');
	
	$hojeSistema = date('Y.m.d');
	
	$datahoje = date('Y.m.d 00:00:00');
		
	$hoje = date('Y'); //PEGA DATA ATUAL PARA PREENCHER AUTOMATICO NA BAIXA
	
	$data = date('d/m/Y');
		
	$arquivos = glob("$pasta{*.jpg,*.JPG}", GLOB_BRACE);

	$i = 0;
	$images = array();

	foreach($arquivos as $img){
		$images[] = '<img src=\"imagens/".$img."\">';
		$i=$i+1;
	}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
	<html xmlns="http://www.w3.org/1999/xhtml">
		<head>
		
			<link rel="shortcut icon" type="imagex/png" href="fav.png">
			<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
			<title>Consulta de Comprovantes Web</title>

			<!--Carrega as bibliotecas JavaSript para as máscaras de CPF, Celular, etc. -->
			<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
			<script src="https://cdnjs.cloudflare.com/ajax/libs/inputmask/4.0.9/jquery.inputmask.bundle.min.js"></script>

			<!--CHAMANDO O ARQUIVO CSS E JAVA SCRIPT-->
			<link rel="stylesheet" type="text/css" href="css/estilo.css" media="screen" />
			<link rel="stylesheet" type="text/javascript" href="javascript/javascript.js" media="screen" />

			
			<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
			
			<script>
	
			/* ============================================================================================
			================================== ------------------------- =================================
			================= FUNÇÃO PARA GERAR ARQUIVO XLS E EXPORTAR PARA ONDE USUARIO QUISER ==========
			================================== ------------------------- ================================= */
			
			function exceller() {
				var uri = 'data:application/vnd.ms-Excel;base64,',
				  template = '<html xmlns:o="urn:schemas-Microsoft-com:office:office" xmlns:x="urn:schemas-Microsoft-com:office:Excel" xmlns="http://www.w3.org/TR/REC-html40"><head><meta charset="UTF-8"><!--[if gte mso 9]><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet><x:Name>{worksheet}</x:Name><x:WorksheetOptions><x:DisplayGridlines/></x:WorksheetOptions></x:ExcelWorksheet></x:ExcelWorksheets></x:ExcelWorkbook></xml><![endif]--></head><body><table>{table}</table></body></html>',
				  base64 = function(s) {
					return window.btoa(unescape(encodeURIComponent(s)))
				  },
				  format = function(s, c) {
					return s.replace(/{(\w+)}/g, function(m, p) {
					  return c[p];
					})
				  }
				var toExcel = document.getElementById("exportarExcel").innerHTML;
				var ctx = {
				  worksheet: name || '',
				  table: toExcel
				};
				var link = document.createElement("a");
				link.download = "documento";
				link.href = uri + base64(format(template, ctx))
				link.click();
			}
			</script>
		
		</head>
		
	<!---------------------------COMEÇANDO CORPO DA PÁGINA---------------------------->

	<body>
		
		<!-- =========================================== ********************************** ==============================
			===================================================== DIV CABECALHO ============================================
			=========================================== ********************************======================================-->
		
		<div id="cabecalho" style="z-index:1000;background-color: white;   display: flex;  align-items: center; box-shadow: 0 3px 0 rgba(0, 0, 0, .3),  0 2px 7px rgba(0, 0, 0, 0.2);    color: white;  height:3.2rem; top:0px; left:0px; 
		margin: 0 auto;     position:fixed;      width: 100%; "> 
			 &nbsp; <a href="#" onclick="mostraPrincipal()" title="Voltar ao Painel"><img src="inicial.png" title="Página Inicial" style="width: 110px; height: 38px; text-align: center;" /></a>
				
			<label onclick="mostraPrincipal()" title="Tela Inicial" for="logins" style="cursor: pointer; text-align: center; margin-left:-7rem; font-size: 1.1rem; font-weight:normal; margin-top: -1.2rem;"><br>Análise de Documentos Recebidos (<?php echo date('d/m/Y'); ?>)</label>  
		
			<label class="botaoSair" style=" display: flex;  align-items: center; text-align: center; position:fixed; margin-top:-0.1rem;  right:7rem; width: 9rem;  color: white; font-size: 0.9rem;
			height: 1.7rem;   background-color: gray; border-radius:5px; text-align:center; z-index:1000;">&nbsp;Versão 1.7.22</label>
		
			<a href="#" title="Sair do sistema" style="text-decoration: none;">
				<label class="botaoSair" style=" display: flex;  align-items: center; text-align: center; position:fixed; margin-top:-0.9rem; right:5px; width: 6rem;  cursor:pointer; color: white; font-size: 1rem;
				height: 1.7rem;   background-color: #f24a4a; border-radius:5px; text-align:center; z-index:1000;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Sair</label>
			</a>				
		</div>
		
		<?php
			$contador_Baixas = 0;
			try {
				$Conexao    = Conexao::getConnection(); //SELECT PARA CONTAR QUANTOS USUÁRIOS TEM NO TOTAL
								
				$usuarios2   = $query2->fetchAll();
			
					foreach($usuarios2 as $busca_usuario2) {							
						$contador_Baixas = $busca_usuario2['xx'];							
					} 					
				 
				}	catch (Exception $e){	}
		
		?> 	
		
		<table style="margin-left:75%; width: 25%; margin-top:4rem;" >
			<tr>
				<td>
					<div style="box-shadow: 0 3px 0 rgba(0, 0, 0, .3),  0 2px 7px rgba(0, 0, 0, 0.2);   font-size:0.9rem; font-height: normal; background-color: #102d57; height:7rem; width: 90%; display: flex; justify-content: center; align-items: center; color: white; ">
						<?php echo "<label style='cursor: pointer;  font-size: 3rem; color: white; text-align:center; font-weight: normal;' onclick='geral()'>".$contador_Baixas."</label>"; ?>
						DOCUMENTOS RECEBIDOS HOJE
					</div>
				</td>
				</tr>
				
				<tr>
				<td>
					<div style="margin-top: 1rem; box-shadow: 0 3px 0 rgba(0, 0, 0, .3),  0 2px 7px rgba(0, 0, 0, 0.2);   font-size:0.9rem; font-height: normal; background-color: #2f445e; height:7rem; width: 90%; display: flex; justify-content: center; align-items: center; color: white; ">
						<?php
						
						$arquivo = 'lerDocumentos_BaixaWeb.txt';

						// Cria o recurso (abrir o arquivo)
						$handle = fopen( $arquivo, 'r' );

						// Lê o arquivo (se existir) 
						$ler = fread( $handle, filesize($arquivo) );
						
						echo "<label style='cursor: pointer;  font-size: 3rem; color: white; text-align:center; font-weight: normal;' onclick='atraso()'>".$ler."</label>";
						?>
						DOCUMENTOS PENDENTES
					</div>
				</td>
				</tr>
				<tr>
				<td>
					
					<div style="margin-top: 1rem;  box-shadow: 0 3px 0 rgba(0, 0, 0, .3),  0 2px 7px rgba(0, 0, 0, 0.2);   font-size:0.9rem; font-height: normal; background-color: #3e4857; height:7rem; width: 90%; display: flex; justify-content: center; align-items: center; color: white; ">
						&nbsp;&nbsp;DOWNLOAD DE<br>&nbsp;&nbsp;DOCUMENTOS<br>&nbsp;&nbsp;RECEBIDOS HOJE&nbsp;
						<a onclick="exceller()" title="Gerar relatório (.XLS)" style="text-decoration: none;">
						<img src="download.png" style="width: 80px; height: 80px; cursor: pointer;" />
						</a>
					</div>
				</td>					
			</tr>
		</table>
			
		<!-- =========================================== ********************************** =========================
			=========================================== ********************************** ==============================
			=================================== DIV BAIXAS DO DIA ======================
			=========================================== ********************************** ==============================
			=========================================== ********************************===============================-->			
			
			<div id="div_baixasdodia" style="width: 100%;  margin-top:-23.5rem; margin-left:1rem; color: black; text-align:center; "> 
			<?php		
			
			try {
				$Conexao    = Conexao::getConnection(); //CONECTANDO COM O BANCO
								
				$usuarios   = $query->fetchAll();				
				
				echo "<table id='exportarExcel' style=' background-color: #ffffff; width:70%; border-color:black; box-shadow: 0 2px 0 rgba(0, 0, 0, .3),  0 2px 3px rgba(0, 0, 0, 0.2);'>						
						
						<tr style='font-size: 0.7rem; font-weight: bold; background-color: #2f445e;   height:2rem;'>
						<td style='width: 1rem; color: white;  border-color:black; box-shadow: 0 2px 0 rgba(0, 0, 0, .3),  0 2px 3px rgba(0, 0, 0, 0.2);'>TIPO DOC</td>
						<td style='width: 1rem; color: white;  border-color:black; box-shadow: 0 2px 0 rgba(0, 0, 0, .3),  0 2px 3px rgba(0, 0, 0, 0.2);'>FILIAL</td>
						<td style='color: white;  border-color:black; box-shadow: 0 2px 0 rgba(0, 0, 0, .3),  0 2px 3px rgba(0, 0, 0, 0.2);'>CT-e</td>
						<td style='color: white;  border-color:black; box-shadow: 0 2px 0 rgba(0, 0, 0, .3),  0 2px 3px rgba(0, 0, 0, 0.2);'>CHAVE ELETRÔNICA</td>
						<td style='color: white;  border-color:black; box-shadow: 0 2px 0 rgba(0, 0, 0, .3),  0 2px 3px rgba(0, 0, 0, 0.2);'>DATA ENTREGA</td>
						<td style='color: white;  border-color:black; box-shadow: 0 2px 0 rgba(0, 0, 0, .3),  0 2px 3px rgba(0, 0, 0, 0.2);'>HORARIO DE RECEBIMENTO</td>
						<td style='width: 7rem; color: white; border-color:black; box-shadow: 0 2px 0 rgba(0, 0, 0, .3),  0 2px 3px rgba(0, 0, 0, 0.2);'>USUÁRIO</td>						
						</tr>";
				
					foreach($usuarios as $busca_usuario) {						
					
							echo "<tr style='background-color: #f5f5f5; height:1.6rem;'>";
							echo "<td style='width: 1rem;'><label style='font-size:0.7rem; color:black; font-weight:normal; text-align:center;'>".$busca_usuario['xx']."</label></td>"; 
							echo "<td style='width: 1rem;'><label style='font-size:0.7rem; color:black; font-weight:normal; text-align:center;'>".$busca_usuario['xx']."</label></td>"; 
							echo "<td style='width: 1rem;'><label style='font-size:0.7rem; color:black; font-weight:normal; text-align:center;'>".$busca_usuario['xx']."</label></td>";
							echo "<td style='width: 1rem;'><label style='font-size:0.7rem; color:black; font-weight:normal; text-align:center;'>".$busca_usuario['xx']."</label></td>"; 
							echo "<td style='width: 1rem;'><label style='font-size:0.7rem; color:black; font-weight:normal; text-align:center;'>".$busca_usuario['xx']."</label></td>"; 
							echo "<td style='width: 1rem;'><label style='font-size:0.7rem; color:black; font-weight:normal; text-align:center;'>".$busca_usuario['xx']."</label></td>"; 																				
							echo "<td style=''><label style='font-size:0.6rem; background-color: #496282; color:white; font-weight:gold; text-align:center; height: 1.2rem;
							border-color: black; box-shadow: 0 2px 0 rgba(0, 0, .3, 0),  0 2px 3px rgba(0, 0, 0.2, 0); border-radius:4px;'>".$busca_usuario['xx']."</label></td>"; 							
							echo "</tr>";					
						
					}
				} catch (Exception $e){	}	
				echo "</table>";
				
				?> 				 
				
			</div> <!-- FECHA A DIV  -->
			<br><br><br>
			


		<br><br><br>
		
		<!-- =========================================== ********************************** ===========================
		======================================================== DIV RODAPÉ ===========================================
		=========================================== ********************************======================================-->
		<div id="rodape">
			<label style="background-color: #042f66;    text-align: center;    font-weight:normal;    width:100%;
			color:white;     position:fixed;     bottom:0px;       font-size: 0.9rem;    height: 1.8rem;">
				<?php echo date('Y'); ?> Desenvolvido por Marcos Silva 
			</label>
		</div>
			
	</body>
	
</html>
