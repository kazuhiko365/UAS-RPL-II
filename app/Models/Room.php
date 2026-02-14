<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $host_id
 * @property int $sport_id
 * @property int $venue_id
 * @property string $title
 * @property string|null $description
 * @property \DateTime $start_datetime
 * @property \DateTime|null $end_datetime
 * @property int $max_participants
 * @property float $cost_per_person
 * @property bool $is_active
 * @property array|null $booking_confirmation
 */
class Room extends Model {
    use HasFactory;

    protected $fillable = [
        'host_id',
        'sport_id',
        'venue_id',
        'title',
        'description',
        'description',
        'start_datetime',
        'end_datetime',
        'max_participants',
        'cost_per_person',
        'is_active',
        'booking_confirmation',
        'code',
    ];

    protected $casts = [
        'start_datetime' => 'datetime',
        'end_datetime' => 'datetime',
        'booking_confirmation' => 'array',
        'is_active' => 'boolean',
    ];

    public function venue() { return $this->belongsTo(Venue::class); }
    public function sport() { return $this->belongsTo(Sport::class); }
    public function host() { return $this->belongsTo(User::class, 'host_id'); }
    public function participants() { return $this->hasMany(RoomParticipant::class); }

    // Haversine Scope
    public function scopeNearby($query, $lat, $lng) {
        return $query->join('venues', 'rooms.venue_id', '=', 'venues.id')
            ->select('rooms.*', 'venues.name as venue_name', 'venues.latitude', 'venues.longitude')
            ->selectRaw("
                (6371 * acos(
                    cos(radians(?)) * cos(radians(venues.latitude)) * cos(radians(venues.longitude) - radians(?)) +
                    sin(radians(?)) * sin(radians(venues.latitude))
                )) AS distance_km
            ", [$lat, $lng, $lat])
            ->orderBy('distance_km', 'ASC');
    }
}