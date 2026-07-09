<?php

namespace Tests\Feature\MasterData;

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
use Modules\Users\Models\User;
use Tests\TestCase;

final class MasterDataApiTest extends TestCase
{
    private User $adminUser;

    private const API_PREFIX = '/api/v1';

    protected function setUp(): void
    {
        parent::setUp();

        /** @var User $adminUser */
        $adminUser = User::factory()->create();
        $adminUser->assignRole('super-admin');
        $this->adminUser = $adminUser;
    }

    // ======================= REGION: Province =======================

    public function test_province_can_be_listed(): void
    {
        Province::factory()->count(3)->create();

        $response = $this->actingAs($this->adminUser)
            ->getJson(self::API_PREFIX . '/master/provinces');

        $response->assertOk()
            ->assertJsonStructure([
                'status',
                'message',
                'data' => [
                    'data',
                    'meta' => ['current_page', 'last_page', 'per_page', 'total'],
                ],
            ]);
    }

    public function test_province_can_be_created(): void
    {
        $payload = Province::factory()->make()->toArray();

        $response = $this->actingAs($this->adminUser)
            ->postJson(self::API_PREFIX . '/master/provinces', $payload);

        $response->assertCreated()
            ->assertJsonPath('status', 201)
            ->assertJsonStructure([
                'status',
                'message',
                'data' => ['id', 'code', 'name'],
            ]);

        $this->assertDatabaseHas('provinces', ['name' => $payload['name']]);
    }

    public function test_province_can_be_shown(): void
    {
        $province = Province::factory()->create();

        $response = $this->actingAs($this->adminUser)
            ->getJson(self::API_PREFIX . "/master/provinces/{$province->id}");

        $response->assertOk()
            ->assertJsonPath('data.id', $province->id)
            ->assertJsonPath('data.code', $province->code);
    }

    public function test_province_can_be_updated(): void
    {
        $province = Province::factory()->create();
        $payload = ['name' => 'Updated Province Name'];

        $response = $this->actingAs($this->adminUser)
            ->putJson(self::API_PREFIX . "/master/provinces/{$province->id}", $payload);

        $response->assertOk()
            ->assertJsonPath('data.name', 'Updated Province Name');

        $this->assertDatabaseHas('provinces', [
            'id' => $province->id,
            'name' => 'Updated Province Name',
        ]);
    }

    public function test_province_can_be_deleted(): void
    {
        $province = Province::factory()->create();

        $response = $this->actingAs($this->adminUser)
            ->deleteJson(self::API_PREFIX . "/master/provinces/{$province->id}");

        $response->assertOk()
            ->assertJsonPath('message', 'Data deleted successfully');

        $this->assertSoftDeleted($province);
    }

    // ======================= REGION: City =======================

    public function test_city_can_be_created_with_province_relation(): void
    {
        $province = Province::factory()->create();
        $payload = City::factory()->withProvince($province)->make()->toArray();

        $response = $this->actingAs($this->adminUser)
            ->postJson(self::API_PREFIX . '/master/cities', $payload);

        $response->assertCreated()
            ->assertJsonPath('data.province_id', $province->id);
    }

    public function test_city_requires_province_id(): void
    {
        $payload = City::factory()->make(['province_id' => null])->toArray();

        $response = $this->actingAs($this->adminUser)
            ->postJson(self::API_PREFIX . '/master/cities', $payload);

        $response->assertUnprocessable()
            ->assertJsonValidationErrors(['province_id']);
    }

    // ======================= REGION: District =======================

    public function test_district_can_be_created_with_city_relation(): void
    {
        $province = Province::factory()->create();
        $city = City::factory()->withProvince($province)->create();
        $payload = District::factory()->withCity($city)->make()->toArray();

        $response = $this->actingAs($this->adminUser)
            ->postJson(self::API_PREFIX . '/master/districts', $payload);

        $response->assertCreated()
            ->assertJsonPath('data.city_id', $city->id);
    }

    public function test_district_requires_city_id(): void
    {
        $payload = District::factory()->make(['city_id' => null])->toArray();

        $response = $this->actingAs($this->adminUser)
            ->postJson(self::API_PREFIX . '/master/districts', $payload);

        $response->assertUnprocessable()
            ->assertJsonValidationErrors(['city_id']);
    }

    // ======================= REGION: Village =======================

    public function test_village_requires_district_id(): void
    {
        $payload = Village::factory()->make(['district_id' => null])->toArray();

        $response = $this->actingAs($this->adminUser)
            ->postJson(self::API_PREFIX . '/master/villages', $payload);

        $response->assertUnprocessable()
            ->assertJsonValidationErrors(['district_id']);
    }

    // ======================= REGION: Unit =======================

    public function test_unit_crud(): void
    {
        // List
        Unit::factory()->count(2)->create();
        $this->actingAs($this->adminUser)
            ->getJson(self::API_PREFIX . '/master/units')
            ->assertOk();

        // Create
        $payload = Unit::factory()->make()->toArray();
        $response = $this->actingAs($this->adminUser)
            ->postJson(self::API_PREFIX . '/master/units', $payload);
        $response->assertCreated();

        // Show
        $unitId = $response->json('data.id');
        $this->actingAs($this->adminUser)
            ->getJson(self::API_PREFIX . "/master/units/{$unitId}")
            ->assertOk()
            ->assertJsonPath('data.id', $unitId);

        // Update
        $this->actingAs($this->adminUser)
            ->putJson(self::API_PREFIX . "/master/units/{$unitId}", [
                'name' => 'Updated Unit',
            ])
            ->assertOk()
            ->assertJsonPath('data.name', 'Updated Unit');

        // Delete
        $this->actingAs($this->adminUser)
            ->deleteJson(self::API_PREFIX . "/master/units/{$unitId}")
            ->assertOk();

        $this->assertSoftDeleted('units', ['id' => $unitId]);
    }

    // ======================= REGION: Company with Farm =======================

    public function test_company_can_be_created(): void
    {
        $village = Village::factory()->create();
        $unit = Unit::factory()->create();
        $payload = Company::factory()->withRelations($village, $unit)->make()->toArray();

        $response = $this->actingAs($this->adminUser)
            ->postJson(self::API_PREFIX . '/master/companies', $payload);

        $response->assertCreated()
            ->assertJsonPath('data.village_id', $village->id)
            ->assertJsonPath('data.unit_id', $unit->id);
    }

    public function test_farm_can_be_created_with_company_relation(): void
    {
        $village = Village::factory()->create();
        $unit = Unit::factory()->create();
        $company = Company::factory()->withRelations($village, $unit)->create();
        $payload = Farm::factory()->withCompany($company)->make()->toArray();

        $response = $this->actingAs($this->adminUser)
            ->postJson(self::API_PREFIX . '/master/farms', $payload);

        $response->assertCreated()
            ->assertJsonPath('data.company_id', $company->id);
    }

    // ======================= REGION: Pond Area & Pond =======================

    public function test_pond_area_and_pond_hierarchical(): void
    {
        $village = Village::factory()->create();
        $unit = Unit::factory()->create();
        $company = Company::factory()->withRelations($village, $unit)->create();
        $farm = Farm::factory()->withCompany($company)->create();

        // Create Pond Area
        $pondAreaPayload = PondArea::factory()->withFarm($farm)->make()->toArray();
        $pondAreaResponse = $this->actingAs($this->adminUser)
            ->postJson(self::API_PREFIX . '/master/pond-areas', $pondAreaPayload);
        $pondAreaResponse->assertCreated();
        $pondAreaId = $pondAreaResponse->json('data.id');

        // Create Pond
        $pondPayload = Pond::factory()->withPondAreaId($pondAreaId)->make()->toArray();
        $pondResponse = $this->actingAs($this->adminUser)
            ->postJson(self::API_PREFIX . '/master/ponds', $pondPayload);
        $pondResponse->assertCreated()
            ->assertJsonPath('data.pond_area_id', $pondAreaId);
    }

    // ======================= REGION: Fish Species & Strain =======================

    public function test_fish_species_with_strains(): void
    {
        // Create fish species
        $speciesPayload = FishSpecies::factory()->make()->toArray();
        $speciesResponse = $this->actingAs($this->adminUser)
            ->postJson(self::API_PREFIX . '/master/fish-species', $speciesPayload);
        $speciesResponse->assertCreated();
        $speciesId = $speciesResponse->json('data.id');

        // Create strain for species
        $strainPayload = FishStrain::factory()->withSpecies($speciesId)->make()->toArray();
        $this->actingAs($this->adminUser)
            ->postJson(self::API_PREFIX . '/master/fish-strains', $strainPayload)
            ->assertCreated()
            ->assertJsonPath('data.fish_species_id', $speciesId);
    }

    // ======================= REGION: Feed =======================

    public function test_feed_hierarchy(): void
    {
        $brand = FeedBrand::factory()->create();
        $category = FeedCategory::factory()->withBrand($brand)->create();
        $typePayload = FeedType::factory()->withCategory($category)->make()->toArray();

        $this->actingAs($this->adminUser)
            ->postJson(self::API_PREFIX . '/master/feed-types', $typePayload)
            ->assertCreated()
            ->assertJsonPath('data.feed_category_id', $category->id);
    }

    // ======================= REGION: Medicine =======================

    public function test_medicine_crud(): void
    {
        $payload = Medicine::factory()->make()->toArray();

        $response = $this->actingAs($this->adminUser)
            ->postJson(self::API_PREFIX . '/master/medicines', $payload);

        $response->assertCreated();
        $id = $response->json('data.id');

        $this->actingAs($this->adminUser)
            ->getJson(self::API_PREFIX . "/master/medicines/{$id}")
            ->assertOk();

        $this->actingAs($this->adminUser)
            ->putJson(self::API_PREFIX . "/master/medicines/{$id}", [
                'name' => 'Updated Medicine',
            ])
            ->assertOk();

        $this->actingAs($this->adminUser)
            ->deleteJson(self::API_PREFIX . "/master/medicines/{$id}")
            ->assertOk();

        $this->assertSoftDeleted('medicines', ['id' => $id]);
    }

    // ======================= REGION: Probiotic & Vitamin =======================

    public function test_probiotic_crud(): void
    {
        $payload = Probiotic::factory()->make()->toArray();

        $response = $this->actingAs($this->adminUser)
            ->postJson(self::API_PREFIX . '/master/probiotics', $payload);

        $response->assertCreated();
        $id = $response->json('data.id');

        $this->actingAs($this->adminUser)
            ->putJson(self::API_PREFIX . "/master/probiotics/{$id}", [
                'name' => 'Updated Probiotic',
            ])
            ->assertOk();

        $this->actingAs($this->adminUser)
            ->deleteJson(self::API_PREFIX . "/master/probiotics/{$id}")
            ->assertOk();
    }

    public function test_vitamin_crud(): void
    {
        $payload = Vitamin::factory()->make()->toArray();

        $response = $this->actingAs($this->adminUser)
            ->postJson(self::API_PREFIX . '/master/vitamins', $payload);

        $response->assertCreated();
        $id = $response->json('data.id');

        $this->actingAs($this->adminUser)
            ->getJson(self::API_PREFIX . "/master/vitamins/{$id}")
            ->assertOk();

        $this->actingAs($this->adminUser)
            ->deleteJson(self::API_PREFIX . "/master/vitamins/{$id}")
            ->assertOk();
    }

    // ======================= REGION: Supplier & Customer & Employee =======================

    public function test_supplier_crud(): void
    {
        $payload = Supplier::factory()->make()->toArray();

        $response = $this->actingAs($this->adminUser)
            ->postJson(self::API_PREFIX . '/master/suppliers', $payload);

        $response->assertCreated();
        $id = $response->json('data.id');

        $this->actingAs($this->adminUser)
            ->getJson(self::API_PREFIX . "/master/suppliers/{$id}")
            ->assertOk()
            ->assertJsonPath('data.id', $id);

        $this->actingAs($this->adminUser)
            ->deleteJson(self::API_PREFIX . "/master/suppliers/{$id}")
            ->assertOk();
    }

    public function test_customer_crud(): void
    {
        $payload = Customer::factory()->make()->toArray();

        $response = $this->actingAs($this->adminUser)
            ->postJson(self::API_PREFIX . '/master/customers', $payload);

        $response->assertCreated();
        $id = $response->json('data.id');

        $this->actingAs($this->adminUser)
            ->putJson(self::API_PREFIX . "/master/customers/{$id}", [
                'name' => 'Updated Customer',
            ])
            ->assertOk()
            ->assertJsonPath('data.name', 'Updated Customer');
    }

    public function test_employee_crud(): void
    {
        $payload = Employee::factory()->make()->toArray();

        $response = $this->actingAs($this->adminUser)
            ->postJson(self::API_PREFIX . '/master/employees', $payload);

        $response->assertCreated();
        $id = $response->json('data.id');

        $this->actingAs($this->adminUser)
            ->deleteJson(self::API_PREFIX . "/master/employees/{$id}")
            ->assertOk();
    }

    // ======================= REGION: General Reference =======================

    public function test_general_reference_crud(): void
    {
        $payload = GeneralReference::factory()->make()->toArray();

        $response = $this->actingAs($this->adminUser)
            ->postJson(self::API_PREFIX . '/master/general-references', $payload);

        $response->assertCreated();
        $id = $response->json('data.id');

        $this->actingAs($this->adminUser)
            ->getJson(self::API_PREFIX . "/master/general-references/{$id}")
            ->assertOk();

        $this->actingAs($this->adminUser)
            ->putJson(self::API_PREFIX . "/master/general-references/{$id}", [
                'label' => 'Updated Label',
            ])
            ->assertOk();

        $this->actingAs($this->adminUser)
            ->deleteJson(self::API_PREFIX . "/master/general-references/{$id}")
            ->assertOk();
    }

    // ======================= REGION: Validation =======================

    public function test_unauthenticated_user_cannot_access_api(): void
    {
        $this->getJson(self::API_PREFIX . '/master/provinces')
            ->assertUnauthorized();
    }

    public function test_validation_errors_return_422(): void
    {
        $this->actingAs($this->adminUser)
            ->postJson(self::API_PREFIX . '/master/provinces', [])
            ->assertUnprocessable()
            ->assertJsonValidationErrors(['code', 'name']);
    }

    public function test_not_found_returns_404(): void
    {
        $this->actingAs($this->adminUser)
            ->getJson(self::API_PREFIX . '/master/provinces/99999')
            ->assertNotFound();
    }

    // ======================= REGION: Search & Filter =======================

    public function test_provinces_can_be_searched(): void
    {
        Province::factory()->create(['name' => 'Jawa Barat']);
        Province::factory()->create(['name' => 'Jawa Timur']);
        Province::factory()->create(['name' => 'Sumatera Utara']);

        $response = $this->actingAs($this->adminUser)
            ->getJson(self::API_PREFIX . '/master/provinces?search=Jawa');

        $response->assertOk();
        $names = collect($response->json('data.data'))->pluck('name');
        $this->assertContains('Jawa Barat', $names);
        $this->assertContains('Jawa Timur', $names);
        $this->assertNotContains('Sumatera Utara', $names);
    }

    public function test_resources_can_be_paginated(): void
    {
        Province::factory()->count(15)->create();

        $response = $this->actingAs($this->adminUser)
            ->getJson(self::API_PREFIX . '/master/provinces?per_page=5');

        $response->assertOk()
            ->assertJsonPath('data.meta.per_page', 5)
            ->assertJsonPath('data.meta.total', 15);
    }
}