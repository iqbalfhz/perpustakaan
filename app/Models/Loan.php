<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Loan extends Model
{
    use HasFactory;

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($loan) {
            // Kurangi stok hanya sekali saat peminjaman dibuat
            if ($loan->book && $loan->status === 'dipinjam') {
                $loan->book->decrement('stock');
            }
        });
    }

    protected $fillable = [
        'member_id',
        'book_id',
        'loaned_at',
        'due_at',
        'returned_at',
        'status',
        'book_condition',
    ];

    protected $casts = [
        'id' => 'integer',
        'member_id' => 'integer',
        'book_id' => 'integer',
        'loaned_at' => 'date',
        'due_at' => 'date',
        'returned_at' => 'date',
        'book_condition' => 'string',
    ];

    public function member(): BelongsTo
    {
        return $this->belongsTo(Member::class);
    }

    public function book(): BelongsTo
    {
        return $this->belongsTo(Book::class);
    }
}
