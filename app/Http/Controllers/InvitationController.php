<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Traits\Invite;
use App\Models\Group;
use App\Models\Invitation;
use App\Repositories\InvitationRepository;
use App\Rules\BirthDateRule;
use App\Rules\EmptyInstituteRule;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class InvitationController extends Controller
{
    use Invite;

    /**
     * @var \App\Repositories\InvitationRepository
     */
    protected InvitationRepository $studentInvitationRepository;

    /**
     * @param \App\Repositories\InvitationRepository $studentInvitationRepository
     */
    public function __construct(InvitationRepository $studentInvitationRepository)
    {
        $this->studentInvitationRepository = $studentInvitationRepository;
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param string                   $role
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function sendInvitation(Request $request, string $role) : JsonResponse
    {
        $this->validate($request, $this->validateInvitation($request, $role));

        $token = $this->createToken($request->get('email'));
        $this->sendUserInvitation($request->get('email'), $request->get('name'), $this->createUrl($token));

        $invitation = new Invitation();
        $invitation->email = $request->get('email');
        $invitation->token = $token;
        $invitation->role = $role;
        $invitation->payload = $this->preparePayload($request->all());
        $invitation->save();


        return new JsonResponse([
            'message' => 'Invite sent'
        ], JsonResponse::HTTP_OK);
    }

    /**
     * @param $request
     * @param $role
     *
     * @return array|\Exception
     */
    protected function validateInvitation($request, $role) : \Exception|array
    {
        return match ($role) {
            'admin' => $this->adminValidation($request),
            'student' => $this->studentValidation($request),
            'teacher' => $this->teacherValidation($request),
            default => new \Exception()
        };
    }

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return array
     */
    protected function studentValidation(Request $request) : array
    {
        return [
            'firstName'    => ['required', 'string'],
            'lastName'     => ['required', 'string'],
            'patronymic'   => ['required', 'string'],
            'birthDate'    => ['required', 'date', new BirthDateRule],
            'email'        => ['required', 'email', 'unique:students,email', 'unique:invitations,email'],
            'instituteId'  => ['required', 'int', 'exists:institutes,id'],
            'departmentId' => ['required', 'int', 'exists:departments,id'],
            'courseId'     => ['required', 'int', 'exists:courses,id'],
            'groupId'      => ['int', Rule::requiredIf(fn() => Group::where('course_id', $request->get('courseId'))->get()->isNotEmpty())],
            'subgroupId'   => ['int', Rule::requiredIf(fn() => $request->get('groupId') && Group::where('parent_id', $request->get('groupId'))->get()->isNotEmpty())]
        ];
    }

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return array
     */
    protected function teacherValidation(Request $request) : array
    {
        return [
            'firstName'    => ['required', 'string'],
            'lastName'     => ['required', 'string'],
            'patronymic'   => ['required', 'string'],
            'position'     => ['required', 'in:assistant,lecturer,associate_professor,professors'],
            'birthDate'    => ['required', 'date', new BirthDateRule],
            'email'        => ['required', 'email', 'unique:students,email', 'unique:invitations,email'],
            'instituteId'  => ['required', 'int', 'exists:institutes,id'],
            'departmentId' => ['required', 'int', 'exists:departments,id'],
            'courseId'     => ['array', 'exists:courses,id'],
            'groupId'      => ['array', 'exists:groups,id'],
        ];
    }

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return array
     */
    protected function adminValidation(Request $request) : array
    {
        return [
            'firstName'  => ['required', 'string', 'max:255'],
            'lastName'   => ['required', 'string', 'max:255'],
            'patronymic' => ['required', 'string', 'max:255'],
            'email'      => ['required', 'email', 'unique:admins,email', 'unique:invitations,email'],
        ];
    }

    /**
     * @param array $data
     *
     * @return bool|string
     */
    private function preparePayload(array $data) : bool|string
    {
        return json_encode($data);
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

        /** @var Invitation $invitation */
        $invitation = $this->studentInvitationRepository->findOneBy([['token', $token]], false);

        if (!$invitation) {
            return new JsonResponse([
                'message' => 'You don\'t have an invitation'
            ], JsonResponse::HTTP_NOT_FOUND);
        }

        $data = json_decode($invitation->payload);
        $data->password = $request->get('password');

        /** @var Controller $controller */
        $controller = $this->findOutController($invitation->role);
        $user = $controller::create($data);

        $invitation->delete();

        return new JsonResponse($user, JsonResponse::HTTP_OK);
    }

    /**
     * @param string $role
     *
     * @return string
     */
    protected function findOutController(string $role) : string
    {
        return match ($role) {
            'admin' => AdminController::class,
            'student' => StudentController::class,
            'teacher' => TeacherController::class,
            default => new \Exception()
        };
    }

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getUserByInvitation(Request $request) : JsonResponse
    {
        $token = $request->query('token');

        /** @var Invitation $invitation */
        $invitation = $this->studentInvitationRepository->findOneBy([['token', $token]], false);

        if (!$invitation) {
            return new JsonResponse([
                'message' => 'You don\'t have an invitation'
            ], JsonResponse::HTTP_NOT_FOUND);
        }

        $data = json_decode(decrypt($token));

        if ($this->checkInvitationIsExpire($data->expires)) {
            return new JsonResponse([
                'message' => 'Your invitation has expired'
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
        /** @var Invitation $invitation */
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
                'message' => 'Invite sent'
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
            'message' => 'Invite sent'
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
