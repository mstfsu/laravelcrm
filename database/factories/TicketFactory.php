<?php

namespace Database\Factories;

use App\Models\Ticket;
use Illuminate\Database\Eloquent\Factories\Factory;

class TicketFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Ticket::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            "subject_id"=>3,
            "type_id"=>28,
            "priority_id"=>1,
            "status_id"=>2,
            "group_id"=>1,
            "message"=>"1asdasd",
            "assigned_to"=>1,
            "customer_id"=>55,
            "cc_recipients"=>"asd",
            "is_closed"=>0,
            "created_at"=>now(),
            "updated_at"=>now(),

        ];
    }
}
