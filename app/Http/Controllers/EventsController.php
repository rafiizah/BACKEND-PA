<?php

namespace App\Http\Controllers;

use App\Models\umkm;
use App\Models\user;
use App\Models\event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class EventsController extends Controller
{
    public function index()
    {
        $event = event::all();
        return response()->json([
            'success' => true,
            'message' => 'Detail Get Event',
            'event' => $event
        ], 200);
    }

    public function show($id)
    {
        $event = event::find($id);
        if (!$event) {
            return response()->json(['message' => 'Event not found'], 404);
        }
        return response()->json($event, 200);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'nama_event' => 'required',
            'date' => 'required',
            'time' => 'required',
            'location' => 'required',
            'description' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $image = (object) ['image' => ""];

        if ($request->hasFile('image')) {
            $original_filename = $request->file('image')->getClientOriginalName();
            $original_filename_arr = explode('.', $original_filename);
            $file_ext = end($original_filename_arr);
            $destination_path = './upload/user/';
            $image = 'U-' . time() . '.' . $file_ext;

            if ($request->file('image')->move($destination_path, $image)) {
                $request->image = '/upload/user/' . $image;
            }
        }

        $event = new event();
        $event->nama_event = $request->nama_event;
        $event->date = $request->date;
        $event->time = $request->time;
        $event->location = $request->location;
        $event->description = $request->description;
        $event->image = $request->image;
        $event->save();

        if ($event) {
            return response()->json([
                'success' => true,
                'message' => 'Event created successfully',
                'event' => $event
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Event created failed',
                'event' => 'no data'
            ], 400);
        }
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'nama_event' => 'required',
            'date' => 'required',
            'time' => 'required',
            'location' => 'required',
            'description' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $inputs = $request->all();
        $event = event::findOrFail($id);
        $event->update($inputs);

        if ($request->hasFile('image')) {
            $original_filename = $request->file('image')->getClientOriginalName();
            $original_filename_arr = explode('.', $original_filename);
            $file_ext = end($original_filename_arr);
            $destination_path = './upload/user/';
            $image = 'U-' . time() . '.' . $file_ext;

            if ($request->file('image')->move($destination_path, $image)) {
                $event->image = '/upload/user/' . $image;
            }
        }
        return response()->json([
            'success' => true,
            'message' => 'Event updated successfully',
            'eevnt' => $event
        ], 200);
    }

    public function destroy($id)
    {
        $event = event::findOrFail($id);
        $event->delete();

        if ($event) {
            return response()->json([
                'success' => true,
                'message' => 'Event Berhasil Dihapus!',
            ], 200);
        }
    }

    public function hitungJumlahEvent()
    {
        // Menggunakan query builder untuk menghitung jumlah UMKM
        $jumlahevent = DB::table('event')->count();

        // Mengembalikan response dalam bentuk JSON
        return response()->json(['jumlah_event' => $jumlahevent]);
    }
}