<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventInquiry extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'phone',
        'company',
        'event_type',
        'guest_count',
        'event_date',
        'event_time',
        'details',
        'ip_address',
        'user_agent',
        'is_read',
    ];
    
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'event_date' => 'date',
        'guest_count' => 'integer',
        'is_read' => 'boolean',
    ];
    
    /**
     * Get the full name of the person who submitted the inquiry.
     *
     * @return string
     */
    public function getFullNameAttribute()
    {
        return "{$this->first_name} {$this->last_name}";
    }
    
    /**
     * Mark this inquiry as read.
     *
     * @return void
     */
    public function markAsRead()
    {
        $this->update(['is_read' => true]);
    }
    
    /**
     * Mark this inquiry as unread.
     *
     * @return void
     */
    public function markAsUnread()
    {
        $this->update(['is_read' => false]);
    }
} 