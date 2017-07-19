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

        protected function tearDown()
        {
            Author::deleteAll();
        }
        
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
            $test_author = new Book($name);

            $executed = $test_author->save();

            $this->assertTrue($executed, "Author not successfully saved to database");
        }

        function testGetAll()
        {
            $name = "Calla the Pretty Cool I Guess";
            $test_author = new Author ($name);
            $test_author->save();

            $name_2 = "Dylan the Dastardly";
            $test_author_2 = new Author ($name_2);
            $test_author_2->save();

            $result = Author::getAll();

            $this->assertEquals([$test_author, $test_author_2], $result);
        }

        function testDeleteAll()
        {
            $name = "Steve the Salacious";
            $test_author = new Author ($name);
            $test_author->save();

            $name_2 = "Nathan the National Hero";
            $test_author_2 = new Author ($name_2);
            $test_author_2->save();

            Author::deleteAll();
            $result = Author::getAll();

            $this->assertEquals([], $result);
        }
    }

?>
