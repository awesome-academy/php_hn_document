<?php

namespace App\Repositories\ReceiptRepository;

use App\Repositories\RepositoryInterface;

interface ReceiptRepositoryInterface extends RepositoryInterface
{
    /**
     * @param $year
     * @return mixed
     */
    public function getCoinsPerMonth($year);
}
