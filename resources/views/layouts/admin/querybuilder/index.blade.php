@php
    $uniqid = Str::random(9);
@endphp
<input type="hidden" name="querybuilder" value=""/>
<div id="builder-{{ $uniqid }}"></div>

<script>
    window.admin.queryBuilder.push({
        selector: "builder-{{ $uniqid }}",
        multilang: {!! var_export(is_multilang(),true) !!},
        currentLang: '{!! $currentLang !!}'
    })
</script>