<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Specialist;
use App\Models\Institution;

class AdminController extends Controller
{
    /**
     * Admin Login with Sanctum Token
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $admin = User::where('email', $request->email)->whereHas('role', function ($query) {
            $query->where('title', 'admin');
        })->first();

        if (!$admin || !Hash::check($request->password, $admin->password)) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }

        $token = $admin->createToken('admin-token')->plainTextToken;

        return response()->json(['token' => $token]);
    }

    /**
     * Get Pending Specialists for Approval
     */
    public function getPendingSpecialists()
    {
        $specialists = Specialist::whereNull('certified')->get();
        return response()->json($specialists);
    }

    /**
     * Approve or Reject a Specialist
     */
    public function updateSpecialistStatus(Request $request, $id)
    {
        $request->validate([
            'certified' => 'required|boolean'
        ]);

        $specialist = Specialist::findOrFail($id);
        $specialist->certified = $request->certified;
        $specialist->save();

        return response()->json(['message' => "Specialist has been " . ($request->certified ? "approved" : "rejected")]);
    }

    /**
     * Get All Specialists
     */
    public function getSpecialists()
    {
        $Specialists = Specialist::all();
        return response()->json($Specialists);
    }

    /**
     * Add a New Specialist
     */
    public function addSpecialist(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'specialization' => 'required',
            'institution_id' => 'required|exists:institutions,id'
        ]);

        $Specialist = Specialist::create([
            'name' => $request->name,
            'email' => $request->email,
            'specialization' => $request->specialization,
            'institution_id' => $request->institution_id
        ]);

        return response()->json(['message' => 'Specialist added successfully', 'Specialist' => $Specialist]);
    }

    /**
     * Update Specialist Information
     */
    public function updateSpecialist(Request $request, $id)
    {
        $Specialist = Specialist::findOrFail($id);
        $Specialist->update($request->only(['name', 'specialization']));

        return response()->json(['message' => 'Specialist information updated']);
    }

    /**
     * Remove a Specialist
     */
    public function deleteSpecialist($id)
    {
        Specialist::findOrFail($id)->delete();
        return response()->json(['message' => 'Specialist removed successfully']);
    }

    /**
     * Get All Institutions
     */
    public function getInstitutions()
    {
        $institutions = Institution::all();
        return response()->json($institutions);
    }

    /**
     * Add a New Institution
     */
    public function addInstitution(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'type' => 'required|integer',
            'address' => 'required'
        ]);

        $institution = Institution::create($request->all());

        return response()->json(['message' => 'Institution added successfully', 'institution' => $institution]);
    }

    /**
     * Update Institution Information
     */
    public function updateInstitution(Request $request, $id)
    {
        $institution = Institution::findOrFail($id);
        $institution->update($request->only(['name', 'type', 'address']));

        return response()->json(['message' => 'Institution details updated']);
    }

    /**
     * Remove an Institution
     */
    public function deleteInstitution($id)
    {
        Institution::findOrFail($id)->delete();
        return response()->json(['message' => 'Institution removed successfully']);
    }
}
