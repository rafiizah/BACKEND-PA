<?php

namespace App\Http\Controllers;

use App\Mail\UMKMEmail;
use App\Models\UMKM;
use App\Models\asosiasi;
use App\Models\umkmAsosiasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class UMKMController extends Controller
{
    public function create(Request $request)
    {
        try {
            $this->validate($request, [
                'subject' => 'required|string',
                'body' => 'required|string',
                'user_id' => 'required|exists:users,id',
            ]);

            $asosiasiRecords = asosiasi::where('user_id', $request->user_id)->first();
            $umkmAsosiasiRecords = umkmAsosiasi::where('asosiasi_id', $asosiasiRecords->id)->get();
            if (!$umkmAsosiasiRecords) {
                return response()->json([
                    'success' => false,
                    'message' => 'No affiliate found for the user_id',
                ], 404);
            }

            $recipientEmails = [];

            foreach ($umkmAsosiasiRecords as $umkmAsosiasiRecord) {
                $umkm = UMKM::findOrFail($umkmAsosiasiRecord->umkm_id);

                $email = $umkm->user->email;
                $recipientEmails[] = $email;

                Mail::to($email)->send(new UMKMEmail($request->subject, $request->body));
            }

            return response()->json([
                'success' => true,
                'message' => 'Email has been sent to the UMKM members',
                'recipient_emails' => $recipientEmails,
            ], 200);
        } catch (\Exception $e) {
            // Return error response
            return response()->json([
                'success' => false,
                'message' => 'Error when sending email',
                'errors' => $e->getMessage()
            ], 500);
        }
    }
}
