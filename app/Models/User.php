<?php


namespace App\Models;


use App\Libraries\Auth;
use App\Libraries\ValidateRequest;
use App\Libraries\ValidationRules;

class User extends Model
{
    const PRIVILEGES_ADMINISTRATOR = 2;

    public $id;
    public $email;
    public $password;
    public $first_name;
    public $last_name;
    public $active;
    public $privileges;

    private $fillable = [
        'email',
        'password',
        'first_name',
        'last_name',
        'active',
        'privileges',
        'created_at',
        'updated_at'
    ];

    public function create($attributes)
    {
        $sql = sprintf(
            'INSERT INTO %s (%s) values (%s)',
            'users',
            implode(',', array_keys($attributes)),
            ':' . implode(', :', array_keys($attributes))
        );

        $statement = $this->pdo->prepare($sql);
        $statement->execute($attributes);

        return $this->find($this->pdo->lastInsertId());
    }

    public function list()
    {
        $sql =  sprintf('SELECT * FROM %s', 'users');
        $statement = $this->pdo->query($sql);

        return $statement->fetchAll(\PDO::FETCH_CLASS, User::class);
    }

    public function update($attributes, $userId)
    {
        $fields = '';

        foreach ($attributes as $key => $value) {
            if (in_array($key, $this->fillable) && !empty($value)) {
                $fields .= "{$key} = :{$key}, ";
            }
        }

        $fields = rtrim(trim($fields), ',');

        $sql = sprintf(
            'UPDATE %s SET %s WHERE id = %s',
            'users',
            $fields,
            $userId
        );

        $statement = $this->pdo->prepare($sql);
        $statement->execute(array_filter($attributes));

        return $statement->rowCount();
    }

    public function isAdmin()
    {
        if ($this->privileges == 0) {
            return false;
        }

        return $this->privileges % self::PRIVILEGES_ADMINISTRATOR === 0;
    }

    public function isActive()
    {
        return $this->active;
    }

    public function getNames()
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    public function hasBookInCollection($bookId)
    {
        $sql = sprintf('
                SELECT books.* FROM %s
                INNER JOIN %s ON %s = %s
                INNER JOIN %s ON %s = %s
                WHERE %s = %s
                AND %s = %s
            ', 'users',
            'book_user', 'users.id', 'book_user.user_id',
            'books', 'books.id', 'book_user.book_id',
            'users.id', Auth::user()->id,
            'books.id', $bookId
        );

        $statement = $this->pdo->query($sql);

        return $statement->rowCount();
    }

    public function activate($userId)
    {
        $sql = sprintf('UPDATE users SET active = true WHERE id = %s', $userId);

        $statement = $this->pdo->prepare($sql);
        $statement->execute();

        return $statement->rowCount();
    }

    public function deactivate($userId)
    {
        $sql = sprintf('UPDATE users SET active = false WHERE id = %s', $userId);

        $statement = $this->pdo->prepare($sql);
        $statement->execute();

        return $statement->rowCount();
    }

    public function books()
    {
        $sql = sprintf('
                SELECT books.* FROM %s
                INNER JOIN %s ON %s = %s
                INNER JOIN %s ON %s = %s
                WHERE %s = %s
            ', 'users',
            'book_user', 'users.id', 'book_user.user_id',
            'books', 'books.id', 'book_user.book_id',
            'users.id', Auth::user()->id
        );

        $statement = $this->pdo->query($sql);

        return $statement->fetchAll(\PDO::FETCH_CLASS, Book::class);
    }

    public function find($id)
    {
        $sql = sprintf('SELECT * FROM %s WHERE %s = %s', 'users', 'id', $id);

        $statement = $this->pdo->query($sql);

        if (!$statement->rowCount()) {
            return null;
        }

        return $statement->fetchAll(\PDO::FETCH_CLASS, User::class)[0];
    }

    public function login($email)
    {
        $sql = sprintf('SELECT * FROM %s WHERE %s = \'%s\'', 'users', 'email', $email);

        $statement = $this->pdo->query($sql);

        if (!$statement->rowCount()) {
            return null;
        }

        return $statement->fetchAll(\PDO::FETCH_CLASS, User::class)[0];
    }

    public function getImage()
    {
        return str_replace('\\', '/', self::IMAGE_DIRECTORY . $this->id . DIRECTORY_SEPARATOR . $this->image);
    }
}
