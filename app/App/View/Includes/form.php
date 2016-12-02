<?php use App\Core\Config; ?>

<div class="form-style">
    <form method="POST" action="<?php echo Config::get('URL'); ?>">
        <input type="text" name="username" class="input-style" placeholder="Username">
        <input type="password" name="password" class="input-style" placeholder="Password">
        <button type="submit" class="btn btn-lg btn-main" name="submit"><?php echo $button; ?></button>
    </form>
</div>
