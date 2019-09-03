<?php

function Confirm_order()
{
    $quote = new ProjectController();
    $execute = $quote->balance();
    echo $execute;
}
?>