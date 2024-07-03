<?php

namespace App\Http\Controllers;

use App\Models\asosiasi;
use App\Models\umkm;
use App\Models\umkmAsosiasi;
use Illuminate\Http\Request;

class UmkmAsosiasiController extends Controller
{
    public function index()
    {
        try {
            $umkmAsosiasi = umkmAsosiasi::all();

            foreach ($umkmAsosiasi as $ua) {
                $ua->umkm->nama_usaha;
            };
            return response()->json([
                'success' => true,
                'message' => 'Success when get Posts data',
                'data'    => $umkmAsosiasi
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error when get UMKM Asosiasi data',
                'errors' => $e->getMessage()
            ], 500);
        }
    }

    public function read($id)
    {
        try {
            $umkmAsosiasi = umkmAsosiasi::where('umkm_id', $id)->get();

            if (!$umkmAsosiasi) {
                return response()->json([
                    'success' => true,
                    'messages' => 'Success get UMKM Asosiasi data',
                    'data' => $umkmAsosiasi
                ], 200);
            }
            return response()->json($umkmAsosiasi);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error when get UMKM Asosiasi data',
                'errors' => $e->getMessage()
            ], 500);
        }
    }

    public function create(Request $request)
    {
        try {
            // Validate the request
            $this->validate($request, [
                'umkm_id' => 'required|exists:umkm,id',
                'asosiasi_id.*' => 'required|exists:asosiasi,id',
                'tanggal_bergabung' => 'required|date',
            ]);

            // Array to store created records
            $createdRecords = [];

            // Loop through each asosiasi_id and create a new umkmAsosiasi record
            foreach ($request->asosiasi_id as $asosiasi) {
                $createdRecord = umkmAsosiasi::create([
                    'umkm_id' => $request->umkm_id,
                    'asosiasi_id' => $asosiasi,
                    'tanggal_bergabung' => $request->tanggal_bergabung,
                    'di_terima' => true,
                ]);

                // Add the created record to the array
                $createdRecords[] = $createdRecord;
            }

            // Return response with created records
            return response()->json([
                'success' => true,
                'message' => 'UMKM Asosiasi data has been added',
                'data' => $createdRecords
            ], 200);
        } catch (\Exception $e) {
            // Return error response
            return response()->json([
                'success' => false,
                'message' => 'Error when adding UMKM Asosiasi data',
                'errors' => $e->getMessage()
            ], 500);
        }
    }


    public function update(Request $request, $id)
    {
        try {
            $this->validate($request, [
                'umkm_id' => 'required|exists:umkm,id',
                'asosiasi_id' => 'required|exists:asosiasi,id',
                'tanggal_bergabung' => 'required|date',
                'di_terima' => 'required|boolean',
            ]);

            $umkmAsosiasi = umkmAsosiasi::findOrFail($id);

            $input = $request->all();
            $umkmAsosiasi->fill($input);
            $umkmAsosiasi->save();

            return response()->json([
                'success' => true,
                'message' => 'UMKM Asosiasi data has been updated',
                'data' => $umkmAsosiasi
            ], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function delete($id)
    {
        try {
            $umkmAsosiasi = umkmAsosiasi::findOrFail($id);
            $umkmAsosiasi->delete();

            return response()->json([
                'success' => true,
                'message' => 'UMKM Asosiasi data has been deleted'
            ], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
