# Exercicio 2

Alguns itens ficaram um pouco ambíguos neste exercício. Exemplo:

## 4) Crie uma variável com *todas as posições do array* no formato de string separado por vírgula
Aqui não ficou claro se **posições** são os valores ou as chaves.
Eu acabei optando por valores por fazer mais sentido, mas se fosse chaves bastaria usar `array_keys($array);`

## 7) Faça uma busca em cada posição. Se o número da posição atual for menor que o da posição anterior (valor anterior que não foi excluído do array ainda), exclua esta posição
Aqui o "exclua esta posição" deixa em dúvida se está se refirindo a posição **atual** ou **anterior**.
Mas pela pegadinha descrita no parênteses eu concluí que se deseja excluir a posição atual :P

## 10) Inverta as posições do array
Tenho quase 100% de certeza que se deseja inverter a ordem do array com `array_reverse()`.
Porém não seria dificíl alguém entender que se deseja fazer um `array_flip()`
