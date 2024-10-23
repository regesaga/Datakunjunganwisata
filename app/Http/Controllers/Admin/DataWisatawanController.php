<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Wisatawan;
use Hashids\Hashids;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class DataWisatawanController extends Controller
{
    public function index()
    {
        $hash = new Hashids();
        $wisatawan = Wisatawan::all();
        return view('admin.wisatawan.index', compact('wisatawan', 'hash'));
    }

    public function edit($wisatawanId)
    {
        $hash = new Hashids();
        $data = Wisatawan::find($hash->decodeHex($wisatawanId));
        return view('admin.wisatawan.edit', compact(
            'data',
            'hash',
        ));
    }

    public function update(Request $request, $wisatawanId)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required',
            'password' => 'same:confirm-password',
        ]);
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required',
            'password' => 'same:confirm-password',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $input = $request->all();

        $hash = new Hashids();
        $wisatawan = Wisatawan::find($hash->decodeHex($wisatawanId));

        if (!empty($input['password'])) {
            $input['password'] = Hash::make($input['password']);
            $wisatawan->update([
                'name' => $input['name'],
                'email' => $input['email'],
                'phone' => $input['phone'],
                'password' => $input['password'],
                'updated_at' => now(),
            ]);
            return redirect()->route('admin.wisatawans.index')->with('success', 'User updated successfully');
        } else {
            $wisatawan->update([
                'name' => $input['name'],
                'email' => $input['email'],
                'phone' => $input['phone'],
                'updated_at' => now(),
            ]);
            return redirect()->route('admin.wisatawans.index')->with('success', 'User updated successfully');
        }
    }

    public function show($wisatawanId)
    {
        $hash = new Hashids();
        $wisatawanId = $hash->decodeHex($wisatawanId);
        $data = Wisatawan::find($wisatawanId);
        return view('admin.wisatawan.show', compact('data','hash'));
    }


    public function destroy($wisatawanId)
    {
        $hash = new Hashids();
        $wisatawan = Wisatawan::find($hash->decodeHex($wisatawanId));
        $wisatawan->delete();
        return back();
    }

}
