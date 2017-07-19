<?php

    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    require_once "src/Author.php";

    $server = 'mysql:host=localhost:8889;dbname=library_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    class AuthorTest extends PHPUnit_Framework_TestCase
    {
        function testGetName()
        {
            $name = "JK Rowling";
            $test_author = new Author($name);

            $result = $test_author->getName();

            $this->assertEquals($name, $result);
        }

        function testSetName()
        {
            $name = "JK Rowling";
            $test_author = new Author($name);

            $new_name = "Sugar Ray";

            $test_author->setName($new_name);
            $result = $test_author->getName();

            $this->assertEquals($new_name, $result);
        }
    }

?>
