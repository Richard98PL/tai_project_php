<?php  if (count($user->errors) > 0) : ?>
  <div class="error">
    <?php foreach ($user->errors as $error) : ?>
      <p><?php echo $error ?></p>
    <?php endforeach ?>
  </div>
<?php  endif ?>