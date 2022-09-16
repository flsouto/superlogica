<?php

$pdo = new \PDO("sqlite:./exercicio3.db");
$pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);

$pdo->exec("
    DROP TABLE IF EXISTS usuario;
    CREATE TABLE usuario(
        id integer primary key, -- sqlite cria auto increment por default
        cpf character(11) not null,
        nome text not null
    );

    INSERT INTO usuario(id, cpf, nome)
    VALUES
    (1, '16798125050', 'Luke Skywalker'),
    (2, '59875804045', 'Bruce Wayne'),
    (3, '04707649025', 'Diane Prince'),
    (4, '21142450040', 'Bruce Banner'),
    (5, '83257946074', 'Harley Quinn'),
    (6, '07583509025', 'Peter Parker');

    DROP TABLE IF EXISTS info;
    CREATE TABLE info(
        id integer primary key,
        cpf character(11) not null,
        genero character(1) not null,
        ano_nascimento integer not null
    );

    INSERT INTO info(id, cpf, genero, ano_nascimento)
    VALUES
    (1, '16798125050', 'M', 1976),
    (2, '59875804045', 'M', 1960),
    (3, '04707649025', 'F', 1988),
    (4, '21142450040', 'M', 1954),
    (5, '83257946074', 'F', 1970),
    (6, '07583509025', 'M', 1972);

");

$st = $pdo->prepare("
    SELECT u.nome || ' - ' || genero as usuario,
        CASE WHEN strftime('%Y') - i.ano_nascimento > 50 THEN 'SIM' ELSE 'NÃO' END as maior_50_anos
        FROM usuario u
        JOIN info i ON i.id = u.id
        WHERE u.id IN (1,4,6) -- o crietério também poderia ser u.nome LIKE '%r' pois todos terminam com r :P
        ORDER BY u.cpf
");

$st->execute();

?>
<table border=1 style="border-collapse:collapse;" width=300>
<thead>
    <th>usuário</th>
    <th>maior_50_anos</th>
</thead>
<tbody>
<?php foreach($st->fetchAll() as $row) : ?>
    <tr>
        <td><?php echo $row['usuario'] ?></td>
        <td><?php echo $row['maior_50_anos'] ?></td>
    </tr>
<?php endforeach; ?>
</tbody>
</table>
