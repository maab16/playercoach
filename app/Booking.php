<?php

namespace Corals\Modules\CourtBooking\Models;

use Corals\Foundation\Models\BaseModel;
use Corals\Foundation\Transformers\PresentableTrait;
use Corals\User\Models\User;
use Spatie\Activitylog\Traits\LogsActivity;

class Booking extends BaseModel
{
    use PresentableTrait, LogsActivity;

    protected $table = 'courtbooking_bookings';

    /**
     *  Model configuration.
     * @var string
     */
    public $config = 'courtbooking.models.booking';

    protected static $logAttributes = [];

    protected $casts = ['resourceIds' => 'array'];

    protected $guarded = ['id'];

    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }

    public function groupUsers(){
        return $this->belongsToMany(User::class, 'courtbooking_booking_user');
    }

    public function groupUserNames(){
        $usernames ='';
        foreach ($this->groupUsers()->get() as $user) {
            if ($usernames != '') { $usernames.=', ';}
            $usernames.= $user->getFullNameAttribute();
        }
        $usernames .= '.';
        return $usernames;
    }

    public function belongstocurrentuser(){
        return $this->user()->first()->id == user()->id;
    }

    public function isCoaching() {
        return $this->user()->first()->hasRole('coach');
    }

    public function getOwner() {
        return $this->user()->first()->getFullNameAttribute();
    }

    public function getSpaces() {
        $spaces = $this->max_participants - (count($this->groupUsers)+1);
        return $spaces;
    }

    public function getTitle()
    {
        if (!is_null($this->title)) {
            return $this->title;
        }
        if ($this->isCoaching()) {
            return 'Coaching - ' . $this->getOwner() . '.';
        }

        $title = $this->getOwner();
        if (count($this->groupUsers)>0) {
            $title .= ' with ' . $this->groupUserNames().'<br>';
        }
        else {
            $title .= '.<br>';
        }

        if ($this->open == 0) {
            return $title;
        }
        else {
            $spaces = $this->getSpaces();
            if ($spaces <= 0){return $title;}
            $title .= '(Open - '.$spaces.' space'.($spaces>1? 's':'').' available)';
            return $title;
        }
    }

}
