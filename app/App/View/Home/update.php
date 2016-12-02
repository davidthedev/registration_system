<?php use App\Core\Config; ?>

<h1>Update</h1>

<?php foreach ($messages as $message) {
    echo $message;
} ?>

<div class="form-style">
    <form method="POST" action="<?php echo Config::get('CURRENT_URL'); ?>">

        <label>First Name</label>
        <input type="text" name="firstname" class="input-style" placeholder="First Name"
            value="<?php echo $firstname; ?>" autocomplete="off">

        <label>E-mail</label>
        <input type="text" name="email" class="input-style" placeholder="E-mail"
            value="<?php echo $email; ?>" autocomplete="off">

        <input type="hidden" name="token" value="<?php echo $token; ?>">
        <button type="submit" class="btn btn-lg btn-success" name="update">Update</button>

        <a href="<?php echo Config::get('URL') . 'home'; ?>" class="btn btn-lg btn-main"
            name="back">Back</a>
    </form>
</div>
