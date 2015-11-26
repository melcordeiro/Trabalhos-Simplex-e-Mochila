<?php
$file_name = 'Dims.txt';
$file_colls = 'Colls.txt';

function ler_arquivo($file_name)
{
    $fd = @fopen($file_name, 'r');
    $file_content = fread($fd, filesize($file_name));
    fclose($fd);
    $var = unserialize($file_content);
    return $var;
}
$resultado = ler_arquivo($file_name);
$cabecalio = ler_arquivo($file_colls);
$rows = $resultado['linhas'];
$colls = $resultado['colunas'];

$c='c';
$celulas = array();
$i=0;
$j=0;
$sorter = array();
$sindex=0;
$maxw;

if(isset($_GET['maximo'])){	
		$maxw=$_GET['maximo'];
}
/*echo "CELULAS"; echo "<br>";
echo "PESO MAXIMO: ".$maxw; echo "<br>";
echo "ROWS: ". $rows."<br>";
echo "COLLS: ". $colls."<br><br>";*/

for($i=0,$j=0;$i<$rows-1;)
{
	
	if(isset($_GET[$c.$i.$j])){	
		$celulas[$i][$j]=$_GET[$c.$i.$j];	// células		
		//echo $celulas[$i][$j]."  ";
		if($j==1)
		{	
			$sorter[$sindex]=$celulas[$i][$j];
			$sindex++;
		}
		$j++;		
	}
	
	if($j==$colls)
	{
		$j=0;
		$i++;
		//echo '<br>';
	}
}

sort($sorter);

//echo "<br>Pós Sort por peso <br>";

$auxi=0;
$auxj=0;

//echo "<br><br>Organizando por ordem crescente de peso<br>";
$celaux= array();
$sortaux=0;
$bre=false;
//arrumar backtracking para maior valor em peso repetido ir para baixo;
$auxname;
$auxpeso;
$auxval;
for($i=0;$i<$rows-1;$i++)
{
	$j=1;

	for($j=1;$j<$colls-1;$j++)
	{
		
		if($celulas[$i][$j]==$sorter[$sortaux])
		{	
			//Se houver o mesmo peso mas o valor for menor, o mais valioso deve ir pra baixo;
			if($auxi>0 and ($celulas[$i][$j]==$celaux[$auxi-1][$auxj+1]) and ($celulas[$i][$j+1]<$celaux[$auxi-1][$auxj+2]))
			{
				//salvando dados do reg anterior
				$auxname=$celaux[$auxi-1][$auxj];
				$auxpeso=$celaux[$auxi-1][$auxj+1];
				$auxval=$celaux[$auxi-1][$auxj+2];
				
				//Reg anterior recebe o atual (de menor valor )
				$celaux[$auxi-1][$auxj]=$celulas[$i][$j-1];
				$celaux[$auxi-1][$auxj+1]=$celulas[$i][$j];
				$celaux[$auxi-1][$auxj+2]=$celulas[$i][$j+1];
				
				//Reg atual recebe valores do reg atnerior (de maior valor)
				$celulas[$i][$j-1]=$auxname;
				$celulas[$i][$j]=$auxpeso;
				$celulas[$i][$j+1]=$auxval;
				
			}	
			
			$celaux[$auxi][$auxj]=$celulas[$i][$j-1];
			//echo $celaux[$auxi][$auxj]."  ";
			$celaux[$auxi][$auxj+1]=$celulas[$i][$j];
			//echo $celaux[$auxi][$auxj+1]."  ";
			$celaux[$auxi][$auxj+2]=$celulas[$i][$j+1];
			//echo $celaux[$auxi][$auxj+2]."  ";
			$auxi++;$auxj=0;
			$celulas[$i][$j]=null;
			$sortaux++;
			$i=0;
			$j=0;
			if($sortaux==$sindex)
			{
				$bre=true;
				break;
			}	
			
		echo"<br>";
		}
	}

	if($bre==true)
		break;
}

$o = array();
$passou=false;
for($i=0;$i<=$maxw;$i++)
{
	$o[$i]=$i;
}
$mochila= array();

echo"<form name='tab1' method='GET' action='S3.php' align='center'>
			<table border='1' align='center' ";
	
for($i=-1;$i<$rows-1;$i++)
{
	echo"<tr>";
	if($i>-1)
	{
			
		for($j=0;$j<$colls;$j++)
		{
			echo"<td align='center' >".$celaux[$i][$j]."</td>";
		}
		for($l=0;$l<=$maxw;$l++)// logica mochila
		{
			if($sorter[$i]>$o[$l])
			{
				if($i>0)
					$mochila[$i][$l]=$mochila[$i-1][$l];
				else
					$mochila[$i][$l]=0;
			}
			else
			{
				if($i>0)
					$mochila[$i][$l]=$celaux[$i][2] + ($mochila[$i-1][ $o[$l]-$sorter[$i]] );
				else
					$mochila[$i][$l]=$celaux[$i][2];
			}
			//echo $mochila[$i][$l]."<br>";
			echo"<td align='center'>".$mochila[$i][$l]."</td>";
		}
	}	
	else
	{	
		echo"<td align='center'>Nome Item</td>";echo"<td align='center'>Peso</td>";echo"<td align='center'>Valor</td>";
		for($l=0;$l<=$maxw;$l++)
		{
			echo"<td align='center'>$o[$l]</td>";
		}
		echo"</tr>"; echo"<tr>";
		echo"<td align='center'>0</td>";echo"<td align='center'>0</td>";echo"<td align='center'>0</td>";
		for($l=0;$l<=$maxw;$l++)
		{
			echo"<td align='center'>0</td>";
		}
	}	
	echo"</tr>";
}
echo"</table>";echo"</form>";

echo"<br><br>Itens que deve levar<br>";
$i--;
$l--;
$somapeso=0;
$somavalor=0;
$savei=$i;
$savel=$l;

//busca o maior valor para começar o backtracking
$maiorvalor=0;

for($l,$i;$i>=0;$i--)
{
	if($mochila[$i][$l]>$maiorvalor)
	{
		$maiorvalor=$mochila[$i][$l];
		$savei=$i; $savel=$l;
	}
}


for($savel,$savei;$savei>=0;$savei--)
{
	if(($savei==0 and $mochila[$savei][$savel]!=0) or ($savei>0 and $mochila[$savei][$savel]!=$mochila[$savei-1][$savel]))
	{
		echo $celaux[$savei][0]."<br>";
		$somapeso+= $celaux[$savei][1];
		$somavalor+=$celaux[$savei][2];
		$savel=$sorter[$savei]-$savel;
		if($savel<0)
			$savel*=-1;
		if($savei==0)
			break;
		
	}	
}
echo"<br>";
echo"PESO TOTAL = ".$somapeso."<br>";
echo"VALOR TOTAL = ".$somavalor;
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