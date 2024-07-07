<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\AsCollection;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Guest extends Model
{
    use HasFactory;
    use SoftDeletes;
    use HasUuids;

    protected $fillable = [
        'name',
        'email',
        'gender',
        'phone',
        'document_type',
        'document',
        'attachments',
        'children',
        'emergency_contacts',
        'internal_note',
        'source',
        'partner_code',
    ];

    protected $hidden = [
        'internal_note',
    ];

    public function casts(): array
    {
        return [
            // 'document_type' => 'integer', //TODO: make a enum
            'attachments' => AsCollection::class,
            'children' => AsCollection::class,
            'emergency_contacts' => AsCollection::class,
        ];
    }

    public function uniqueIds()
    {
        return [
            'uuid',
        ];
    }
}
