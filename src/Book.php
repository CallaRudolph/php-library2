<?php
    class Book
    {
        private $title;
        private $id;


        function __construct($title, $id = null)
        {
            $this->title = $title;
            $this->id = $id;
        }

        function getTitle()
        {
            return $this->title;
        }

        function setTitle($new_title)
        {
            $this->title = (string) $new_title;
        }

        function getId()
        {
            return $this->id;
        }

    //     function getCheckedOut()
    //    {
    //        return $this->checked_out;
    //    }
       //
    //    function setCheckedOut($new_checked_out)
    //    {
    //       $this->checked_out = boolval($new_checked_out);
    //    }

        function save()
        {
            $executed = $GLOBALS['DB']->exec("INSERT INTO books (title) VALUES ('{$this->getTitle()}');");
            if ($executed) {
                $this->id = $GLOBALS['DB']->lastInsertId();
                return true;
            } else {
                return false;
            }
        }

        static function getAll()
        {
            $returned_books = $GLOBALS['DB']->query("SELECT * FROM books;");
            $books = array();
            foreach ($returned_books as $book) {
                $title = $book['title'];
                $id = $book['id'];
                $new_book = new Book($title, $id);
                array_push($books, $new_book);
            }
            return $books;
        }

        static function deleteAll()
        {
            $executed = $GLOBALS['DB']->exec("DELETE FROM books;");
            if ($executed) {
                return true;
            } else {
                return false;
            }
        }

        static function find($search_id)
        {
            $found_book = null;
            $returned_books = $GLOBALS['DB']->prepare("SELECT * FROM books WHERE id = :id");
            $returned_books->bindParam(':id', $search_id, PDO::PARAM_STR);
            $returned_books->execute();
            foreach($returned_books as $book) {
                $title = $book['title'];
                $id = $book['id'];
                if ($id == $search_id) {
                    $found_book = new Book($title, $id);
                }
            }
            return $found_book;
        }

        function update($new_title)
        {
            $executed = $GLOBALS['DB']->exec("UPDATE books SET title = '{$new_title}' WHERE id = {$this->getId()};");
            if ($executed) {
                $this->setTitle($new_title);
                return true;
            } else {
                return false;
            }
        }

        function delete()
        {
            $executed = $GLOBALS['DB']->exec("DELETE FROM books WHERE id = {$this->getId()};");
            if ($executed) {
                return true;
            } else {
                return false;
            }
        }

        function addAuthor($author)
        {
            $executed = $GLOBALS['DB']->exec("INSERT INTO authors_books (book_id, author_id) VALUES ({$this->getId()}, {$author->getId()});");
            if ($executed) {
                return true;
            } else {
                return false;
            }
        }

        function getAuthors()
        {
            $returned_authors = $GLOBALS['DB']->query("SELECT authors.* FROM books
                JOIN authors_books ON (authors_books.book_id = books.id)
                JOIN authors ON (authors.id = authors_books.author_id)
                WHERE books.id = {$this->getId()};");
            $authors = array();
            foreach($returned_authors as $author) {
                $name = $author['name'];
                $id = $author['id'];
                $new_author = new Author($name, $id);
                array_push($authors, $new_author);
            }
            return $authors;
        }

        // function updateCheckedOut($new_checked_out)
        // {
        //     $executed = $GLOBALS['DB']->exec("UPDATE books SET checked_out = '{$new_checked_out}' WHERE id = {$this->getId()};");
        //     if ($executed) {
        //     $this->setCheckedOut($new_checked_out);
        //     return true;
        //     }   else {
        //         return false;
        //     }
        // }
    }
?>
