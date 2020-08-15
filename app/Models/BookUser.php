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

        try {
            $statement = $this->pdo->prepare($sql);
            $this->pdo->beginTransaction();

            $statement->execute($attributes);

            $this->pdo->commit();

            return $statement->rowCount();
        } catch (\Exception $e) {
            dd($e->getMessage());
        }
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

        try {
            $statement = $this->pdo->prepare($sql);
            $this->pdo->beginTransaction();

            $statement->execute();
            $deletedRecords = $statement->rowCount();

            $this->pdo->commit();

            return $deletedRecords;
        } catch (\Exception $e) {
            dd($e->getMessage());
        }
    }
}
