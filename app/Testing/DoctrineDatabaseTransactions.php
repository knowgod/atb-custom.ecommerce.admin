<?php

namespace App\Testing;

trait DoctrineDatabaseTransactions
{
    public function beginDatabaseTransaction()
    {
        $this->app['em']->beginTransaction();

        $this->beforeApplicationDestroyed(function () {
            $this->app['em']->rollBack();
        });
    }
}
