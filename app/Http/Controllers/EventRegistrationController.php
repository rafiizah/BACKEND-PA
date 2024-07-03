<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Models\Asosiasi;
use App\Models\UmkmAsosiasi;
use App\Models\UMKM;
use App\Models\User; // Pastikan untuk mengimpor model User jika belum diimpor

class EmailController extends Controller
{
    public function sendBlastEmail(Request $request)
    {
        // Validate the request input
        $this->validate($request, [
            'user_id' => 'required|exists:users,id', // validate user_id
            'subject' => 'required|string',
            'body' => 'required|string',
        ]);

        $user_id = $request->input('user_id');
        $subject = $request->input('subject');
        $body = $request->input('body');

        try {
            // Get the user
            $user = User::findOrFail($user_id);

            // Debugging: Check if user is found
            if (!$user) {
                return response()->json([
                    'message' => 'User not found',
                ], 404);
            }

            // Get the association ID associated with the user
            $asosiasi = Asosiasi::where('user_id', $user_id)->firstOrFail();

            // Debugging: Check if association is found
            if (!$asosiasi) {
                return response()->json([
                    'message' => 'Association not found for the user',
                ], 404);
            }

            // Get all UMKM that joined the specified association
            $umkmAsosiasi = UmkmAsosiasi::where('asosiasi_id', $asosiasi->id)->get();

            $sentEmails = [];

            // Send email to each UMKM
            foreach ($umkmAsosiasi as $ua) {
                // Get UMKM using umkm_id from UmkmAsosiasi
                $umkm = UMKM::find($ua->umkm_id); // Make sure to use umkm_id here

                if ($umkm && filter_var($umkm->email, FILTER_VALIDATE_EMAIL)) {
                    Mail::raw($body, function ($message) use ($umkm, $subject) {
                        $message->to($umkm->email)->subject($subject);
                    });

                    // Track successfully sent emails
                    $sentEmails[] = $umkm->email;
                }
            }

            // Return a JSON response indicating success and listing the sent emails
            return response()->json([
                'message' => 'Emails sent successfully!',
                'sent_emails' => $sentEmails,
            ]);
        } catch (\Exception $e) {
            // Handle any exceptions (e.g., association not found)
            return response()->json([
                'message' => 'Failed to send emails. ' . $e->getMessage(),
            ], 500);
        }
    }
}
