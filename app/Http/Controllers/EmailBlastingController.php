<?php

namespace App\Http\Controllers;

use App\Jobs\SendEmailJob;
use App\Models\Umkm;
use App\Models\UmkmAsosiasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EmailBlastingController extends Controller
{
    public function sendEmails(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'subject' => 'required|string',
            'body' => 'required|string',
            'asosiasi_id' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $umkmAsosiasi = UmkmAsosiasi::where('asosiasi_id', $request->asosiasi_id)->get();
        $recipients = [];

        foreach ($umkmAsosiasi as $entry) {
            $umkm = Umkm::find($entry->umkm_id);

            if ($umkm && $umkm->email) {
                dispatch(new SendEmailJob($umkm->email, $request->subject, $request->body));
                $recipients[] = $umkm->email;
            }
        }

        return response()->json([
            'message' => 'Emails sent successfully',
            'recipients' => $recipients
        ]);
    }
}
