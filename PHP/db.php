<?php
    /**
     * @param name Database name.
     */
    function connectToDatabase($name)
    {
        $db = new PDO("mysql:host=localhost;dbname=$name;charset=utf8", 'php', 'php.shriimpe');
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $db;
    }
?>