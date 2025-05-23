<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactSubmission extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'phone',
        'subject',
        'message',
        'ip_address',
        'user_agent',
        'is_read',
    ];
    
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'is_read' => 'boolean',
    ];
    
    /**
     * Get the full name of the person who submitted the contact form.
     *
     * @return string
     */
    public function getFullNameAttribute()
    {
        return "{$this->first_name} {$this->last_name}";
    }
    
    /**
     * Mark this submission as read.
     *
     * @return void
     */
    public function markAsRead()
    {
        $this->update(['is_read' => true]);
    }
    
    /**
     * Mark this submission as unread.
     *
     * @return void
     */
    public function markAsUnread()
    {
        $this->update(['is_read' => false]);
    }
} 