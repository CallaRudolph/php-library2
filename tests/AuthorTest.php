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

        function testGetId()
        {
            $name = "Maxo B. Axo";
            $test_author = new Author($name);
            $test_author->save();

            $result = $test_author->getId();

            $this->assertTrue(is_numeric($result));
        }

        function testSave()
        {
            $name = "Larry the Amazing";
            $test_book = new Book($name);

            $executed = $test_book->save();

            $this->assertTrue($executed, "Author not successfully saved to database");
        }
    }

?>
