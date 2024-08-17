<?php

declare(strict_types = 1);

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            [
                'key'   => 'title',
                'value' => 'Casamento de João & Maria',
                'type'  => 'text',
            ],
            [
                'key'   => 'subtitle',
                'value' => 'O dia mais feliz de nossas vidas',
                'type'  => 'textarea',
            ],
            [
                'key'   => 'local',
                'value' => 'Igreja Matriz de São José',
                'type'  => 'text',
            ],
            [
                'key'   => 'date',
                'value' => now()->addWeek()->format('Y-m-d'),
                'type'  => 'date',
            ],
            [
                'key'   => 'hour',
                'value' => now()->addWeek()->format('H:i'),
                'type'  => 'time',
            ],
            [
                'key'   => 'contact',
                'value' => '(11) 99999-9999',
                'type'  => 'phone',
            ],
            [
                'key'   => 'footer',
                'value' => 'Laravel',
                'type'  => 'text',
            ],
            [
                'key'   => 'event_receipt',
                'value' => 'Recebemos a assinatura do seu presente! Como você escolheu entregar o presente no evento gostaríamos de te lembrar os detalhes sobre o evento. O evento ocorrerá em {%local%}, as {%hora%} do dia {%data%}. Esperamos por você. Obrigado!',
                'type'  => 'textarea',
            ],
            [
                'key'   => 'remove_receiving',
                'value' => 'Recebemos a assinatura do seu presente! Entraremos em contato com você pelo número informado em breve. Obrigado!',
                'type'  => 'textarea',
            ],
        ];

        $newArray = [];

        foreach ($settings as $setting) {
            $setting['key'] = strtoupper($setting['key']);
            $newArray[]     = $setting;
        }
        Setting::insert($newArray);
    }
}
