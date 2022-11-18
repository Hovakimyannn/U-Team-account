<?php

namespace App\Http\Controllers;

use App\Models\StudentInvitation;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class StudentInvitationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param Request $request
     *
//     * @return \Illuminate\Http\Response
     */
    public function create(Request $request) //: JsonResponse
    {
        $request->validate([
            'firstName'  => ['required','string','max:255'],
            'lastName'   => ['required','string','max:255'],
            'patronymic' => ['required','string','max:255'],
            'birthDate'  => ['required','date'],
            'email'      => ['required','email','unique:students,email'],
            'department_id' => ['required', 'exists:departments,id'],
            'course_id'  => ['required', 'exists:courses,id'],
            'group_id' => ['required', 'exists:groups,id'],
        ]);

        $invitation = new StudentInvitation();
        $invitation->firstName = $request->get('firstName');
        $invitation->lastName = $request->get('lastName');
        $invitation->patronymic = $request->get('patronymic');
        $invitation->birthDate = $request->get('birthDate');
        $invitation->email = $request->get('email');
        $invitation->token = 'sdfghjk';

        $invitation->department()->associate($request->get('department_id'));
        $invitation->course()->associate($request->get('course_id'));
        $invitation->group()->associate($request->get('group_id'));
        $invitation->save();
        return new JsonResponse($invitation, JsonResponse::HTTP_CREATED);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\StudentInvitation  $studentInvitation
     * @return \Illuminate\Http\Response
     */
    public function show(StudentInvitation $studentInvitation)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\StudentInvitation  $studentInvitation
     * @return \Illuminate\Http\Response
     */
    public function edit(StudentInvitation $studentInvitation)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\StudentInvitation  $studentInvitation
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, StudentInvitation $studentInvitation)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\StudentInvitation  $studentInvitation
     * @return \Illuminate\Http\Response
     */
    public function destroy(StudentInvitation $studentInvitation)
    {
        //
    }
}
