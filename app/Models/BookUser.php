<?php


namespace App\Models;


use App\Libraries\Auth;

class BookUser extends Model
{
    public $user_id;
    public $book_id;
    public $created_at;
    protected $updated_at;

    private $fillable = [
        'user_id',
        'book_id',
        'created_at',
        'updated_at',
    ];

    public function create($attributes)
    {
        $sql = sprintf(
            'INSERT INTO %s (%s) values (%s)',
            'book_user',
            implode(',', array_keys($attributes)),
            ':' . implode(', :', array_keys($attributes))
        );

        $statement = $this->pdo->prepare($sql);
        $statement->execute($attributes);

        return $statement->rowCount();
    }

    public function delete($bookId)
    {
        $sql = sprintf(
            'DELETE FROM %s WHERE %s = %s AND %s = %s',
            'book_user',
            'book_id',
            $bookId,
            'user_id',
            Auth::user()->id
        );

        $statement = $this->pdo->prepare($sql);
        $statement->execute();

        return $statement->rowCount();
    }
}
