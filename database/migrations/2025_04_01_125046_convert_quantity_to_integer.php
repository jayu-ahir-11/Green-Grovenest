<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Migrations\Migration;

class ConvertQuantityToInteger extends Migration
{
    public function up()
    {
        // For products collection
        DB::connection('mongodb')
            ->getCollection('products')
            ->updateMany(
                ['quantity' => ['$type' => 'string']],
                [['$set' => ['quantity' => ['$toInt' => '$quantity']]]]
            );

        // For product_colors collection
        DB::connection('mongodb')
            ->getCollection('product_colors')
            ->updateMany(
                ['quantity' => ['$type' => 'string']],
                [['$set' => ['quantity' => ['$toInt' => '$quantity']]]]
            );
    }

    public function down()
    {
        // Optional: Revert back to strings if needed
        DB::connection('mongodb')
            ->getCollection('products')
            ->updateMany(
                ['quantity' => ['$type' => 'int']],
                [['$set' => ['quantity' => ['$toString' => '$quantity']]]]
            );

        DB::connection('mongodb')
            ->getCollection('product_colors')
            ->updateMany(
                ['quantity' => ['$type' => 'int']],
                [['$set' => ['quantity' => ['$toString' => '$quantity']]]]
            );
    }
}