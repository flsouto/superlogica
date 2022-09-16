# Exercício 3
Este exercício foi resolvido com `sqlite` e `pdo`. Garanta que o arquivo exercicio3.db
exista na pasta e possua permissão de escrita.

## Concatenação de strings
Para a concatenação eu usei o operador `||` que é o mesmo usado no posgresql.
Se fosse Mysql deveríamos usar a função `CONCAT`.

## Critério para listagem
Utilizei o critério `id IN (1,2,4)` para selecionar apenas aqueles personagens.
Mas poderia ter usado `nome LIKE '%r'` pois todos terminam com "r", veja:

- Peter Parke**r**
- Luke Skywalke**r**
- Bruce Banne**r**

## Ordenação
Não sei se era a intenção deixar exatamente na mesma ordem, mas como eu percebi
que isso erra possível através do CPF, não hesitei em ordenar por essa coluna,
para deixar o resultado idêntico ao esperado.


