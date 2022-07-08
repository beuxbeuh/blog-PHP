<?php
require('../includ/pdo.php');
require('../includ/function.php');
require('../includ/request.php');

if (!empty($_GET['id']) && is_numeric($_GET['id'])) {
	global $pdo;
	$id = $_GET['id'];
	$sql_edit = "SELECT * FROM articles WHERE id = :id";
	$query = $pdo->prepare($sql_edit);
	$query->bindValue(':id', $id, PDO::PARAM_INT);
	$query->execute();
	$article = $query->fetch();
	if(empty($article)) {
		header('Location: 404.php');
	}
} else {
	header('Location: 404.php');
}

$errors = []; // ligne 20

if (!empty($_POST['submitted'])) {
	debug($_POST);
	// on empeche les faillesXss avec les fonction-php trim() et  strip_tags()
	$title = cleanXss($$_POST['title']);
	$content = cleanXss($_POST['content']);
	$auteur = cleanXss($_POST['auteur']);
	$status = cleanXss($_POST['status']);
	// verification des textes avec notre fonction validText()
	$erros = validText($errors, $title,'title', 3, 100);
	$erros = validText($errors, $content,'content',  7, 250);
	$erros = validText($errors, $auteur,'auteur',  2, 30);
	$erros = validText($errors, $status,'status',  3, 10);

	if (count($errors) === 0) {
		$sql = "UPDATE articles SET title = :title,content = :content,auteur = :auteur,modified_at = NOW(),status = :status WHERE id = :id";
		$query = $pdo->prepare($sql);
		$query->bindValue(':title',$title,PDO::PARAM_STR);
		$query->bindValue(':content',$content,PDO::PARAM_STR);
		$query->bindValue(':auteur',$auteur,PDO::PARAM_STR);
		$query->bindValue(':status',$status,PDO::PARAM_STR);
		$query->bindValue(':id',$id,PDO::PARAM_INT);
		$query->execute();
		header('Location: listingpost.php');
	}
}
// ligne 45
include('includ/header-back.php'); ?>

	<h1> Modifier un article</h1>
	<form action="" method="post" class="wrap" novalidate>
        	<label for="title">Titre</label>
	        <input type="text" name="title" id="title" value="<?= getValue('title', $article['title']); ?>">
        	<span class="error"> <?php if(!empty($errors['title'])) { echo $errors['title']; } ?> </span>

	        <label for="content">Contenu</label>
        	<textarea name="content" id="content" cols="30" rows="10"><?= getValue('content', $article['content']); ?></textarea>
	        <span class="error"><?php if(!empty($errors['content'])) { echo $errors['content']; } ?></span>

	        <label for="auteur">Auteur</label>
        	<input type="text" name="auteur" id="auteur" value="<?= getValue('auteur', $article['auteur']); ?>">
	        <span class="error"><?php if(!empty($errors['auteur'])) { echo $errors['auteur']; } ?></span>

        	<?php $status = ['draft' => 'brouillon', 'publish' => 'Publié']; ?>
		<select name="status">
	        	<option value="">choix a faire</option>
        		<?php foreach ($status as $key => $value) {
				$selected = '';
				if (!empty($_POST['status'])) {
					if ($_POST['status'] == $key) {
						$selected = 'selected="selected"';
					} elseif($article['status'] == $key) {
						$selected = ' selected="selected"';
					}
				}
			?>
	                <option value="<?php echo $key ?>" <?php echo $selected ?>><?php echo $value ?></option>
		<?php } ?>
		</select>
		<span class="error"><?php if(!empty($errors['status'])) { echo $errors['status']; } ?></span>

		<input type="submit" name="submitted" value="Editer un post!">
	</form>

<?php include('includ/footer-back.php');
