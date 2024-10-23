<?php

namespace App\Http\Controllers;

use Carbon\Carbon;

class SystemCalendarController extends Controller
{
    

    public function callender()
    {
        // $events = [];

        // $venues = Venue::all();

        // foreach ($this->sources as $source) {
        //     $calendarEvents = $source['model']::when(request('venue_id') && $source['model'] == '\App\Event', function($query) {
        //         return $query->where('venue_id', request('venue_id'));
        //     })->get();
        //     foreach ($calendarEvents as $model) {
        //         $crudFieldValue = $model->getOriginal($source['date_field']);

        //         if (!$crudFieldValue) {
        //             continue;
        //         }

        //         $events[] = [
        //             'title' => trim($source['prefix'] . " " . $model->{$source['field']}
        //                 . " " . $source['suffix']),
        //             'start' => $crudFieldValue,
        //             'url'   => route($source['route'], $model->id),
        //         ];
        //     }
        // }

        return view('calendar.calendar');
    }
}
