<?php

function debug($tab)
{
	echo '<pre style="height:100px;overflow-y: scroll;font-size:.5rem;padding: .6rem; font-family: Consolas, Monospace;background-color: #000;color:#fff;">';
	print_r($tab);
	echo '</pre>';
}

function dump($tab)
{
	echo '<pre style="background-color:black;">';
	var_dump($tab);
	echo '</pre>';
}

function validText($er, $data, $key, $min, $max)
{
    if(!empty($data)) {
        if(mb_strlen($data) < $min) {
            $er[$key] = 'min '.$min.' caractères';
        } elseif(mb_strlen($data) >= $max) {
            $er[$key] = 'max '.$max.' caractères';
        }
    } else {
        $er[$key] = 'Veuillez renseigner ce champ';
    }
    return $er;
}

function validEmail($er, $data, $key)
{
	if(!empty($data)) {
		if (!filter_var($data, FILTER_VALIDATE_EMAIL)) {
			$err[$key] = 'Vueillez renseigner un email valide';
		}
	} else {
		$er[$key] = 'Vueillez renseigner votre email';
	}
	return $er;
}

function cleanXss($key)
{
	return trim(strip_tags($key), "\n");
}

function generateGroupName($tab1, $tab2, string $balise = 'div', string $color = 'pink')
{
	$index1 = array_rand($tab1);
	$index2 = array_rand($tab2);

	$concat = ucwords($index1 . ' ' . $index2);
	return '<'.$balise.' style="background-color: ' .$color. ';">' .$concat. '</'.$balise.'>';
}

function getValue($key,$data = null){
    if(!empty($_POST[$key])) {
        return $_POST[$key];
    } else {
        if(!empty($data)) {
            return $data;
        }
    }
    return '';
}

function abort404() {
	header('HTTP/1.0 404 Not Found');
	header('Location: 404.php');
}

function getError($errors, $key) {
	return (!empty($errors[$key])) ? $errors[$key] : '';
}

function pageIn($page, $itemPage, $count)
{
	$html = '';
	$html .= '<ul class="paginate">';
	if($page > 1) {
		$paged = $page - 1;
		$html .= '<li><a href="index.php?page='.$paged.'">Précédent</a></li>';
	}
	if($page * $itemPage < $count) {
		$paged = $page + 1;
		$html .= '<li><a href="index.php?page='.$paged.'">Suivant</a></li>';
	}
	$html .= '</ul>';
	return $html;
}
