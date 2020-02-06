<?php

namespace Corals\Modules\CourtBooking\Http\Requests;

use Corals\Foundation\Http\Requests\BaseRequest;
use Corals\Modules\CourtBooking\Models\Booking;

class BookingRequest extends BaseRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $this->setModel(Booking::class);

        return $this->isAuthorized();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $this->setModel(Booking::class);
        $rules = parent::rules();

        if ($this->isUpdate() || $this->isStore()) {
            $rules = array_merge($rules, [
            ]);
        }

        if ($this->isStore()) {
            $rules = array_merge($rules, [
            ]);
        }

        if ($this->isUpdate()) {
            $booking = $this->route('Booking');

            $rules = array_merge($rules, [
            ]);
        }

        return $rules;
    }
}
