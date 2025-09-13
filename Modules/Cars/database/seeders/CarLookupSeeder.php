<?php

namespace Modules\Cars\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Cars\Entities\Lookups\CarYear;
use Modules\Cars\Entities\Lookups\CarColor;
use Modules\Cars\Entities\Lookups\CarType;
use Modules\Cars\Entities\Lookups\CarModel;
use Modules\Cars\Entities\Lookups\CarStatus;
use Modules\Cars\Entities\Lookups\CarBrand;
use Modules\Cars\Entities\Lookups\CarDocumentDataType;
use Modules\Cars\Entities\Lookups\CarDelegationType;
use Modules\Cars\Entities\Lookups\ViolationType;
use Modules\Cars\Entities\Lookups\ViolationPaymentStatus;

class CarLookupSeeder extends Seeder
{
    public function run(): void
    {
        $years = [2020, 2021, 2022, 2023, 2024];
        foreach ($years as $year) {
            CarYear::firstOrCreate(['year' => $year]);
        }

        $colors = [
            ['name_en' => 'White', 'name_ar' => 'أبيض'],
            ['name_en' => 'Black', 'name_ar' => 'أسود'],
            ['name_en' => 'Silver', 'name_ar' => 'فضي'],
            ['name_en' => 'Blue', 'name_ar' => 'أزرق'],
            ['name_en' => 'Red', 'name_ar' => 'أحمر'],
        ];
        foreach ($colors as $color) {
            CarColor::firstOrCreate($color);
        }

        $types = [
            [
                'name_en' => 'Sedan',
                'name_ar' => 'سيدان',
                'brands' => [
                    [
                        'name_en' => 'Toyota',
                        'name_ar' => 'تويوتا',
                        'models' => [
                            ['name_en' => 'Corolla', 'name_ar' => 'كورولا'],
                            ['name_en' => 'Camry', 'name_ar' => 'كامري'],
                        ],
                    ],
                    [
                        'name_en' => 'Honda',
                        'name_ar' => 'هوندا',
                        'models' => [
                            ['name_en' => 'Civic', 'name_ar' => 'سيفيك'],
                            ['name_en' => 'Accord', 'name_ar' => 'أكورد'],
                        ],
                    ],
                ],
            ],
            [
                'name_en' => 'SUV',
                'name_ar' => 'دفع رباعي',
                'brands' => [
                    [
                        'name_en' => 'Toyota',
                        'name_ar' => 'تويوتا',
                        'models' => [
                            ['name_en' => 'RAV4', 'name_ar' => 'راف4'],
                        ],
                    ],
                    [
                        'name_en' => 'Honda',
                        'name_ar' => 'هوندا',
                        'models' => [
                            ['name_en' => 'CR-V', 'name_ar' => 'سي آر في'],
                        ],
                    ],
                ],
            ],
            [
                'name_en' => 'Truck',
                'name_ar' => 'شاحنة',
                'brands' => [
                    [
                        'name_en' => 'Ford',
                        'name_ar' => 'فورد',
                        'models' => [
                            ['name_en' => 'F-150', 'name_ar' => 'F-150'],
                        ],
                    ],
                ],
            ],
            [
                'name_en' => 'Van',
                'name_ar' => 'فان',
                'brands' => [
                    [
                        'name_en' => 'Toyota',
                        'name_ar' => 'تويوتا',
                        'models' => [
                            ['name_en' => 'HiAce', 'name_ar' => 'هايس'],
                        ],
                    ],
                ],
            ],
        ];

        foreach ($types as $typeData) {
            $type = CarType::firstOrCreate([
                'name_en' => $typeData['name_en'],
                'name_ar' => $typeData['name_ar'],
            ]);
            foreach ($typeData['brands'] as $brandData) {
                $brand = CarBrand::firstOrCreate([
                    'car_type_id' => $type->id,
                    'name_en' => $brandData['name_en'],
                    'name_ar' => $brandData['name_ar'],
                ]);
                foreach ($brandData['models'] as $modelData) {
                    CarModel::firstOrCreate([
                        'car_type_id' => $type->id,
                        'car_brand_id' => $brand->id,
                        'name_en' => $modelData['name_en'],
                        'name_ar' => $modelData['name_ar'],
                    ]);
                }
            }
        }

        $statuses = [
            ['name_en' => 'available', 'name_ar' => 'متاح'],
            ['name_en' => 'assigned', 'name_ar' => 'مخصص'],
            ['name_en' => 'maintenance', 'name_ar' => 'صيانة'],
            ['name_en' => 'retired', 'name_ar' => 'مستبعد'],
        ];
        foreach ($statuses as $status) {
            CarStatus::firstOrCreate($status);
        }

        $documentDataTypes = [
            ['name_en' => 'registration', 'name_ar' => 'استمارة'],
            ['name_en' => 'insurance', 'name_ar' => 'تأمين'],
            ['name_en' => 'ownership', 'name_ar' => 'ملكية'],
        ];
        foreach ($documentDataTypes as $type) {
            CarDocumentDataType::firstOrCreate($type);
        }

        $delegationTypes = [
            ['name_en' => 'driving', 'name_ar' => 'قيادة'],
            ['name_en' => 'selling', 'name_ar' => 'بيع'],
        ];
        foreach ($delegationTypes as $type) {
            CarDelegationType::firstOrCreate($type);
        }

        $violationTypes = [
            ['name_en' => 'speeding', 'name_ar' => 'تجاوز السرعة'],
            ['name_en' => 'parking', 'name_ar' => 'مخالفة وقوف'],
            ['name_en' => 'red_light', 'name_ar' => 'قطع إشارة'],
        ];
        foreach ($violationTypes as $type) {
            ViolationType::firstOrCreate($type);
        }

        $violationPaymentStatuses = [
            ['name_en' => 'unpaid', 'name_ar' => 'غير مدفوعة'],
            ['name_en' => 'paid', 'name_ar' => 'مدفوعة'],
            ['name_en' => 'pending', 'name_ar' => 'قيد المعالجة'],
        ];
        foreach ($violationPaymentStatuses as $paymentStatus) {
            ViolationPaymentStatus::firstOrCreate($paymentStatus);
        }
    }
}
