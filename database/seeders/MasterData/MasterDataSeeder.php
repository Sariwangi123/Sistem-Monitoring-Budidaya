<?php

namespace Database\Seeders\MasterData;

use Illuminate\Database\Seeder;
use MasterData\Models\Province;
use MasterData\Models\City;
use MasterData\Models\District;
use MasterData\Models\Village;
use MasterData\Models\Unit;
use MasterData\Models\Company;
use MasterData\Models\Farm;
use MasterData\Models\PondArea;
use MasterData\Models\Pond;
use MasterData\Models\FishSpecies;
use MasterData\Models\FishStrain;
use MasterData\Models\FeedBrand;
use MasterData\Models\FeedCategory;
use MasterData\Models\FeedType;
use MasterData\Models\Medicine;
use MasterData\Models\Probiotic;
use MasterData\Models\Vitamin;
use MasterData\Models\Supplier;
use MasterData\Models\Customer;
use MasterData\Models\Employee;
use MasterData\Models\GeneralReference;

final class MasterDataSeeder extends Seeder
{
    public function run(): void
    {
        // Wilayah Indonesia (Province, City, District, Village) - data statis dari referensi yang sudah ada
        // Unit
        Unit::factory()->count(10)->create();

        // Company
        Company::factory()->count(5)->create();

        // Farm
        Farm::factory()->count(10)->create();

        // Pond Area
        PondArea::factory()->count(20)->create();

        // Pond
        Pond::factory()->count(50)->create();

        // Fish Species
        FishSpecies::factory()->count(10)->create();

        // Fish Strain
        FishStrain::factory()->count(20)->create();

        // Feed Brand
        FeedBrand::factory()->count(10)->create();

        // Feed Category
        FeedCategory::factory()->count(5)->create();

        // Feed Type
        FeedType::factory()->count(20)->create();

        // Medicine
        Medicine::factory()->count(10)->create();

        // Probiotic
        Probiotic::factory()->count(10)->create();

        // Vitamin
        Vitamin::factory()->count(10)->create();

        // Supplier
        Supplier::factory()->count(10)->create();

        // Customer
        Customer::factory()->count(10)->create();

        // Employee
        Employee::factory()->count(10)->create();

        // General Reference
        GeneralReference::factory()->count(10)->create();
    }
}