<?php
	if(isset($_GET['vars'])){	
		$vars=$_GET['vars'];		//qt variaveis
	}
	if(isset($_GET['rests'])){	
		$rests=$_GET['rests'];		//qt restrições
	}
	$tabcolls=($vars + $rests + 3); // quantidade de colunas ao montar a tabela
	$tabrows=($rests + 2);			// quantidade de linhas ao montar a tabela
	
	$colls=array(); // conteudo do cabeçálio da tabela
	$colls[0]="Linha";
	$colls[1]="Base";
	
	for($i=2;$i<$vars+2;$i++)	
		($colls["$i"]="x".($i-1));
	
	for($z=0;$z<$rests;$z++,$i++)	
		($colls["$i"]="f".($z+1));
	
	$colls["$i"]="b";
	echo"<form name='tab1' method='GET' action='S3.php' align='center'>
			<table border='1' align='center' ";
	
	//1ª tabela
	echo"<center>Inserir os valores de Z ja invertidos ao da funcao objetivo</center>";	
	$s=0;
	$i=0;	
	for($i=0;$i<$tabrows;$i++)
	{
		echo"<tr>";
		for($j=0;$j<$tabcolls;$j++)
		{
			if($i==0)			
				echo"<td align='center'>$colls[$j]</td>";
		}
		$c='c';
		if($i>0 && $i<($tabrows-1))
		{
				$p=2;
				echo"<td align='center'>$i</td><td align='center'> <select name = 'base$i'>";
					for($p=2;$p<($tabcolls-1);$p++) 
					{
						echo"
						
							<option value=$colls[$p]> $colls[$p] </option>";
					}
						echo"</select></td>";						
					
					for($k=0;$k<($vars+$rests+1);$k++)
						echo"<td align='center'><input type='number'required value='0' name='$c$s$k'></td>";
					$s++;
		}
		elseif($i==($tabrows-1))
		{
			echo"<td align='center'>$i</td> 
					<td align='center'>Z</td>";
				
				for($k=0;$k<($vars+$rests+1);$k++)				
					echo"<td align='center'><input type='number'required value='0' name='$c$s$k'></td>";
				$s++;
		}
		
		echo"</tr>";
	}
	echo"</table>";
	echo"<br><center>Z</td><td><select name='slctVal'>			
			<option value='menor'> <= </option>
			<option value='maior'> >= </option>
			</select></center>";
	echo"<br><center>Iteracoes:<input type='number'required value='1' min='1' name='iter'></center>";
	echo"<br><center><input type='submit' name='simplex' value='Calcular'></center><br></form>";
	

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

gravar_arquivo($file_name, $dimencoes);	
gravar_arquivo($file_colls, $colls);	

?>
<!DOCTYPE HTML>
<html>
	<head>
		<meta http-equiv="content-type" content="text/html; charset=iso-8859-1"/>		
		<title>SIMPLEX</title>	
	</head>
	<body>		
	</body>
</html>