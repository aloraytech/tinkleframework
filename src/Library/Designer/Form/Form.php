<?php


namespace tinkle\framework\Library\Designer\Form;


use tinkle\framework\Database\Manager\DBManager;
use tinkle\framework\Designer\Form\TextArea;
use tinkle\framework\Library\Encryption\Hash;
use tinkle\framework\Token;

class Form
{


    public function start(string $action, string $method, string $name='',array $options = [])
    {
        $attributes = [];
        foreach ($options as $key => $value) {
            $attributes[] = "$key=\"$value\"";
        }


        $token = Hash::make($_ENV['APP_SECRET'].microtime(true));


        $name = "form-"."$name"."$token";

        echo sprintf('
        <form action="%s" method="%s" name="%s"%s>', $action, $method,$name,implode(" ", $attributes));
        echo sprintf('
            <input type="hidden" value="%s" name="form_token">
        ',$token);
        return new Form();
    }


    public function field(DBManager $model,$attribute,string $id='')
    {
        return new Inputs($model, $attribute,$id);
    }

    public function textarea(DBManager $model,$attribute)
    {
        return new TextArea($model, $attribute);
    }

    public function imageOrFile(DBManager $model,$attribute)
    {
        return new FileField($model, $attribute);
    }


    public function BtnSubmit()
    {
        echo '<button type="submit" class="btn btn-block btn-success">Submit</button>';

    }



    public function end()
    {
        echo '
    </form>';
    }


}