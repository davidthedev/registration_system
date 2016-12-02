<?php require_once INCLUDES . '/header.php'; ?>
<h1>Sign in</h1>
<div class="message">
        <ul>
        <?php foreach ($messages as $message) { ?>
            <li><?php echo $message; ?></li>
        <?php } ?>
        </ul>
</div>
<div class="form-style">
    <form method="POST" action="<?php echo CURRENT_URL; ?>">
        <input type="text" name="username" class="input-style" placeholder="Username">
        <input type="password" name="password" class="input-style" placeholder="Password">
        <div class="remember-forgot">
            <label for="remember-id">Remember me
                <input type="checkbox" id="remember-id" name="remember-me" class="align-left">
            </label>
            <div class="align-right"><a href="<?php echo URL . 'member/forgot'; ?>">Forgotten?</a></div>
        </div>
        <input type="hidden" name="token" value="<?php echo $token; ?>">
        <button type="submit" class="btn btn-lg btn-main" name="submit">Enter</button>
    </form>
</div>
<?php require_once INCLUDES . '/footer.php'; ?>
