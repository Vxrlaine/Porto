<?php

namespace App\Repositories;

interface BaseRepositoryInterface
{
    /**
     * Get all records.
     */
    public function all(array $columns = ['*']);

    /**
     * Get paginated records.
     */
    public function paginate(int $perPage = 15, array $columns = ['*']);

    /**
     * Find a record by ID.
     */
    public function find(int $id);

    /**
     * Find a record by ID or fail.
     */
    public function findOrFail(int $id);

    /**
     * Create a new record.
     */
    public function create(array $data);

    /**
     * Update a record by ID.
     */
    public function update(int $id, array $data);

    /**
     * Delete a record by ID.
     */
    public function delete(int $id): bool;

    /**
     * Find records by criteria.
     */
    public function where(array $criteria);

    /**
     * Get first record matching criteria.
     */
    public function firstWhere(array $criteria);
}
