@include('theme::'. $theme .'.layouts.partials.blocks', ['blocks' => json_decode($model->content)])
