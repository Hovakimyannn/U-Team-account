<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Traits\Invitation;
use App\Models\Student;
use App\Models\StudentInvitation;
use App\Repositories\StudentInvitationRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class StudentInvitationController extends Controller
{
    use Invitation;

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
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function acceptInvitation(Request $request) : JsonResponse
    {
        $this->validate($request, [
            'password' => ['required', 'confirmed', 'min:5'],
        ]);

        $token = $request->get('token');

        /** @var StudentInvitation $invitation */
        $invitation = $this->studentInvitationRepository->findOneBy([['token', $token]], false);

        if (!$invitation) {
            return new JsonResponse([
                'message' => 'You dont have invitation'
            ], JsonResponse::HTTP_NOT_FOUND);
        }

        $invitation->password = $request->get('password');

        $student = StudentController::create($invitation);

        $invitation->delete();

        return new JsonResponse([
            $student
        ], JsonResponse::HTTP_OK);
    }

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getStudentByInvitation(Request $request) : JsonResponse
    {
        $token = $request->query('token');

        /** @var StudentInvitation $invitation */
        $invitation = $this->studentInvitationRepository->findOneBy([['token', $token]], false);

        if (!$invitation) {
            return new JsonResponse([
                'message' => 'You dont have invitation'
            ], JsonResponse::HTTP_NOT_FOUND);
        }

        $data = json_decode(decrypt($token));

        if ($this->checkInvitationIsExpire($data->expires)) {
            return new JsonResponse([
                'message' => 'Your invitation is expires'
            ], JsonResponse::HTTP_NOT_FOUND);
        }

        return new JsonResponse([
            $invitation
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
        $invitation = $this->studentInvitationRepository->find($id, false);

        if (!$invitation) {
            return new JsonResponse([
                'message' => 'Something went wrong'
            ], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }

        $data = json_decode(decrypt($invitation->token));

        if (!$this->checkInvitationIsExpire($data->expires)) {
            $this->sendMail($data->email, $this->createUrl($invitation->token));

            return new JsonResponse([
                'message' => 'Invitation sent'
            ], JsonResponse::HTTP_OK);
        }

        $token = $this->createToken($invitation->email);
        $this->sendMail(
            $invitation->email,
            $this->createUrl($token)
        );

        $invitation->token = $token;
        $invitation->save();

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
}
