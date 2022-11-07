<?php

namespace App\Http\Controllers\Event;

use App\Http\Controllers\Controller;
use App\Http\Requests\EventRequest;
use App\Models\Event;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EventController extends Controller
{
    /**
     *  Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('events.create');
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(EventRequest $request)
    {
        try {
            $event = new Event([
                'title' => $request->get('title'),
                'description' => $request->get('description'),
                'start_date' => $request->get('start_date'),
                'end_date' => $request->get('end_date'),
                'created_by' => Auth::id(),
            ]);

            $event->save();

            return redirect()->route('home')->with('status', 'Event saved successfully');
        } catch (Exception $e) {
            return back()->withInput()->with('status', $e->getMessage());
        }
    }


    /**
     * Show the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Event $event)
    {
        return response()->json($event);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Event $event)
    {
        return view('events.edit', compact('event'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(EventRequest $request, $id)
    {
        try {
            $event = Event::find($id);
            $event->title = $request->get('title');
            $event->description = $request->get('description');
            $event->start_date = $request->get('start_date');
            $event->end_date = $request->get('end_date');
            $event->save();

            return redirect()->route('home')->with('status', 'Event updated successfully');
        } catch (Exception $e) {
            return back()->with('status', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Event $event)
    {
        try {
            if (request()->ajax()) {
                $event->delete();
                return response()->json('Successfully Deleted');
            }
        } catch (Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ]);
        }
    }
}
