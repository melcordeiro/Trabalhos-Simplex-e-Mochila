<?php
	if(isset($_GET['vars'])){	
		$vars=$_GET['vars'];		//qt variaveis
	}
	
	$tabcolls=(3); // quantidade de colunas ao montar a tabela
	$tabrows=($vars +1);			// quantidade de linhas ao montar a tabela
	
	$colls=array(); // conteudo do cabeçálio da tabela
	$colls[0]="Item";
	$colls[1]="Peso";
	$colls[2]="Valor";
	

	echo"<form name='tab1' method='GET' action='M3.php' align='center'>
			<table border='1' align='center' ";
	
	//1ª tabela
	echo"<center>Inserir os pesos e valores </center>";	
	$i=0;	
	$s=0;
	$c='c';
	for($i=0;$i<$tabrows;$i++)
	{
		echo"<tr>";
		if($i>0)
		{
			$k=0;
			echo"<td align='center'><input type='Text' Required placeholder='Item $i'  name='$c$s$k'> </td>";
			for($k=1;$k<3;$k++)
				echo"<td align='center'><input type='number'required value='0' name='$c$s$k'></td>";
			$s++;
		}	
		else
		{	
			echo"<td align='center'>$colls[0]</td>";
			echo"<td align='center'>$colls[1]</td>";
			echo"<td align='center'>$colls[2]</td>";
		}	
		echo"</tr>";
	}
	echo"</table>";
	echo"<br><center>Peso maximo:<input type='number'required value='1' min='1' name='maximo'></center>";
	echo"<br><center><input type='submit' name='mochila' value='Calcular'></center><br></form>";
	

function ler_arquivo($file_name)
{
    $fd = @fopen($file_name, 'r');
    $file_content = fread($fd, filesize($file_name));
    fclose($fd);
    $var = unserialize($file_content);
    return $var;
}
function gravar_arquivo($file_name, $var)
{
    $content = serialize($var);
    $fd = @fopen($file_name, 'w+');
    fwrite($fd, $content);
    fclose($fd);
    chmod($file_name, 0644);
    return true;
}

$file_name = 'Dims.txt';
$file_colls = 'Colls.txt';

$dimencoes = array(
    'linhas' => $tabrows,
    'colunas' =>  $tabcolls,
);

gravar_arquivo($file_name, $dimencoes);	 // rows & colls
gravar_arquivo($file_colls, $colls);	//cabecalio

?>
<!DOCTYPE HTML>
<html>
	<head>
		<meta http-equiv="content-type" content="text/html; charset=iso-8859-1"/>		
		<title>MOCHILA</title>	
	</head>
	<body>		
	</body>
</html>