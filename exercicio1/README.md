# Exercicio1

## Instalação
Para rodar este programa é necessário criar 
um arquivo `exercicio1.db` e garantir que ele tenha
a permissão de escrita.

Também é necessário ter a extensão `sqlite` instalada.

Dica: este app foi desenvolvido e testado usando o seguinte container:
```
docker run -d -p 80:80 --name my-apache-php-app -v "$PWD":/var/www/html php:7.2-apache
```
Claro, você não precisa utilizar docker caso já tenha PHP 7.2 instalado + apache/nginx + extensões etc...

## Arquitetura

### Por que escolhi usar PHP puro?
Normalmente eu usaria um framework para construir algo mais complexo
em PHP, como o Symfony ou Laravel, ou ao menos eu instalaria, através do composer, 
a biblioteca DBAL para trabalhar com o banco de dados.

Porém, como este é um projeto simples e a ideia é eu demonstrar minhas
habilidades em PHP e programação orientada a objetos, resolvi criar um
mini-framework utilizando meus conhecimentos de muitos anos.

A seguir, então, eu vou descrever cada componente desse "mini-framework":

### autoload
Para os exemplos abaixo funcionarem é necessário incluir o `autoload.php` que
já se encarrega de encontrar as classes "automagicamente" ;)

Aliás, nunca vi outra linguagem de programação com essa mesma feature, acho
que só o PHP que possui isso, mas posso estar engando...

### Database
Escolhi utilizar sqlite pois é um tipo de banco que cai bem para
projetos simples como este. Para projetos maiores, obviamente eu escolheria
mysql ou posgresql, com os quais eu sei trabalhar muito bem.

Para definir uma tabela dentro do meu
mini-framework, basta estender `AbstractTable` e implementar o método
`getDDL` além da variável `tableName`.

Após feito isso, é só alegria:
```
$users = new Exercicio1\Database\Users();
$insert_id = $users->insert([
    'name' => 'Fábio Souto',
    'userName' => 'flsouto',
    'email' => 'fabiolimasouto@gmail.com',
    'etc...'
]);
$rows = $users->select($fields=['email'],$where=['username'=>'flsouto']);
```

Para os detalhes de como implementei toda essa magia, pode olhar o
conteúdo das classes `AbstractTable` e `Users` (dentro de `libs/database/`).
Lá você vai ter cada variável e método das classes bem documentados.

## Validation
Primeiro eu pensei em colocar um monte de IFs e Elses no insert
da classe `Users` mas aí pensei melhor e resolvi criar uma implementação
do Composite design pattern, que é perfeito para esse tipo de coisa.

Dessa forma, cada regra de validação se tornou um objeto, que pode
ser adicionado ao `Validation` e ser reaproveitado para validar campos
de outras entidades no futuro:

```php 
$val = new Exercicio1\Validation();
$val->add('email', new Exercicio1\Validators\Unique($users, 'email'), 'Email já utilizado');
$val->add('email', new Exercicio1\Validators\Email(), 'Email inválioo');
$dados = ['email' => 'blah'];
if(!$val->validate($dados)){
    echo $val->error();
}
```

Perceba que no exemplo acima eu consegui atingi os seguintes objetivos:

- Criar validadores complexos, que trabalham com banco de dados
- Aplicar diferentes regras para o mesmo campo
- Customizar mensagens de erro

Bem legal né? Nenhuma novidade, já que frameworks como Symfony por exemplo
fazem algo bem parecido. Mas eu gosto de implementar essas coisas para me divertir :)

### Views
As views são templates que ficam dentro da pasta views. Elas devem ter
a extensão ".phtml" que é uma extensão válida no mundo do PHP 
(se não me engano o Zend framework utiliza dessa forma).

Para renderizar uma view, basta usar a classe `View` que está dentro de `libs`:
```php 
$view = new Exercicio1\View("form");
$view->set("campo","valor");
echo $view;
```

Como as views são objetos que implementam __toString, 
é possível compor Views como no exemplo abaixo:
```php 
$page = new Exercicio1\View('page');
$page->set('content', $form);
echo $page;
```

É isso pessoal! Obrigado pela leitura :)
