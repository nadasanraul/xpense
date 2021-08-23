<?php

namespace App\Api\Banks\Http\Handlers;

use App\Core\Classes\RequestParser;
use App\Api\Banks\Http\Resources\BankResource;
use App\Api\Banks\Repositories\BankRepository;
use App\Api\Core\Handlers\ListHandlerInterface;
use App\Api\Banks\Http\Resources\BankResourceCollection;

/**
 * Class BankListHandler
 * @package App\Api\Banks\Handlers
 */
class BankListHandler implements ListHandlerInterface
{
    /**
     * @var BankRepository
     */
    protected $repository;

    /**
     * BankListHandler constructor.
     *
     * @param BankRepository $repository
     */
    public function __construct(BankRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @inheritdoc
     */
    public function list()
    {
        $query = request()->query();
        $dto = RequestParser::parseQueryString($query, BankResource::class);

        $collection = $this->repository->collection($dto);

        return new BankResourceCollection($collection);
    }
}
