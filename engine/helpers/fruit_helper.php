<?php
@require ('/vendor/autoload.php');
require ('/vendor/fruit/fruit/fruit.php');
if (!function_exists('fruit_get_instance'))
{
    function fruit_get_instance($name = false)
    {
        return Fruit::get_instance($name);
    }
}
