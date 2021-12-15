<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $options = [
            [
                'type' => 'animation',
                'name' => 'Fade In',
                'value' => 'fadeIn',
                'field_type' => 'entrance'
            ],
            [
                'type' => 'animation',
                'name' => 'Fade Out',
                'value' => 'fadeOut',
                'field_type' => 'exit'
            ],
            [
                'type' => 'animation',
                'name' => 'Fade In Down',
                'value' => 'fadeInDown',
                'field_type' => 'entrance'
            ],
            [
                'type' => 'animation',
                'name' => 'Fade Out Down',
                'value' => 'fadeOutDown',
                'field_type' => 'exit'
            ],
            [
                'type' => 'animation',
                'name' => 'Fade In Down Big',
                'value' => 'fadeInDownBig',
                'field_type' => 'entrance'
            ],
            [
                'type' => 'animation',
                'name' => 'Fade Out Down Big',
                'value' => 'fadeOutDownBig',
                'field_type' => 'exit'
            ],
            [
                'type' => 'animation',
                'name' => 'Fade In Left',
                'value' => 'fadeInLeft',
                'field_type' => 'entrance'
            ],
            [
                'type' => 'animation',
                'name' => 'Fade Out Left',
                'value' => 'fadeOutLeft',
                'field_type' => 'exit'
            ],
            [
                'type' => 'animation',
                'name' => 'Fade In Left Big',
                'value' => 'fadeInLeftBig',
                'field_type' => 'entrance'
            ],
            [
                'type' => 'animation',
                'name' => 'Fade Out Left Big',
                'value' => 'fadeOutDownBig',
                'field_type' => 'exit'
            ],
            [
                'type' => 'animation',
                'name' => 'Fade In Right',
                'value' => 'fadeInRight',
                'field_type' => 'entrance'
            ],
            [
                'type' => 'animation',
                'name' => 'Fade Out Right',
                'value' => 'fadeOutRight',
                'field_type' => 'exit'
            ],
            [
                'type' => 'animation',
                'name' => 'Fade In Right Big',
                'value' => 'fadeInRightBig',
                'field_type' => 'entrance'
            ],
            [
                'type' => 'animation',
                'name' => 'Fade Out Right Big',
                'value' => 'fadeInRightBig',
                'field_type' => 'exit'
            ],
            [
                'type' => 'animation',
                'name' => 'Fade In Up',
                'value' => 'fadeInUp',
                'field_type' => 'entrance'
            ],
            [
                'type' => 'animation',
                'name' => 'Fade Out Up',
                'value' => 'fadeOutUp',
                'field_type' => 'exit'
            ],
            [
                'type' => 'animation',
                'name' => 'Fade In Up Big',
                'value' => 'fadeInUpBig',
                'field_type' => 'entrance'
            ],
            [
                'type' => 'animation',
                'name' => 'Fade Out Up Big',
                'value' => 'fadeInUpBig',
                'field_type' => 'exit'
            ],
            [
                'type' => 'animation',
                'name' => 'Bounce In',
                'value' => 'bounceIn',
                'field_type' => 'entrance'
            ],
            [
                'type' => 'animation',
                'name' => 'Bounce Out',
                'value' => 'bounceOut',
                'field_type' => 'exit'
            ],
            [
                'type' => 'animation',
                'name' => 'Bounce In Down',
                'value' => 'bounceInDown',
                'field_type' => 'entrance'
            ],
            [
                'type' => 'animation',
                'name' => 'Bounce Out Down',
                'value' => 'bounceOutDown',
                'field_type' => 'exit'
            ],
            [
                'type' => 'animation',
                'name' => 'Bounce In Left',
                'value' => 'bounceInLeft',
                'field_type' => 'entrance'
            ],
            [
                'type' => 'animation',
                'name' => 'Bounce Out Left',
                'value' => 'bounceOutLeft',
                'field_type' => 'exit'
            ],
            [
                'type' => 'animation',
                'name' => 'Bounce In Right',
                'value' => 'bounceInRight',
                'field_type' => 'entrance'
            ],
            [
                'type' => 'animation',
                'name' => 'Bounce Out Right',
                'value' => 'bounceOutRight',
                'field_type' => 'exit'
            ],
            [
                'type' => 'animation',
                'name' => 'Bounce In Up',
                'value' => 'bounceInUp',
                'field_type' => 'entrance'
            ],
            [
                'type' => 'animation',
                'name' => 'Bounce Out Up',
                'value' => 'bounceOutUp',
                'field_type' => 'exit'
            ],
            [
                'type' => 'animation',
                'name' => 'Route In',
                'value' => 'rotateIn',
                'field_type' => 'entrance'
            ],
            [
                'type' => 'animation',
                'name' => 'Route Out',
                'value' => 'rotateOut',
                'field_type' => 'exit'
            ],
            [
                'type' => 'animation',
                'name' => 'Route In Down Left',
                'value' => 'rotateInDownLeft',
                'field_type' => 'entrance'
            ],
            [
                'type' => 'animation',
                'name' => 'Route Out Down Left',
                'value' => 'rotateOutDownLeft',
                'field_type' => 'exit'
            ],
            [
                'type' => 'animation',
                'name' => 'Route In Down Right',
                'value' => 'rotateInDownRight',
                'field_type' => 'entrance'
            ],
            [
                'type' => 'animation',
                'name' => 'Route Out Down Right',
                'value' => 'rotateOutDownRight',
                'field_type' => 'exit'
            ],
            [
                'type' => 'animation',
                'name' => 'Route In Up Left',
                'value' => 'rotateInUpLeft',
                'field_type' => 'entrance'
            ],
            [
                'type' => 'animation',
                'name' => 'Route Out Up Left',
                'value' => 'rotateOutUpLeft',
                'field_type' => 'exit'
            ],
            [
                'type' => 'animation',
                'name' => 'Route In Up Right',
                'value' => 'rotateInUpRight',
                'field_type' => 'entrance'
            ],
            [
                'type' => 'animation',
                'name' => 'Route Out Up Right',
                'value' => 'rotateOutUpRight',
                'field_type' => 'exit'
            ],
            [
                'type' => 'animation',
                'name' => 'Slide In Up',
                'value' => 'slideInUp',
                'field_type' => 'entrance'
            ],
            [
                'type' => 'animation',
                'name' => 'Slide Out Up',
                'value' => 'slideOutUp',
                'field_type' => 'exit'
            ],
            [
                'type' => 'animation',
                'name' => 'Slide In Down',
                'value' => 'slideInDown',
                'field_type' => 'entrance'
            ],
            [
                'type' => 'animation',
                'name' => 'Slide Out Down',
                'value' => 'slideOutDown',
                'field_type' => 'exit'
            ],
            [
                'type' => 'animation',
                'name' => 'Slide In Left',
                'value' => 'slideInLeft',
                'field_type' => 'entrance'
            ],
            [
                'type' => 'animation',
                'name' => 'Slide Out Left',
                'value' => 'slideOutLeft',
                'field_type' => 'exit'
            ],
            [
                'type' => 'animation',
                'name' => 'Slide In Right',
                'value' => 'slideInRight',
                'field_type' => 'entrance'
            ],
            [
                'type' => 'animation',
                'name' => 'Slide Out Right',
                'value' => 'slideOutRight',
                'field_type' => 'exit'
            ],
            [
                'type' => 'animation',
                'name' => 'Zoom In',
                'value' => 'zoomIn',
                'field_type' => 'entrance'
            ],
            [
                'type' => 'animation',
                'name' => 'Zoom Out',
                'value' => 'zoomOut',
                'field_type' => 'exit'
            ],
            [
                'type' => 'animation',
                'name' => 'Zoom In Down',
                'value' => 'zoomInDown',
                'field_type' => 'entrance'
            ],
            [
                'type' => 'animation',
                'name' => 'Zoom Out Down',
                'value' => 'zoomOutDown',
                'field_type' => 'exit'
            ],
            [
                'type' => 'animation',
                'name' => 'Zoom In Left',
                'value' => 'zoomInLeft',
                'field_type' => 'entrance'
            ],
            [
                'type' => 'animation',
                'name' => 'Zoom Out Left',
                'value' => 'zoomOutLeft',
                'field_type' => 'exit'
            ],
            [
                'type' => 'animation',
                'name' => 'Zoom In Right',
                'value' => 'zoomInRight',
                'field_type' => 'entrance'
            ],
            [
                'type' => 'animation',
                'name' => 'Zoom Out Right',
                'value' => 'zoomOutRight',
                'field_type' => 'exit'
            ],
            [
                'type' => 'animation',
                'name' => 'Zoom In Up',
                'value' => 'zoomInUp',
                'field_type' => 'entrance'
            ],
            [
                'type' => 'animation',
                'name' => 'Zoom Out Up',
                'value' => 'zoomOutUp',
                'field_type' => 'exit'
            ]
        ];

        DB::table('options')->insert($options);
    }
}
