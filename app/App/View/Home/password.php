<?php use App\Core\Config; ?>

<h1>Member Area</h1>

<?php foreach ($messages as $message) {
    echo $message;
} ?>

<div class="form-style">
    <form method="POST" action="<?php echo Config::get('CURRENT_URL'); ?>">
        <label>Old password</label>
        <input type="password" name="current-password" class="input-style"
            placeholder="Old password" autocomplete="off">

        <label>New password</label>
        <input type="password" name="new-password" class="input-style"
            placeholder="New password" autocomplete="off">

        <input type="hidden" name="token" value="<?php echo $token; ?>">
        <button type="submit" class="btn btn-lg btn-success" name="update">Update</button>
        <a href="<?php echo Config::get('URL') . 'home'; ?>" class="btn btn-lg btn-main" name="back">Back</a>
    </form>
</div>
