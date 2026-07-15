<?php

namespace Tests\Feature\MasterData;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use MasterData\Models\City;
use MasterData\Models\Company;
use MasterData\Models\Customer;
use MasterData\Models\District;
use MasterData\Models\Employee;
use MasterData\Models\Farm;
use MasterData\Models\FeedBrand;
use MasterData\Models\FeedCategory;
use MasterData\Models\FishSpecies;
use MasterData\Models\PondArea;
use MasterData\Models\Province;
use MasterData\Models\Unit;
use MasterData\Models\Village;
use Modules\Users\Models\User;
use Tests\TestCase;

final class MasterDataApiTest extends TestCase
{
    use RefreshDatabase;

    private const API_PREFIX = '/api/v1';

    private User $adminUser;

    protected function setUp(): void
    {
        parent::setUp();

        $this->adminUser = User::factory()->create();
        $this->adminUser->assignRole('super-admin');
    }

    public function test_province_crud_flow(): void
    {
        $payload = [
            'province_code' => 'PROV-API',
            'province_name' => 'Province API',
        ];

        $createResponse = $this->actingAs($this->adminUser)
            ->postJson(self::API_PREFIX.'/master/provinces', $payload);

        $createResponse->assertCreated()
            ->assertJsonPath('success', true)
            ->assertJsonPath('data.province_code', 'PROV-API');

        $uuid = $createResponse->json('data.uuid');

        $this->actingAs($this->adminUser)
            ->getJson(self::API_PREFIX."/master/provinces/{$uuid}")
            ->assertOk()
            ->assertJsonPath('data.province_name', 'Province API');

        $this->actingAs($this->adminUser)
            ->putJson(self::API_PREFIX."/master/provinces/{$uuid}", [
                'province_code' => 'PROV-API-UPD',
                'province_name' => 'Province API Updated',
            ])->assertOk()
            ->assertJsonPath('data.province_name', 'Province API Updated');

        $this->actingAs($this->adminUser)
            ->deleteJson(self::API_PREFIX."/master/provinces/{$uuid}")
            ->assertOk()
            ->assertJsonPath('message', 'Data deleted successfully');

        $this->assertSoftDeleted('provinces', ['uuid' => $uuid]);
    }

    public function test_region_hierarchy_can_be_created(): void
    {
        $province = Province::factory()->create();

        $cityResponse = $this->actingAs($this->adminUser)
            ->postJson(self::API_PREFIX.'/master/cities', [
                'province_id' => $province->id,
                'city_code' => 'CITY-API',
                'city_name' => 'City API',
            ]);

        $cityResponse->assertCreated()
            ->assertJsonPath('data.province_id', $province->id);

        $districtResponse = $this->actingAs($this->adminUser)
            ->postJson(self::API_PREFIX.'/master/districts', [
                'city_id' => $cityResponse->json('data.id'),
                'district_code' => 'DIST-API',
                'district_name' => 'District API',
            ]);

        $districtResponse->assertCreated()
            ->assertJsonPath('data.city_id', $cityResponse->json('data.id'));

        $this->actingAs($this->adminUser)
            ->postJson(self::API_PREFIX.'/master/villages', [
                'district_id' => $districtResponse->json('data.id'),
                'village_code' => 'VIL-API',
                'village_name' => 'Village API',
            ])->assertCreated()
            ->assertJsonPath('data.district_id', $districtResponse->json('data.id'));
    }

    public function test_unit_crud_flow(): void
    {
        $createResponse = $this->actingAs($this->adminUser)
            ->postJson(self::API_PREFIX.'/master/units', [
                'unit_code' => 'KG-API',
                'unit_name' => 'Kilogram API',
                'symbol' => 'kg-api',
            ]);

        $createResponse->assertCreated()
            ->assertJsonPath('data.unit_code', 'KG-API');

        $uuid = $createResponse->json('data.uuid');

        $this->actingAs($this->adminUser)
            ->putJson(self::API_PREFIX."/master/units/{$uuid}", [
                'unit_code' => 'KG-API-UPD',
                'unit_name' => 'Kilogram API Updated',
                'symbol' => 'kg-api',
            ])->assertOk()
            ->assertJsonPath('data.unit_name', 'Kilogram API Updated');

        $this->actingAs($this->adminUser)
            ->deleteJson(self::API_PREFIX."/master/units/{$uuid}")
            ->assertOk();

        $this->assertSoftDeleted('units', ['uuid' => $uuid]);
    }

    public function test_company_farm_pond_area_and_pond_can_be_created(): void
    {
        $context = $this->createRegionContext();

        $companyResponse = $this->actingAs($this->adminUser)
            ->postJson(self::API_PREFIX.'/master/companies', [
                'company_code' => 'CMP-API',
                'company_name' => 'Company API',
                'email' => 'company.api@example.com',
                'province_id' => $context['province']->id,
                'city_id' => $context['city']->id,
                'district_id' => $context['district']->id,
                'village_id' => $context['village']->id,
            ]);

        $companyResponse->assertCreated()
            ->assertJsonPath('data.company_code', 'CMP-API');

        $farmResponse = $this->actingAs($this->adminUser)
            ->postJson(self::API_PREFIX.'/master/farms', [
                'company_id' => $companyResponse->json('data.id'),
                'farm_code' => 'FRM-API',
                'farm_name' => 'Farm API',
                'area_size' => 1000,
            ]);

        $farmResponse->assertCreated()
            ->assertJsonPath('data.company_id', $companyResponse->json('data.id'));

        $pondAreaResponse = $this->actingAs($this->adminUser)
            ->postJson(self::API_PREFIX.'/master/pond-areas', [
                'farm_id' => $farmResponse->json('data.id'),
                'pond_area_code' => 'PA-API',
                'pond_area_name' => 'Pond Area API',
                'area_size' => 500,
            ]);

        $pondAreaResponse->assertCreated();

        $this->actingAs($this->adminUser)
            ->postJson(self::API_PREFIX.'/master/ponds', [
                'pond_area_id' => $pondAreaResponse->json('data.id'),
                'pond_code' => 'PND-API',
                'pond_name' => 'Pond API',
                'area_size' => 250,
                'depth' => 2,
                'volume' => 500,
            ])->assertCreated()
            ->assertJsonPath('data.pond_area_id', $pondAreaResponse->json('data.id'));
    }

    public function test_fish_and_feed_master_data_can_be_created(): void
    {
        $speciesResponse = $this->actingAs($this->adminUser)
            ->postJson(self::API_PREFIX.'/master/fish-species', [
                'fish_species_code' => 'FSP-API',
                'fish_species_name' => 'Species API',
                'scientific_name' => 'Species scientific',
            ]);

        $speciesResponse->assertCreated();

        $this->actingAs($this->adminUser)
            ->postJson(self::API_PREFIX.'/master/fish-strains', [
                'fish_species_id' => $speciesResponse->json('data.id'),
                'fish_strain_code' => 'FST-API',
                'fish_strain_name' => 'Strain API',
            ])->assertCreated()
            ->assertJsonPath('data.fish_species_id', $speciesResponse->json('data.id'));

        $brand = FeedBrand::factory()->create();
        $category = FeedCategory::factory()->create();

        $this->actingAs($this->adminUser)
            ->postJson(self::API_PREFIX.'/master/feed-types', [
                'feed_brand_id' => $brand->id,
                'feed_category_id' => $category->id,
                'feed_type_code' => 'FT-API',
                'feed_type_name' => 'Feed Type API',
                'protein_content' => 32,
            ])->assertCreated()
            ->assertJsonPath('data.feed_category_id', $category->id);
    }

    public function test_operational_master_data_can_be_created(): void
    {
        $this->actingAs($this->adminUser)
            ->postJson(self::API_PREFIX.'/master/medicines', [
                'medicine_code' => 'MED-API',
                'medicine_name' => 'Medicine API',
                'active_ingredient' => 'Ingredient API',
            ])->assertCreated();

        $this->actingAs($this->adminUser)
            ->postJson(self::API_PREFIX.'/master/probiotics', [
                'probiotic_code' => 'PRO-API',
                'probiotic_name' => 'Probiotic API',
                'bacterial_strain' => 'Strain API',
            ])->assertCreated();

        $this->actingAs($this->adminUser)
            ->postJson(self::API_PREFIX.'/master/vitamins', [
                'vitamin_code' => 'VIT-API',
                'vitamin_name' => 'Vitamin API',
                'composition' => 'Composition API',
            ])->assertCreated();

        $this->actingAs($this->adminUser)
            ->postJson(self::API_PREFIX.'/master/general-references', [
                'reference_code' => 'REF-API',
                'reference_name' => 'Reference API',
                'reference_group' => 'api_group',
            ])->assertCreated();
    }

    public function test_partner_and_employee_master_data_can_be_created(): void
    {
        $this->actingAs($this->adminUser)
            ->postJson(self::API_PREFIX.'/master/suppliers', [
                'supplier_code' => 'SUP-API',
                'supplier_name' => 'Supplier API',
                'supplier_type' => 'feed',
            ])->assertCreated();

        $this->actingAs($this->adminUser)
            ->postJson(self::API_PREFIX.'/master/customers', [
                'customer_code' => 'CUS-API',
                'customer_name' => 'Customer API',
                'customer_type' => 'corporate',
            ])->assertCreated();

        $this->actingAs($this->adminUser)
            ->postJson(self::API_PREFIX.'/master/employees', [
                'employee_code' => 'EMP-API',
                'employee_name' => 'Employee API',
                'gender' => 'L',
                'is_active' => true,
            ])->assertCreated();
    }

    public function test_validation_errors_return_422(): void
    {
        $this->actingAs($this->adminUser)
            ->postJson(self::API_PREFIX.'/master/provinces', [])
            ->assertUnprocessable()
            ->assertJsonValidationErrors(['province_code', 'province_name']);
    }

    public function test_not_found_returns_404(): void
    {
        $this->actingAs($this->adminUser)
            ->getJson(self::API_PREFIX.'/master/provinces/'.Str::uuid()->toString())
            ->assertNotFound();
    }

    public function test_provinces_can_be_searched(): void
    {
        Province::factory()->create(['province_name' => 'Jawa Barat']);
        Province::factory()->create(['province_name' => 'Jawa Timur']);
        Province::factory()->create(['province_name' => 'Sumatera Utara']);

        $response = $this->actingAs($this->adminUser)
            ->getJson(self::API_PREFIX.'/master/provinces?search=Jawa');

        $response->assertOk();

        $names = collect($response->json('data'))->pluck('province_name');
        $this->assertContains('Jawa Barat', $names);
        $this->assertContains('Jawa Timur', $names);
        $this->assertNotContains('Sumatera Utara', $names);
    }

    public function test_resources_can_be_paginated(): void
    {
        Province::factory()->count(15)->create();

        $this->actingAs($this->adminUser)
            ->getJson(self::API_PREFIX.'/master/provinces?per_page=5')
            ->assertOk()
            ->assertJsonPath('meta.per_page', 5)
            ->assertJsonPath('meta.total', 15);
    }

    public function test_unauthenticated_user_cannot_access_api(): void
    {
        $this->getJson(self::API_PREFIX.'/master/provinces')
            ->assertUnauthorized();
    }

    private function createRegionContext(): array
    {
        $province = Province::factory()->create();
        $city = City::factory()->create(['province_id' => $province->id]);
        $district = District::factory()->create(['city_id' => $city->id]);
        $village = Village::factory()->create(['district_id' => $district->id]);

        return [
            'province' => $province,
            'city' => $city,
            'district' => $district,
            'village' => $village,
        ];
    }
}
