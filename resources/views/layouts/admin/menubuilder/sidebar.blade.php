<div class="accordion" data-prevent-forms id="accordionExample">
    {{-- {{ dd($sidebar) }} --}}
    @foreach($sidebar as $collectionName => $collection)
        <div class="card">
            <div class="card-header" id="heading{{ Str::slug($collectionName, '-') }}-item">
                <h2 class="mb-0">
                    <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#{{ Str::slug($collectionName, '-') }}-item-collapse" aria-expanded="true" aria-controls="{{ Str::slug($collectionName, '-') }}-item-collapse">
                        {!! _i('block.'.$collectionName) !!}
                    </button>
                </h2>
            </div>

            <div id="{{ Str::slug($collectionName, '-') }}-item-collapse" class="collapse {{ $loop->first ? 'show' : '' }}" aria-labelledby="heading{{ Str::slug($collectionName, '-') }}-item" data-parent="#accordionExample">
                <div class="card-body">
                    {!! form($forms['form'.$collectionName], ['attr' => ['data-type-form' => Str::slug($collectionName, '-') ]]) !!}
                </div>
            </div>
      </div>
    @endforeach


  </div>
