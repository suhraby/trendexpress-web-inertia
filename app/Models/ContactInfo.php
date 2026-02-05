<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class ContactInfo extends Model
{
    use HasFactory, HasTranslations;

    protected $fillable = [
        'icon',
        'context',
        'value',
        'value_localization',
        'type',
        'is_active',
        'sort_order',
    ];

    public $translatable = ['value_localization'];

    public function linkVia()
    {
        if ($this->type === 'phone' || $this->type === 'fax') {
            return 'tel:';
        }

        if ($this->type === 'email') {
            return 'mailto:';
        }

        return '';
    }
}
