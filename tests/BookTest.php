<?php

    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    require_once "src/Book.php";
    require_once "src/Author.php";

    $server = 'mysql:host=localhost:8889;dbname=library_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);


    class BookTest extends PHPUnit_Framework_TestCase
    {

        protected function tearDown()
        {
            Book::deleteAll();
            Author::deleteAll();
        }

        function testGetTitle()
        {
            // Arrange
            $title = 'Beats Me';
            $test_book = new Book($title);

            // Act
            $result = $test_book->getTitle();

            // Assert
            $this->assertEquals($title, $result);
        }

        function testSetTitle()
        {
            // Arrange
            $title = 'Beats Me';
            $test_book = new Book($title);

            $new_title = 'Brokeback Mountain';

            // Act
            $test_book->setTitle($new_title);
            $result = $test_book->getTitle();

            // Assert
            $this->assertEquals($new_title, $result);
        }

        function testGetId()
        {
            // Arrange
            $title = 'Beats Me';
            $test_book = new Book($title);
            $test_book->save();

            // Act
            $result = $test_book->getId();

            // Assert
            $this->assertTrue(is_numeric($result));
        }

        function testSave()
        {
            //Arrange
            $title = "Beats Me";
            $test_book= new Book($title);

            //Act
            $executed = $test_book->save();

            // Assert
            $this->assertTrue($executed, "Book not successfully saved to database");
        }

        function testGetAll()
        {
            $title = 'Beats Me';
            $test_book = new Book($title);
            $test_book->save();

            $title2 = 'Brokeback Mountain';
            $test_book2 = new Book($title2);
            $test_book2->save();

            $result = Book::getAll();

            $this->assertEquals([$test_book, $test_book2], $result);
        }

        function testDeleteAll()
        {
            $title = 'Beats Me';
            $test_book = new Book($title);
            $test_book->save();

            $title2 = 'Brokeback Mountain';
            $test_book2 = new Book($title2);
            $test_book2->save();

            Book::deleteAll();
            $result = Book::getAll();

            $this->assertEquals([], $result);
        }

        function testFind()
        {
            $title = 'Beats Me';
            $test_book = new Book($title);
            $test_book->save();

            $title2 = 'Brokeback Mountain';
            $test_book2 = new Book($title2);
            $test_book2->save();

            $result = Book::find($test_book->getId());

            $this->assertEquals($test_book, $result);
        }

        function testUpdate()
        {
            $title = 'Beats Me';
            $test_book = new Book($title);
            $test_book->save();

            $new_title = "Brokeback Mountain";

            $test_book->update($new_title);

            $this->assertEquals("Brokeback Mountain", $test_book->getTitle());
        }

        function testDelete()
        {
            $title = 'Monkey Butts and Stuff';
            $test_book = new Book($title);
            $test_book->save();

            $title_2 = 'Seymour Butts';
            $test_book_2 = new Book($title_2);
            $test_book_2->save();

            $test_book->delete();

            $this->assertEquals([$test_book_2], Book::getAll());
        }
    }
?>
