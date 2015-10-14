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

$rows = $resultado['linhas']; echo "LINHAS ".$rows; echo"<br>";
$colls = $resultado['colunas']; echo "COLUNAS ".$colls; echo "<br><br>";
$c='c';
$celulas = array();
$i=0;
$j=0;
$menor=-1;
echo "CELULAS"; echo "<br>";

for($i=0,$j=0;$i<$rows-1;)
{
	
	if(isset($_GET[$c.$i.$j])){	
		$celulas[$i][$j]=$_GET[$c.$i.$j];	// c�lulas		
		echo $celulas[$i][$j];
		echo ' ';
		$j++;
	}
	
	if($j==$colls-2)
	{
		$j=0;
		$i++;
		echo '<br>';
	}
}
if(isset($_GET['iter'])){
		$iter[$i]=$_GET['iter'];
	}

$base=array();
for($i=1;$i<=$rows-2;$i++)
{
	if(isset($_GET['base'.$i])){
		$base[$i]=$_GET['base'.$i];
	}
}
$maiorbase=$rows-2;
for(;$menor<0;)//Repeti��o
{
//identificar o menor valor em Z	
$collsmenor;
$i=0;
$j=0;
$menor=0;
for($i=$rows-2,$j=0;$j<=$colls-3;$j++)
{
	$aux=$celulas[$i][$j];	// c�lulas
	
	if($j==0)
	{
		$menor=$aux;
		$collsmenor=$j;
	}
	elseif($aux<$menor)
	{
		$menor=$aux;
		$collsmenor=$j;
	}	
}
//identificar o menor valor em Z
	echo "MENOR ".$menor;
	if($menor>0)
		break;
	
//o valor da coluna � o que entra na base
	
	//echo $cabecalio[$collsmenor+2];

//dividir b pela coluna deste menor em Z
$mendiv=null;
$menindex=null;
$mt=null;
for($i=$colls-3,$j=0;$j<$rows-2;$j++)
{	
	if($celulas[$j][$collsmenor] != 0)
	{
		if ($mendiv==null)
		{
			$mendiv=($celulas[$j][$i])/($celulas[$j][$collsmenor]);
			$menindex=$j;
			if($celulas[$j][$collsmenor]>=0)			
				$mt=$j;
		}
		elseif(($celulas[$j][$i])/($celulas[$j][$collsmenor])< $mendiv)
		{
			$mendiv=($celulas[$j][$i])/($celulas[$j][$collsmenor]);
			$menindex=$j;
			if($celulas[$j][$collsmenor]>=0)			
				$mt=$j;			
		}
	}	
}
echo "<br>";
//linha de quem sai da base
//echo $celulas[$menindex][$collsmenor];

//o menor quociente indica a vari�vel que sai da base
$base[$mt+1]=$cabecalio[$collsmenor+2];
//echo"<br>";

//pivo = intersec��o entre coluna que entra e linha que sai da base

$pivo=$celulas[$mt][$collsmenor];
echo"PIVO".$pivo; echo"<br>";

//echo"<br>"."celulas a serem divididas pelo pivo"."<br>";
//Dividir todos os elementos da linha do pivo por ele
for($j=0;$j<$colls-2;$j++)
{
	//echo $celulas[$mt][$j]; echo" ";
	$celulas[$mt][$j]=($celulas[$mt][$j]/$pivo);	
}

//deixar nulo os outros elementos da coluna (exceto pivo):
	//Multiplicar a linha acima por (valor *(-1))[se for a primeira linha, multiplica-se a ultima]
		//e somar com a linha que se deseja zerar o valor da coluna pivo
		// repetir para todos os valores n�o nulos da coluna do pivo
		//inclusive para o valor da linha Z
$b=0;
$nuller=0;
$savr=0;
$savc=0;

for($i=0,$j=0;$i<$rows-1;$i++)//$j =coluna
{
	if($celulas[$i][$collsmenor]!=0)// Se valor na coluna do pivo !=0	
	{
		if($i!=$mt)// Se valor linha != pivo linha
		{
			$nuller=($celulas[$i][$collsmenor])*(-1);
			
			for($j=0;$j<$colls-2;$j++)// corre a linha que deve ser zerada
			{
				if($mt!=($rows-2))
					$celulas[$i][$j]=(($celulas[$mt][$j])*$nuller)+$celulas[$i][$j];
				else
					$celulas[$i][$j]=(($celulas[$mt][$j])*$nuller)+($celulas[$i][$j] *(-1));
				//echo $celulas[$i][$j]; echo " ";
			}
			//echo "<br>";
		}		
	}
}
/*echo"<br>";
for($l=0;$l<$colls;$l++)
	{
		echo $cabecalio[$l];
		echo " ";
	}*/
	echo"<br>";
	
	for($k=0;$k<$rows-1;$k++)
	{
		if($k<=$maiorbase && $k>0)
		{
			echo $base[$k];
			echo " ";
		}		
		for($m=0;$m<$colls-2;$m++)
		{
			
			echo $celulas[$k][$m];
			echo " ";
		}
		echo "<br>";
	}
	echo "<br>";	
}
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