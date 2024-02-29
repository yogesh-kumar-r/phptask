<?

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $fillable = ['title'];

    public function borrowers()
    {
        return $this->belongsToMany(User::class, 'borrowings')
                    ->withPivot('borrowed_at', 'returned_at')
                    ->withTimestamps();
    }
}