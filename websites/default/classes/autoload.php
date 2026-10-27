<?php
//wrriting a function to load files, and it takes the class name as an argument
function saveMemory($name) {
    //replacing backslash with a forward slash, and adding the php extension to the class name and saving it in the variable fileName
    $fileName = str_replace('\\', '/', $name) . '.php'; 
    //loading the file based on the class name taken as an argument, after adding the fileName variable to the absolute path
    require '/websites/default/classes/' . $fileName;
}

//creating and registering the function saveMemory as an autoload to save memoty
spl_autoload_register('saveMemory');
?>