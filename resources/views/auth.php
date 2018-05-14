<?php
/**
 * Created by PhpStorm.
 * User: dima
 * Date: 14.05.18
 * Time: 15:19
 */


?>
<style>
    .content{
        width: 100%;
        height: 600px;
    }
    form{
        margin: 200px auto;
        height: 200px;
        width: 200px;
        padding: 20px;
        border: 1px solid #d4d3d3;
        box-shadow: 0 0 10px rgba(0,0,0,0.5);
    }
    form input{
        margin: 10px 0px;
        max-width: 250px;
        padding: 2px;
        font-size: 16px;
        border-radius: 3px;
        color: #3f51b5;
    }
    .form-footer{
        width: 100%;
        min-height: 20px;
    }
    .form-footer button{
        margin: 5px auto;
        background: #4caf50;
        padding: 5px 20px;
        border: 1px solid #468049;
        border-radius: 3px;
        width: 100px;
        color: #fff;

    }
</style>

<div>
    <?php
    if($result && $result->getStatusCode() == 200){
        var_dump($result->getBody()->getContents());
    }
    ?>
</div>

<div class="content">
    <form method="post" action="/auth">
        <h2 style="#00BCD4">Авторизация</h2>
        <input type="text" name="login" class="login" placeholder="login" required>
        <input type="password" name="pass" class="pass" placeholder="password" required>
        <div class="form-footer">
            <button>Войти</button>
        </div>

    </form>
</div>
