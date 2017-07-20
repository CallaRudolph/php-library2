<?php

    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    require_once "src/Author.php";
    require_once "src/Book.php";

    $server = 'mysql:host=localhost:8889;dbname=library_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    class AuthorTest extends PHPUnit_Framework_TestCase
    {

        protected function tearDown()
        {
            Author::deleteAll();
            Book::deleteAll();
            Patron::deleteAll();
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

        function testFind()
        {
            $name = "Steve the Salacious";
            $test_author = new Author ($name);
            $test_author->save();

            $name_2 = "Nathan the National Hero";
            $test_author_2 = new Author ($name_2);
            $test_author_2->save();

            $result = Author::find($test_author->getId());

            $this->assertEquals($test_author, $result);
        }

        function testUpdate()
        {
            $name = "Steve the Salacious";
            $test_author = new Author ($name);
            $test_author->save();

            $new_name = "Larry the larbear";

            $test_author->update($new_name);

            $this->assertEquals("Larry the larbear", $test_author->getName());
        }

        function testDelete()
        {
            $name = "Steve the Salacious";
            $test_author = new Author ($name);
            $test_author->save();

            $name_2 = "Nathan the National Hero";
            $test_author_2 = new Author ($name_2);
            $test_author_2->save();

            $test_author->delete();

            $this->assertEquals([$test_author_2], Author::getAll());
        }

        function testAddBook()
        {
            $title = "You. Who are you?";
            $test_book = new Book($title);
            $test_book->save();

            $name = "Roger Daltrey";
            $test_author = new Author($name);
            $test_author->save();

            $test_author->addBook($test_book);

            $this->assertEquals($test_author->getBooks(), [$test_book]);
        }

        function testGetBooks()
        {
            $title = "Big Fishy";
            $test_book = new Book($title);
            $test_book->save();

            $title2 = "Big Fishy";
            $test_book2 = new Book($title2);
            $test_book2->save();

            $name = "Writer Man";
            $test_author = new Author($name);
            $test_author->save();

            $test_author->addBook($test_book);
            $test_author->addBook($test_book2);

            $this->assertEquals($test_author->getBooks(), [$test_book, $test_book2]);
        }
    }

?>
