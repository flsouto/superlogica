<?php
// 1. Crie um array
$array = [];

// 2. Popule este array com 7 números
$array = [9,2,5,4,10,7,14];

// 3. Imprima o número da posição 3 do array
echo $array[3];

// 4. Crie uma variável com todas as posições do array no formato de string separado por vírgula
$posicoes = implode(',',$array);

// 5. Crie um novo array a partir da variável no formato de string que foi criada e destrua o array anterior
$new_array = explode(',',$posicoes);
unset($array);

// 6. Crie uma condição para verificar se existe o valor 14 no array
if(in_array(14, $new_array)){
    echo "existe!\n";
}

// 7. Faça uma busca em cada posição. Se o número da posição atual for menor que o da posição anterior (valor anterior que não foi excluído do array ainda), exclua esta posição
// entenderei "exclua esta posição" como "exclua a posição atual"
$prev_pos = 0;
$count = count($new_array);
for($i=1;$i<$count;$i++){
    if($new_array[$i] < $new_array[$prev_pos]){
        unset($new_array[$i]);
    } else {
        $prev_pos = $i;
    }
}

// 8. Remova a última posição deste array
array_pop($new_array);

// 9. Conte quantos elementos tem neste array
echo count($new_array);

// 10. Inverta as posições deste array
$invertido = array_reverse($new_array);
