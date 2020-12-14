<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\PositionCreateRequest;
use App\Http\Requests\PositionUpdateRequest;
use App\Repositories\PositionRepository;
use App\Validators\PositionValidator;

/**
 * Class PositionsController.
 *
 * @package namespace App\Http\Controllers;
 */
class PositionsController extends Controller
{
    /**
     * @var PositionRepository
     */
    protected $repository;

    /**
     * @var PositionValidator
     */
    protected $validator;

    /**
     * PositionsController constructor.
     *
     * @param PositionRepository $repository
     * @param PositionValidator $validator
     */
    public function __construct(PositionRepository $repository, PositionValidator $validator)
    {
        $this->repository = $repository;
        $this->validator  = $validator;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->repository->pushCriteria(app('Prettus\Repository\Criteria\RequestCriteria'));
        $positions = $this->repository->all();

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $positions,
            ]);
        }

        return view('positions.index', compact('positions'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  PositionCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function store(PositionCreateRequest $request)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_CREATE);

            $position = $this->repository->create($request->all());

            $response = [
                'message' => 'Position created.',
                'data'    => $position->toArray(),
            ];

            if ($request->wantsJson()) {

                return response()->json($response);
            }

            return redirect()->back()->with('message', $response['message']);
        } catch (ValidatorException $e) {
            if ($request->wantsJson()) {
                return response()->json([
                    'error'   => true,
                    'message' => $e->getMessageBag()
                ]);
            }

            return redirect()->back()->withErrors($e->getMessageBag())->withInput();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $position = $this->repository->find($id);

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $position,
            ]);
        }

        return view('positions.show', compact('position'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $position = $this->repository->find($id);

        return view('positions.edit', compact('position'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  PositionUpdateRequest $request
     * @param  string            $id
     *
     * @return Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function update(PositionUpdateRequest $request, $id)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_UPDATE);

            $position = $this->repository->update($request->all(), $id);

            $response = [
                'message' => 'Position updated.',
                'data'    => $position->toArray(),
            ];

            if ($request->wantsJson()) {

                return response()->json($response);
            }

            return redirect()->back()->with('message', $response['message']);
        } catch (ValidatorException $e) {

            if ($request->wantsJson()) {

                return response()->json([
                    'error'   => true,
                    'message' => $e->getMessageBag()
                ]);
            }

            return redirect()->back()->withErrors($e->getMessageBag())->withInput();
        }
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $deleted = $this->repository->delete($id);

        if (request()->wantsJson()) {

            return response()->json([
                'message' => 'Position deleted.',
                'deleted' => $deleted,
            ]);
        }

        return redirect()->back()->with('message', 'Position deleted.');
    }
}
