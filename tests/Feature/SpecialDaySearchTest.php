<?php

namespace Tests\Feature;

use App\Filament\Resources\SpecialDays\Pages\ListSpecialDays;
use App\Models\SpecialDay;
use App\Models\User;
use Livewire\Livewire;
use Tests\TestCase;

class SpecialDaySearchTest extends TestCase
{
    public function test_special_days_can_be_searched_by_name_and_date(): void
    {
        $this->actingAs(User::factory()->create());

        $nameMatch = SpecialDay::create([
            'name' => 'आरती संग्रह',
            'date' => '2023-09-19',
        ]);
        $dateMatch = SpecialDay::create([
            'name' => 'स्वातंत्र्य दिन',
            'date' => '2024-08-15',
        ]);

        Livewire::test(ListSpecialDays::class)
            ->searchTable('आरती')
            ->assertCanSeeTableRecords([$nameMatch])
            ->assertCanNotSeeTableRecords([$dateMatch])
            ->searchTable('Sep 19, 2023')
            ->assertCanSeeTableRecords([$nameMatch])
            ->assertCanNotSeeTableRecords([$dateMatch])
            ->searchTable('19 Sep 2023')
            ->assertCanSeeTableRecords([$nameMatch])
            ->assertCanNotSeeTableRecords([$dateMatch])
            ->searchTable('Sep 19 2023')
            ->assertCanSeeTableRecords([$nameMatch])
            ->assertCanNotSeeTableRecords([$dateMatch])
            ->searchTable('2024-08-15')
            ->assertCanSeeTableRecords([$dateMatch])
            ->assertCanNotSeeTableRecords([$nameMatch]);
    }
}
