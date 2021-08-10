<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use Illuminate\Http\Request;

class MahasiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response([
            'status' => 'success',
            'message' => 'success get all data',
            'data' => Mahasiswa::get([
                'id', 'nim', 'nama'
            ])
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'nim' => 'unique:mahasiswas,nim|required|min:8',
            'nama' => 'required',
            'jenkel' => 'required',
            'alamat' => 'required',
            'no_hp' => 'numeric|min:11|required',
            'jurusan' => 'required',
            'angkatan' => 'required'
        ]);

        // $mahasiswa = Mahasiswa::create($request->all());
        return response([
            'status' => 'success',
            'message' => 'success create data',
            'data' => Mahasiswa::create($request->all())
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = Mahasiswa::where('id', $id)->first();
        if (!$data) {
            return response([
                'status' => 'error',
                'message' => 'mahasiswa tidak ada'
            ], 404);
        }
        return response([
            'status' => 'success',
            'message' => 'success get data by id',
            'data' => $data
        ], 200);
    }

    public function update(Request $request, $id)
    {
        $data = Mahasiswa::where('id', $id)->first();
        if (!$data) {
            return response([
                'status' => 'error',
                'message' => 'mahasiswa tidak ada'
            ], 404);
        }
        $request->validate([
            'nim' => 'required|min:8|unique:mahasiswas,nim,' . $data->id,
            'nama' => 'required',
            'jenkel' => 'required',
            'alamat' => 'required',
            'no_hp' => 'numeric|min:11|required',
            'jurusan' => 'required',
            'angkatan' => 'required'
        ]);
        $data->update($request->all());
        return response([
            'status' => 'success',
            'message' => 'success updated',
            'data' => $data
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = Mahasiswa::where('id', $id)->first();
        if (!$data) {
            return response([
                'status' => 'error',
                'message' => 'mahasiswa tidak ada'
            ], 404);
        }
        return response([
            'status' => 'success',
            'message' => 'success deleted ' . $data->nama,
            'data' => $data->delete()
        ], 200);
    }
}
