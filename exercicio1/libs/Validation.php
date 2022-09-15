<?php

$validation->add('nome', new Validators\Required());
$validation->add('email', new Validators\Unique('fieldname'));
$validation->add('');

if($error = $validation->check($_POST)){

}
