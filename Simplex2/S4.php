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



for($i=0,$j=0;$i<$rows-2;)
{
	
	if(isset($_GET[$c.$i.$j])){	
		$celulas[$i][$j]=$_GET[$c.$i.$j];	// células		
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
//identificar o menor valor em Z	
$collmenor;
for($i=$rows-2,$j=0;$j<=$colls-3;$j++)
{
	if(isset($_GET[$c.$i.$j])){	
		$aux=$_GET[$c.$i.$j];	// células
	}
	
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
	echo $menor;
	
//o valor da coluna é o que entra na base
	echo"<br><br>";
	echo $collsmenor;
	echo"<br><br>";
	echo $cabecalio[$collsmenor+2];

//dividir b pela coluna deste menor em Z
$mendiv=null;
$menindex=null;
for($i=$colls-3,$j=0;$j<$rows-2;$j++)
{	
	if($celulas[$j][$collsmenor] != 0)
	{
		if ($mendiv==null)
		{
			$mendiv=($celulas[$j][$i])/($celulas[$j][$collsmenor]);
			$menindex=$j;
		}
		elseif(($celulas[$j][$i])/($celulas[$j][$collsmenor])< $mendiv)
		{
			$mendiv=($celulas[$j][$i])/($celulas[$j][$collsmenor]);
			$menindex=$j;
		}
	}	
}
echo "<br><br>";
//linha de quem sai da base
echo $celulas[$menindex][$collsmenor];
echo "<br><br>";

$base=array();
for($i=1;$i<=$rows-2;$i++)
{
	if(isset($_GET['base'.$i])){
		$base[$i]=$_GET['base'.$i];
		echo $base[$i];
		echo " ";
	}	
}
//o menor quociente indica a variável que sai da base
$base[$menindex]=$cabecalio[$collsmenor+2];
echo"<br>";
echo $base[$menindex];echo"<br>";

//pivo = intersecção entre coluna que entra e linha que sai da base
$pivo=$celulas[$menindex][$collsmenor];

//Dividir todos os elementos da linha do pivo por ele
for(;$j<$colls-2;$j++)
	$celulas[$menindex][$j]=($celulas[$menindex][$j]/$pivo);

//deixar nulo os outros elementos da coluna (exceto pivo):
	//Multiplicar a linha acima por (valor *(-1))[se for a primeira linha, multiplica-se a ultima]
		//e somar com a linha que se deseja zerar o valor da coluna pivo
		// repetir para todos os valores não nulos da coluna do pivo
		//inclusive para o valor da linha Z
$b=0;
$nuller=0;
$savr=0;
$savc=0;

for($i=0,$j=0;$i<$rows-1;$i++)//$j =coluna
{
	if($celulas[$i][$collsmenor]!=0)	
	{
		if($i!=$menindex)
		{
			$nuller=($celulas[$i][$collsmenor]*(-1));
			$savr=$i; $savc=$collsmenor;
			
			for($b=0;$b<=$colls-3;$b++)
			{
				$nuller=(($nuller*$celulas[$menindex][$b])+$celulas[$savr][$savc]);
				$celulas[$savr][$savc]=$nuller;
				echo $celulas[$savr][$savc]; echo ' ';
				$savr++;
			}
			echo "<br>";
		}		
	}
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