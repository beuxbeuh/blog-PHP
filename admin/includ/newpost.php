<?php
require('../../includ/pdo.php');
require('../../includ/function.php');
require('../../includ/request.php');
$errors = [];

if (!empty($_POST['submitted'])) {
	$title = cleanXss($_POST['title']);  //utilisation des function trim() et script_tags() pour eviter les failles XSS
	$content = cleanXss($_POST['content']);
	$auteur = cleanXss($_POST['auteur']);
	$status = cleanXss($_POST['status']);

	$errors = validText($errors, $title, 'title', 3, 60);
	$errors = validText($errors, $content, 'content', 5, 1000);
	$errors = validText($errors, $auteur, 'auteur', 2, 50);
	$errors = validText($errors, $status, 'status', 3, 10);

	if (count($errors) === 0) {
		$sql = "INSERT INTO articles(title, content, auteur, created_at, modified_at, status) VALUES (:title, :content, :auteur, NOW(), NOW(), :status)";
		$query = $pdo->prepare($sql);
		$query->bindValue(':title',$title, PDO::PARAM_STR);
		$query->bindValue(':content',$content, PDO::PARAM_STR);
		$query->bindValue(':auteur',$auteur, PDO::PARAM_STR);
		$query->bindValue(':status', $status,PDO::PARAM_STR);
		$query->execute();
		header('Location: ../index.php');
	}
}





include('header-back.php'); ?>

<form action="" method="post" class="wrap" novalidate>
	<label for="title">Titre</label>
	<input type="text" name="title" id="title" value="<?php if(!empty($_POST['title'])) {echo $_POST['title'];} ?>">
	<span class="error"><?php /* debug();*/ ?></span>

	<label for="content">Contenu</label>
        <textarea name="content" id="content" cols="30" rows="10"><?php if(!empty($_POST['content'])) { echo $_POST['content']; } ?></textarea>
        <span class="error"><?php if(!empty($errors['content'])) { echo $errors['content']; } ?></span>

	<label for="auteur">Auteur</label>
        <input type="text" name="auteur" id="auteur" value="<?php if(!empty($_POST['auteur'])) { echo $_POST['auteur']; } ?>">
        <span class="error"><?php if(!empty($errors['auteur'])) { echo $errors['auteur']; } ?></span>

	<?php $status = ['draft' => 'brouillon', 'publish' => 'Publié']; ?>
	<select name="status">
		<option value="">choix a faire</option>
		<?php foreach ($status as $key => $value) {
			$selected = '';
			if (!empty($_POST['status'])) {
				if ($_POST['status'] == $key) {
					$selected = 'selected="selected"';
				}
			}
		?>1
		<option value="<?php echo $key ?>" <?php echo $selected ?>><?php echo $value ?></option>
		<?php } ?>
	</select>
	<span class="error"><?php if(!empty($errors['status'])) { echo $errors['status']; } ?></span>

	<input type="submit" name="submitted" value="Ajouter un New Post !">
</form>
<?php include('footer-back.php');
