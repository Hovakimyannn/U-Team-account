<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\StudentInvitation;
use App\Notifications\Invite;
use App\Repositories\StudentInvitationRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\URL;

class StudentInvitationController extends Controller
{
    /**
     * @var \App\Repositories\StudentInvitationRepository
     */
    protected StudentInvitationRepository $studentInvitationRepository;

    /**
     * @param \App\Repositories\StudentInvitationRepository $studentInvitationRepository
     */
    public function __construct(StudentInvitationRepository $studentInvitationRepository)
    {
        $this->studentInvitationRepository = $studentInvitationRepository;
    }

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function sendInvitation(Request $request) : JsonResponse
    {
        $this->validate($request, [
            'firstName'    => ['required', 'string'],
            'lastName'     => ['required', 'string'],
            'patronymic'   => ['required', 'string'],
            'birthDate'    => ['required', 'date'],
            'email'        => ['required', 'email', 'unique:students,email', 'unique:student_invitations,email'],
            'instituteId'  => ['required', 'int', 'exists:institutes,id'],
            'departmentId' => ['required', 'int', 'exists:departments,id'],
            'courseId'     => ['required', 'int', 'exists:courses,id'],
            'groupId'      => ['required', 'int', 'exists:groups,id'],
        ]);

        $token = $this->createToken($request->get('email'));

        $invitation = new StudentInvitation();
        $invitation->firstName = $request->get('firstName');
        $invitation->lastName = $request->get('lastName');
        $invitation->patronymic = $request->get('patronymic');
        $invitation->birthDate = $request->get('birthDate');
        $invitation->email = $request->get('email');
        $invitation->instituteId = $request->get('instituteId');
        $invitation->departmentId = $request->get('departmentId');
        $invitation->courseId = $request->get('courseId');
        $invitation->groupId = $request->get('groupId');
        $invitation->token = $token;
        $invitation->save();

        $this->sendMail($invitation->email, $this->createUrl($token));

        return new JsonResponse([
            'message' => 'Invitation sent'
        ], JsonResponse::HTTP_OK);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param string                   $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function acceptInvitation(Request $request, string $token) : JsonResponse
    {
        $data = json_decode(decrypt($token));

        if ($this->checkInvitationIsExpire($data->expires)) {
            return new JsonResponse([
                'message' => 'Your invitation is expires'
            ], JsonResponse::HTTP_NOT_FOUND);
        }

        /** @var StudentInvitation $invitation */
        $invitation = $this->studentInvitationRepository->findUserByEmail($data->email);

        if (!$invitation) {
            return new JsonResponse([
                'message' => 'You dont have invitation'
            ], JsonResponse::HTTP_NOT_FOUND);
        }

        $student = new Student();
        $student->firstName = $invitation->firstName;
        $student->lastName = $invitation->lastName;
        $student->patronymic = $invitation->patronymic;
        $student->birthDate = $invitation->birthDate;
        $student->email = $invitation->email;
        $student->password = Hash::make($request->get('password'));//sxal
        $student->department()->associate($invitation->departmentId);
        $student->course()->associate($invitation->courseId);
        $student->save();
        $student->groups()->sync($invitation->groupId);

        $invitation->delete();

        return new JsonResponse([
            'message' => 'Student registered'
        ], JsonResponse::HTTP_OK);
    }

    /**
     * @param $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function resendInvitation($id) : JsonResponse
    {
        /** @var StudentInvitation $invitation */
        $invitation = $this->studentInvitationRepository->find($id);
        $token = $this->createToken($invitation->email);

        if (!$invitation) {
            return new JsonResponse([
                'message' => 'Something went wrong'
            ], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }

        $data = json_decode(decrypt($invitation->token));

        if (!$this->checkInvitationIsExpire($data->expires)) {
            $this->sendMail($data->email, $this->createUrl($token));

            return new JsonResponse([
                'message' => 'Invitation sent'
            ], JsonResponse::HTTP_OK);
        }


        $invitation->token = $token;
        $invitation->save();

        $this->sendMail(
            $invitation->email,
            $this->createUrl($token)
        );

        return new JsonResponse([
            'message' => 'Invitation sent'
        ], JsonResponse::HTTP_OK);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function get() : JsonResponse
    {
        return new JsonResponse($this->studentInvitationRepository->findAll(), JsonResponse::HTTP_OK);
    }

    protected function sendMail($email, $url)
    {
        Notification::route('mail', $email)
            ->notify(new Invite($url));
    }

    /**
     * If expire return true
     *
     * @param int $unixTime
     *
     * @return bool
     */
    protected function checkInvitationIsExpire(int $unixTime) : bool
    {
        return Carbon::now()->timestamp > $unixTime;
    }

    /**
     * @param $token
     *
     * @return string
     */
    protected function createUrl($token) : string
    {
        return URL::temporarySignedRoute(
            'invitation.accept',
            0,
            ['token' => $token]
        );
    }

    /**
     * @param string $email
     *
     * @return string
     */
    protected function createToken(string $email) : string
    {
        return encrypt(json_encode([
            'expires' => Carbon::now()->addMinutes(Config::get('auth.verification.expire', 60))->timestamp,
            'email'   => $email
        ]));
    }
}
